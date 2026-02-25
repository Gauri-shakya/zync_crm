<?php

namespace App\Http\Controllers;

use App\Models\MyAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\AttendanceImport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceRecordController extends Controller
{
    private function baseQuery()
    {
        return MyAttendance::where('company_id', auth()->user()->company_id);
    }

    public function index(Request $request)
    {
        // 0️⃣ Determine if a specific month is requested. If 'all', show all data.
        $showAll = false;
        
        if ($request->has('month') && $request->month === 'all') {
            $showAll = true;
            $currentMonthYear = 'All Time';
        } elseif ($request->has('month') && !empty($request->month)) {
            $now = Carbon::parse($request->month);
            $currentMonth = $now->month;
            $currentYear = $now->year;
            $currentMonthYear = $now->format('Y-m');
        } else {
            // Default to current month
            $now = Carbon::now();
            $currentMonth = $now->month;
            $currentYear = $now->year;
            $currentMonthYear = $now->format('Y-m');
        }
        
        // 1️⃣ Fetch attendance for current company & month (or all)
        $query = $this->baseQuery()->with('employee');

        if (!$showAll) {
            $query->whereYear('date', $currentYear)
                  ->whereMonth('date', $currentMonth);
        }

        $monthlyAttendances = $query->get();

        $totalRecords = $monthlyAttendances->count();

        // 2️⃣ Summary cards - Handle trimming, case-insensitivity, and hidden chars
        $totalPresent = $monthlyAttendances->filter(function ($record) {
            $status = strtolower(trim($record->status));
            // Remove non-breaking spaces and other invisible characters
            $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
            return $status === 'present' || $status === 'late';
        })->count();

        $totalAbsent = $monthlyAttendances->filter(function ($record) {
            $status = strtolower(trim($record->status));
            $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
            return $status === 'absent';
        })->count();

        $totalHalfDay = $monthlyAttendances->filter(function ($record) {
            $status = strtolower(trim($record->status));
            // Normalize spaces (e.g., "Half  Day" -> "half day")
            $status = preg_replace('/\s+/', ' ', $status);
            $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
            return $status === 'half day' || $status === 'halfday';
        })->count();

        $totalEmployees = $monthlyAttendances->unique('employee_id')->count();


        // Count employees present TODAY
        $today = Carbon::today();
        $presentToday = $this->baseQuery()
            ->whereDate('date', $today)
            ->get()
            ->filter(function ($record) {
                $status = strtolower(trim($record->status));
                $status = preg_replace('/\s+/', ' ', $status);
                $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
                return $status === 'present' || $status === 'late';
            })
            ->unique('employee_id')
            ->count();

        // Count total clients for this company
        $totalClients = \App\Models\Client::where('company_id', auth()->user()->company_id)->count();

        // Count total contacts for this company
        $totalContacts = \App\Models\Contact::where('company_id', auth()->user()->company_id)->count();


        $totalSummary = [
            'total_employees' => $totalEmployees,
            'total_records' => $totalRecords,
            'present_today' => $presentToday,
            'total_clients' => $totalClients,
            'total_contacts' => $totalContacts,
            'present_count' => $totalPresent,
            'absent_count' => $totalAbsent,
            'half_day_count' => $totalHalfDay,

            'present_percent' => $totalRecords > 0
                ? round(($totalPresent / $totalRecords) * 100, 1)
                : 0,

            'absent_percent' => $totalRecords > 0
                ? round(($totalAbsent / $totalRecords) * 100, 1)
                : 0,

            'other_percent' => $totalRecords > 0
                ? round(($totalHalfDay / $totalRecords) * 100, 1)
                : 0,
        ];

        // 3️⃣ Per-employee summary
        $employeeSummaries = $monthlyAttendances
            ->groupBy('employee_id')
            ->map(function ($records) {
                $employee = $records->first()->employee;

                return [
                    'employee_id' => $employee->id ?? null,
                    'employee_name' => $employee->name ?? 'N/A',
                    'present_count' => $records->filter(function ($r) {
                        $status = strtolower(trim($r->status));
                        // Remove invisible characters
                        $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
                        return $status === 'present' || $status === 'late';
                    })->count(),
                    'absent_count' => $records->filter(function ($r) {
                        $status = strtolower(trim($r->status));
                        $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
                        return $status === 'absent';
                    })->count(),
                    'half_day_count' => $records->filter(function ($r) {
                        $status = strtolower(trim($r->status));
                        $status = preg_replace('/\s+/', ' ', $status);
                        $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
                        return $status === 'half day';
                    })->count(),
                ];
            })
            ->values()
            ->sortBy('employee_name');

        // 4️⃣ Employees dropdown
        $employees = $employeeSummaries
            ->map(fn($e) => [
                'id' => $e['employee_id'],
                'name' => $e['employee_name'],
            ])
            ->unique('id')
            ->values();

        return view('admin.attendancerecord', compact(
            'employeeSummaries',
            'employees',
            'totalSummary',
            'currentMonthYear'
        ));
    }

    /**
     * AJAX: Monthly attendance per employee
     */
    public function getMonthlyAttendance(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'month' => 'required',
        ]);

        $query = $this->baseQuery()
            ->where('employee_id', $request->employee_id);

        if ($request->month !== 'all') {
            // Validate format if not 'all'
            if (!preg_match('/^\d{4}-\d{2}$/', $request->month)) {
                return response()->json(['error' => 'Invalid month format'], 422);
            }
            
            $query->whereYear('date', substr($request->month, 0, 4))
                  ->whereMonth('date', substr($request->month, 5, 2));
        }

        return $query->orderBy('date', 'desc') // Show newest first for 'all'
            ->get()
            ->map(function ($record) {
                return [
                    'date'             => $record->date instanceof \Carbon\Carbon
                        ? $record->date->format('Y-m-d')
                        : $record->date,
                    'punch_in'         => $record->punch_in
                        ? \Carbon\Carbon::parse($record->punch_in)->format('h:i A')
                        : null,
                    'punch_out'        => $record->punch_out
                        ? \Carbon\Carbon::parse($record->punch_out)->format('h:i A')
                        : null,
                    'work_hours'       => $record->work_hours,
                    'overtime_seconds' => $record->overtime_seconds,
                    'status'           => trim($record->status),
                ];
            });
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            $importer = new AttendanceImport;
            Excel::import($importer, $request->file('file'));
            
            $errors = $importer->getErrors();
            $rowCount = $importer->getRowCount();

            if (count($errors) > 0) {
                return redirect()->back()->with('error', 'Import completed with issues: ' . implode(', ', array_unique($errors)));
            }

            if ($rowCount === 0) {
                return redirect()->back()->with('error', 'No valid attendance records found in the file.');
            }

            return redirect()->route('attendance-record.index', ['month' => 'all'])
                ->with('success', "Successfully imported $rowCount attendance records! Showing all records.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Attendance Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error importing attendance: ' . $e->getMessage());
        }
    }

    public function downloadSample()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="attendance_sample.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // Updated Headers: employee_name instead of email
            fputcsv($file, ['employee_name', 'date', 'punch_in', 'punch_out', 'status']);
            
            // Example 1: Multiple Days for Rohit
            fputcsv($file, ['Rohit', '15/01/2026', '09:00 AM', '06:00 PM', 'Present']);
            fputcsv($file, ['Rohit', '16/01/2026', '09:15 AM', '06:15 PM', 'Present']);
            
            // Example 2: Late (Rohit)
            fputcsv($file, ['Rohit', '17/01/2026', '10:30 AM', '06:30 PM', 'Late']);
            
            // Example 3: Half Day (Rohit)
            fputcsv($file, ['Rohit', '02/02/2026', '09:00 AM', '01:00 PM', 'Half Day']);
            
            // Example 4: Absent (Rohit - Times can be empty)
            fputcsv($file, ['Rohit', '03/02/2026', '', '', 'Absent']);

            // Example 5: Another Employee
            fputcsv($file, ['Jane Smith', '01/01/2026', '09:30 AM', '06:30 PM', 'Present']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
