<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class FreeTrialController extends Controller
{
    /**
     * Show Start Trial Form
     */
    public function create(Request $request)
    {
        // 🔒 AUTH CHECK: Redirect logged-in users to checkout or dashboard
        if (auth()->check()) {
            $company = auth()->user()->company;
            if ($company && $company->status === 'pending') {
                return redirect()->route('subscriptions.checkout');
            }
            return redirect()->route('dashboard');
        }

        // Require a plan selection before allowing access to start-trial
        if (!$request->has('plan') || !in_array($request->plan, ['plan_basic', 'plan_pro'])) {
            return redirect('/#pricing')->with('error', 'Please choose a plan to start your 15-day free trial.');
        }

        return view('auth.start-trial');
    }

    /**
     * Handle Trial Signup
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                // Company
                'company_name'   => 'required|string|unique:companies,name|max:255',
                'address'        => 'required|string|max:1000',
                'company_email'  => 'required|email|unique:companies,email',
                'phone'          => 'required|string|max:20',
                'gstin'          => 'nullable|string|max:20|unique:companies,gstin',
                'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

                // Admin
                'name'           => 'required|string|max:255',
                'admin_email'    => 'required|email|unique:users,email',
                'password'       => 'required|min:4|confirmed',
            ]);

            DB::transaction(function () use ($request) {
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('logos', 'public');
                }

                // Company
                $company = Company::create([
                    'name'           => $request->company_name,
                    'slug'           => Str::slug($request->company_name) . '-' . uniqid(),
                    'address'        => $request->address,
                    'email'          => $request->company_email,
                    'phone'          => $request->phone,
                    'gstin'          => $request->gstin,
                    'logo'           => $logoPath,
                    'trial_ends_at'  => now()->addDays(15),
                    'selected_plan'  => $request->selected_plan ?? 'plan_basic',
                    'is_paid'        => false,
                    'status'         => 'pending',
                ]);

                // ✅ Create Default Roles (Admin role is usually created via Company observer or manually)
                // If not via observer, ensure it exists
                $adminRole = \App\Models\Role::firstOrCreate(
                    ['name' => 'admin', 'company_id' => $company->id]
                );

                \App\Models\Role::firstOrCreate(
                    ['name' => 'Client', 'company_id' => $company->id]
                );

                // Admin user
                $user = User::create([
                    'company_id' => $company->id,
                    'name'       => $request->name,
                    'email'      => $request->admin_email,
                    'password'   => Hash::make($request->password),
                ]);

                // ✅ Assign Admin Role
                $user->assignRole($adminRole);

                Auth::login($user);
            });

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account created successfully',
                    'redirect' => route('dashboard') // Fallback
                ]);
            }

            return redirect()->route('subscriptions.checkout');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }

}
