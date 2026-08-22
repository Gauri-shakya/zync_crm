<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\MyAttendance;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Task;
use App\Models\ClosedLead;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login.show');
        }

        $user = Auth::user();
        $companyId = $user->company_id;

        // Top-card counts
        $totalUsers    = User::where('company_id', $companyId)->count();
        $totalClients  = Client::where('company_id', $companyId)->count();
        $totalContacts = Contact::where('company_id', $companyId)->count();

        // Comparison Data (Growth vs Start of Month)
        // 1. Users Growth
        $usersLastMonthTotal = User::where('company_id', $companyId)
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();
        $userGrowth = $usersLastMonthTotal > 0 
            ? (($totalUsers - $usersLastMonthTotal) / $usersLastMonthTotal) * 100 
            : ($totalUsers > 0 ? 100 : 0);

        // 2. Clients Growth
        $clientsLastMonthTotal = Client::where('company_id', $companyId)
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();
        $clientGrowth = $clientsLastMonthTotal > 0 
            ? (($totalClients - $clientsLastMonthTotal) / $clientsLastMonthTotal) * 100 
            : ($totalClients > 0 ? 100 : 0);

        // 3. Contacts Growth
        $contactsLastMonthTotal = Contact::where('company_id', $companyId)
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();
        $contactGrowth = $contactsLastMonthTotal > 0 
            ? (($totalContacts - $contactsLastMonthTotal) / $contactsLastMonthTotal) * 100 
            : ($totalContacts > 0 ? 100 : 0);

        // Present employees for today:
        $presentToday = MyAttendance::where('company_id', $companyId)
            ->whereDate('date', Carbon::today())
            ->whereNotNull('punch_in')
            ->distinct('employee_id')
            ->count('employee_id');
        
        // Present employees yesterday:
        $presentYesterday = MyAttendance::where('company_id', $companyId)
            ->whereDate('date', Carbon::yesterday())
            ->whereNotNull('punch_in')
            ->distinct('employee_id')
            ->count('employee_id');

        $attendanceGrowth = $presentYesterday > 0 
            ? (($presentToday - $presentYesterday) / $presentYesterday) * 100 
            : ($presentToday > 0 ? 100 : 0);

        // Chart data: last 12 months (labels & two datasets)
        $usersChartLabels = [];
        $usersChartData   = [];
        $attChartLabels   = [];
        $attChartData     = [];

        // iterate from 11 months ago -> this month
        for ($i = 11; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $label = $dt->format('M Y'); // e.g. "Dec 2025"
            $year = $dt->year;
            $month = $dt->month;

            // users created in that month
            $usersCount = User::where('company_id', $companyId)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            // attendance count in that month (you can change to distinct employees if needed)
            $attCount = MyAttendance::where('company_id', $companyId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->count();

            $usersChartLabels[] = $label;
            $usersChartData[]   = $usersCount;

            $attChartLabels[] = $label;
            $attChartData[]   = $attCount;
        }

        // Recent activity (tasks) - latest 6
        $recentTasks = Task::where('company_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
            
        // Pending Payment Notifications (Closed Leads)
        $pendingPaymentsQuery = ClosedLead::with(['lead.client'])
            ->where('company_id', $companyId)
            ->where('due_amount', '>', 0)
            ->where('is_due_dismissed', false)
            ->whereNotNull('next_payment_date');
            
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin')) {
            $pendingPaymentsQuery->where('user_id', Auth::id());
        }
        
        $pendingPayments = $pendingPaymentsQuery->orderBy('next_payment_date', 'asc')->get();

        // Detailed lists for sidebar
        $usersList = User::with('roles')->where('company_id', $companyId)->get(['id', 'name', 'email']);
        
        $usersList = $usersList->map(function($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->pluck('name')->first() ?? 'User'
            ];
        });
         
        $attendanceList = MyAttendance::with('employee')
            ->where('company_id', $companyId)
            ->whereDate('date', Carbon::today())
            ->whereNotNull('punch_in')
            ->get();

        $attendanceList = $attendanceList->map(function($att) {
            return [
                'employee' => $att->employee ? ['name' => $att->employee->name] : null,
                'punch_in' => $att->punch_in
            ];
        });

        $clientsList = Client::where('company_id', $companyId)->get(['company_name', 'industry', 'status']);
        
        $contactsList = Contact::where('company_id', $companyId)->get(['name', 'phone', 'email']);

        return view('admin.dashboard', compact(
            'totalUsers',
            'presentToday',
            'totalClients',
            'totalContacts',
            'usersChartLabels',
            'usersChartData',
            'attChartLabels',
            'attChartData',
            'recentTasks',
            'pendingPayments',
            'userGrowth',
            'clientGrowth',
            'contactGrowth',
            'attendanceGrowth',
            'usersList',
            'attendanceList',
            'clientsList',
            'contactsList'
        ));
    }

    public function updatePreferences(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.show');
        }

        $request->validate([
            'dashboard_cards' => 'nullable|array',
            'dashboard_cards.*' => 'string'
        ]);

        $user = Auth::user();
        $user->update([
            'dashboard_preferences' => $request->dashboard_cards ?? []
        ]);

        return redirect()->back()->with('success', 'Dashboard preferences updated successfully!');
    }

    public function dismissPendingPayment(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $closedLead = ClosedLead::findOrFail($id);
        
        // Ensure user owns it or is admin
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin') && $closedLead->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $closedLead->update(['is_due_dismissed' => true]);

        return response()->json(['success' => true, 'message' => 'Notification dismissed']);
    }
}
