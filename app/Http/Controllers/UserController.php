<?php
// Updated UserController with fixes for parameter binding consistency
// Changed edit to use User $user, destroy and update already use User $user
// Added missing imports if needed, but assuming they are there

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // List all users
    public function index()
{
    $companyId = auth()->user()->company_id;
    $users = User::where('company_id', $companyId)->get();
    
    // Check if any non-client roles exist for this company
    $hasNonClientRoles = Role::forCompany($companyId)
        ->whereRaw('LOWER(name) <> ?', ['client'])
        ->exists();

    return view('admin.user.users', compact('users', 'hasNonClientRoles'));
}


    // Show create form
    public function create()
    {
        $authUser = Auth::user();
        if (!$authUser) {
            abort(401);
        }
        $companyId = $authUser->company_id;
        $rolesQuery = Role::forCompany($companyId);

        $adminRole = Role::forCompany($companyId)
            ->whereRaw('LOWER(name) = ?', ['admin'])
            ->first();

        if ($adminRole) {
            $adminExists = User::where('company_id', $companyId)
                ->whereHas('roles', fn($q) => $q->where('id', $adminRole->id))
                ->exists();
            if ($adminExists) {
                $rolesQuery->whereRaw('LOWER(name) <> ?', ['admin']);
            }
        }

        $roles = $rolesQuery->get();
        $permissions = \Spatie\Permission\Models\Permission::all(); // Fetch all permissions using the correct Spatie class
        
        return view('admin.user.addusers', compact('roles', 'permissions'));
    }

    // Store new user
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'salary' => 'nullable|numeric',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $authUser = Auth::user();
        if (!$authUser) {
            abort(401);
        }

        $requestedRoles = (array) $request->input('roles', []);
        if (count($requestedRoles) > 1) {
            return back()->withErrors(['roles' => 'Only one role can be assigned per user.'])->withInput();
        }
        if (!empty($requestedRoles)) {
            $rolesForCompany = Role::forCompany($authUser->company_id)
                ->whereIn('id', $requestedRoles)
                ->get();
            $adminRole = $rolesForCompany->first(function ($r) {
                return strtolower($r->name) === 'admin';
            });
            if ($adminRole) {
                $adminExists = User::where('company_id', $authUser->company_id)
                    ->whereHas('roles', function ($q) use ($adminRole) {
                        $q->where('id', $adminRole->id);
                    })
                    ->exists();
                if ($adminExists) {
                    return back()->withErrors(['roles' => 'An admin already exists for this company.'])->withInput();
                }
            }
        }

        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'company_id' => $authUser->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'salary' => $request->salary,
            'profile_image' => $profileImagePath,
        ]);

        if (!empty($requestedRoles)) {
            $roles = Role::forCompany($authUser->company_id)
                ->whereIn('id', $requestedRoles)
                ->get();
            $user->syncRoles($roles);
        }

        return redirect()->route('users')->with('success', 'User created successfully!');
    }


    // Show a specific user
    public function show(User $user)
    {
        $this->authorize('manage', $user);

        return view('admin.user.showusers', compact('user'));
    }

    // Show edit form
    public function edit(User $user)  // Changed to User $user for consistency
    {
         $this->authorize('manage', $user);
        $authUser = Auth::user();
        if (!$authUser) {
            abort(401);
        }
        $companyId = $authUser->company_id;

        $rolesQuery = Role::forCompany($companyId);
        $adminRole = Role::forCompany($companyId)
            ->whereRaw('LOWER(name) = ?', ['admin'])
            ->first();

        if ($adminRole) {
            $existingAdmin = User::where('company_id', $companyId)
                ->whereHas('roles', fn($q) => $q->where('id', $adminRole->id))
                ->first();
            if ($existingAdmin && $existingAdmin->id !== $user->id) {
                $rolesQuery->whereRaw('LOWER(name) <> ?', ['admin']);
            }
        }

        $roles = $rolesQuery->get();
        return view('admin.user.editusers', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $this->authorize('manage', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',  // Made password optional for updates
            'salary' => 'nullable|numeric',  // Made salary optional if not always updated
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Enforce single role selection and one admin per company on update
        if ($request->has('roles')) {
            $requestedRoles = (array) $request->input('roles', []);
            if (count($requestedRoles) > 1) {
                return back()->withErrors(['roles' => 'Only one role can be assigned per user.'])->withInput();
            }
            if (!empty($requestedRoles)) {
                $rolesForCompany = Role::forCompany(Auth::user()->company_id)
                    ->whereIn('id', $requestedRoles)
                    ->get();
                $adminRole = $rolesForCompany->first(function ($r) {
                    return strtolower($r->name) === 'admin';
                });
                if ($adminRole) {
                    $existingAdmin = User::where('company_id', Auth::user()->company_id)
                        ->whereHas('roles', fn($q) => $q->where('id', $adminRole->id))
                        ->first();
                    if ($existingAdmin && $existingAdmin->id !== $user->id) {
                        return back()->withErrors(['roles' => 'An admin already exists for this company.'])->withInput();
                    }
                }
            }
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($request->filled('salary')) {
            $updateData['salary'] = $request->salary;
        }

        if ($request->hasFile('profile_image')) {
            $updateData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($updateData);

        if ($request->has('roles')) {
            $roles = Role::forCompany(Auth::user()->company_id)
                ->whereIn('id', (array) $request->roles)
                ->get();
            $user->syncRoles($roles);
        }

        return redirect()->route('users')->with('success', 'User updated successfully!');
    }

    // Delete user
   public function destroy(User $user)
{
    $this->authorize('manage', $user);

    if (Auth::id() === $user->id) {
        return redirect()
            ->route('users')
            ->with('error', 'You cannot delete your own account.');
    }

    $user->delete();

    return redirect()
        ->route('users')
        ->with('success', 'User deleted successfully!');
}


}
