<?php

namespace App\Http\Controllers;

use App\Models\MyAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class MyAttendanceController extends Controller
{
    // const OFFICE_LAT = 28.618711;
    // const OFFICE_LON = 77.389686;
    const ALLOWED_DISTANCE_KM = 0.5;

    private function formatDuration($seconds)
    {
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    private function baseQuery()
    {
        return MyAttendance::where('company_id', auth()->user()->company_id);
    }

    public function updateCompanyDetails(Request $request)
    {
        try {
            // Ensure only admin or authorized user can update company details
            // Assuming 'admin' role or similar check. You might want to adjust this based on your roles.
            // For now, we'll allow it if the user is associated with the company, but ideally check for admin role.
            // if (!Auth::user()->hasRole('admin')) { return response()->json(['error' => 'Unauthorized'], 403); }

            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'total_working_days' => 'required|numeric',
                'office_start_time' => 'required',
                'office_end_time' => 'required',
                'office_ip_address' => 'nullable|ip',
            ]);

            $company = Auth::user()->company;
            if (!$company) {
                return response()->json(['error' => 'Company not found.'], 404);
            }

            $company->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'total_working_days' => $request->total_working_days,
                'office_start_time' => $request->office_start_time,
                'office_end_time' => $request->office_end_time,
                'office_ip_address' => $request->office_ip_address,
            ]);

            return response()->json(['success' => true, 'message' => 'Company details updated successfully.']);

        } catch (\Exception $e) {
            Log::error('Update Company Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $employee = Auth::user();
            if (!$employee) {
                abort(403, 'Authentication required.');
            }

            $company = $employee->company;
            $companyDetailsMissing = false;

            if ($company) {
                 if (is_null($company->latitude) || is_null($company->longitude) || is_null($company->total_working_days) || is_null($company->office_start_time) || is_null($company->office_end_time)) {
                    $companyDetailsMissing = true;
                }
            }

            $employeeId = $employee->id;
            $today = Carbon::today('Asia/Kolkata');

            /* ──────────────────────────────
             | PROFILE DATA
             ────────────────────────────── */
            $profile = [
                'name' => $employee->name ?? 'Employee',
                'role' => $employee->role ?? 'Employee',
                'company' => $employee->company?->name ?? 'Company',
                'employee_id' => $employee->employee_id ?? 'EMP-001',
                'department' => $employee->department ?? 'General',
                'join_date' => $employee->join_date
                    ? Carbon::parse($employee->join_date)->format('d M Y')
                    : 'N/A',
                'avatar' => $employee->avatar
                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->name),
            ];

            /* ──────────────────────────────
             | TODAY RECORD
             ────────────────────────────── */
            $todayRecord = $this->baseQuery()
                ->where('employee_id', $employeeId)
                ->whereDate('date', $today)
                ->with('breaks')
                ->first();


            /* ──────────────────────────────
             | JS DATA
             ────────────────────────────── */
            $jsAttendanceData = [
                'punchIn' => $todayRecord?->punch_in
                    ? Carbon::parse($todayRecord->punch_in)->format('h:i A')
                    : null,
                'punchOut' => $todayRecord?->punch_out
                    ? Carbon::parse($todayRecord->punch_out)->format('h:i A')
                    : null,
                'breakRunning' => $todayRecord
                    ? $todayRecord->breaks()->whereNull('break_out')->exists()
                    : false,
            ];

            /* ──────────────────────────────
             | MONTHLY DATA
             ────────────────────────────── */
            $currentMonth = $request->get('month', $today->month);
            $currentYear = $today->year;

            $monthRecords = $this->baseQuery()
                ->where('employee_id', $employeeId)
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->with('breaks')
                ->orderBy('date', 'desc')
                ->get();


            $presentDays = $monthRecords->where('status', 'Present')->count();
            $absentDays = $monthRecords->where('status', 'Absent')->count();
            $totalDays = $monthRecords->count();

            $attendancePercentage = $totalDays > 0
                ? round(($presentDays / $totalDays) * 100)
                : 0;

            /* ──────────────────────────────
             | 🔧 FIX-2: MONTHLY WORK HOURS
             ────────────────────────────── */
            $totalWorkSeconds = 0;

            foreach ($monthRecords as $record) {
                if ($record->punch_in && $record->punch_out) {
                    $recordDate = $record->date->format('Y-m-d');
                    $in = Carbon::parse($recordDate . ' ' . $record->punch_in, 'Asia/Kolkata');
                    $out = Carbon::parse($recordDate . ' ' . $record->punch_out, 'Asia/Kolkata');

                    $workedSeconds = max(0, $out->timestamp - $in->timestamp);
                    $breakSeconds = (int)$record->breaks()->sum('break_seconds');
                    $netSeconds = max(0, $workedSeconds - $breakSeconds);
                    $totalWorkSeconds += $netSeconds;
                }
            }


            /* ──────────────────────────────
             | 🔧 FIX-3: TODAY PROGRESS
             ────────────────────────────── */
            $todayProgress = 0;
            $todayNetSeconds = 0;

            if ($todayRecord && $todayRecord->punch_in) {
                $recordDate = $todayRecord->date->format('Y-m-d');
                $start = Carbon::parse($recordDate . ' ' . $todayRecord->punch_in, 'Asia/Kolkata');
                $end = $todayRecord->punch_out
                    ? Carbon::parse($recordDate . ' ' . $todayRecord->punch_out, 'Asia/Kolkata')
                    : Carbon::now('Asia/Kolkata');

                $workedSeconds = max(0, $end->timestamp - $start->timestamp);
                $breakSeconds = (int)$todayRecord->breaks()->sum('break_seconds');
                $netSeconds = max(0, $workedSeconds - $breakSeconds);

                // 8 hours = 28800 seconds
                $todayProgress = min(($netSeconds / 28800) * 100, 100);
                $todayNetSeconds = $netSeconds;
            }

            $totalWorkSeconds += $todayNetSeconds;
            $totalHours = $this->formatDuration($totalWorkSeconds);

            /* ──────────────────────────────
             | ATTENDANCE LOG
             ────────────────────────────── */
            $attendanceLog = $monthRecords->map(function ($record) {

                $breaksFormatted = $record->breaks->map(function ($b) {
                    $in = Carbon::parse($b->break_in)->format('h:i A');
                    $out = $b->break_out
                        ? Carbon::parse($b->break_out)->format('h:i A')
                        : 'Running';

                    return "$in - $out";
                });

                return [
                    'date' => $record->date->format('d-m-Y'),
                    'punchIn' => $record->punch_in ? Carbon::parse($record->punch_in)->format('h:i A') : '--',
                    'punchOut' => $record->punch_out ? Carbon::parse($record->punch_out)->format('h:i A') : '--',
                    'workHours' => $record->work_hours ?? '--',
                    'breaks' => $breaksFormatted->values(),
                    'totalBreak' => $this->formatDuration($record->breaks->sum('break_seconds')),
                    'status' => $record->status,
                ];
            });

            /* ──────────────────────────────
             | TODAY TOTAL BREAK
             ────────────────────────────── */
            $todayBreakDuration = '00:00';

            if ($todayRecord) {
                $todayBreakSeconds = (int)$todayRecord->breaks()->sum('break_seconds');
                $todayBreakDuration = $this->formatDuration($todayBreakSeconds);
            }

            return view('admin.myattendance', compact(
                'profile',
                'presentDays',
                'absentDays',
                'totalHours',
                'attendancePercentage',
                'todayProgress',
                'todayNetSeconds',
                'attendanceLog',
                'currentMonth',
                'todayRecord',
                'jsAttendanceData',
                'todayBreakDuration',
                'companyDetailsMissing',
                'company'
            ));

        } catch (\Exception $e) {
            Log::error('Attendance index error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }


    /**
     * Calculate distance using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        try {
            $earthRadius = 6371; // kilometers

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;

            return round($distance, 2);
        } catch (\Exception $e) {
            Log::error('Distance calculation error: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Process location data
     */


    /**
     * Process location data with database field check
     */
    private function processLocationData($request)
    {
        try {
            $defaultLocation = 'Location not available';
            $employee = Auth::user(); // Added this to get company details

            // 1. Check Wi-Fi IP first (Combo logic)
            $officeIp = $employee->company->office_ip_address ?? null;
            $userIp = $request->header('CF-Connecting-IP') ?? $request->header('X-Forwarded-For') ?? $request->ip();
            if (str_contains($userIp, ',')) {
                $userIp = trim(explode(',', $userIp)[0]);
            }

            \Log::info("IP Check: User IP = '{$userIp}', Office IP = '{$officeIp}'");

            // Check if already punched in with Wi-Fi today
            $today = \Carbon\Carbon::today('Asia/Kolkata');
            $existingAttendance = \App\Models\MyAttendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            $punchedInViaWifi = $existingAttendance && $existingAttendance->location === 'Office Wi-Fi';

            if (($officeIp && $userIp === $officeIp) || $punchedInViaWifi) {
                return [
                    'location' => 'Office Wi-Fi',
                    'latitude' => $request->latitude ?? null,
                    'longitude' => $request->longitude ?? null,
                    'accuracy' => $request->accuracy ?? null,
                    'distance' => 0,
                    'is_within_range' => true
                ];
            }

            // 2. Fallback to GPS Location Check
            // If IP check failed, and NO location coordinates are provided,
            // we MUST request location from the frontend.
            if (!$request->latitude || !$request->longitude) {
                return [
                    'location_required' => true,
                    'is_within_range' => false
                ];
            }

            $distance = $this->calculateDistance(
                $request->latitude,
                $request->longitude,
                $employee->company->latitude ?? 0,
                $employee->company->longitude ?? 0
            );

            $isWithinRange = $distance <= self::ALLOWED_DISTANCE_KM;

            $locationString = sprintf(
                "Lat: %s, Lng: %s, Dist: %skm, Acc: %sm %s",
                $request->latitude,
                $request->longitude,
                $distance,
                $request->accuracy ?? 'N/A',
                $isWithinRange ? '✅' : '❌'
            );

            return [
                'location' => $locationString,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $request->accuracy,
                'distance' => $distance,
                'is_within_range' => $isWithinRange
            ];
        } catch (\Exception $e) {
            Log::error('Location processing error: ' . $e->getMessage());
            return [
                'location' => $request->location ?? $defaultLocation,
                'latitude' => null,
                'longitude' => null,
                'accuracy' => null,
                'distance' => null,
                'is_within_range' => false
            ];
        }
    }


    public function punchIn(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }


            Log::info('Punch In Request:', $request->all());

            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');

            // Check existing record
            $existing = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();

            if ($existing && !empty($existing->punch_in)) {
                return response()->json(['error' => 'Already punched in today!'], 400);
            }

            $punchTime = Carbon::now('Asia/Kolkata');

            // Process location data with fallback
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }

            // Create or update record without location fields first
            if (!$existing) {
                $attendanceData = [
                    'employee_id' => $employee->id,
                    'date' => $today,
                    'punch_in' => $punchTime->format('H:i:s'),
                    'location' => $locationData['location'],
                    'status' => 'Present',
                ];

                // Only add location fields if they exist in database
                if (Schema::hasColumn('my_attendances', 'latitude')) {
                    $attendanceData['latitude'] = $locationData['latitude'];
                    $attendanceData['longitude'] = $locationData['longitude'];
                    $attendanceData['accuracy'] = $locationData['accuracy'];
                    $attendanceData['distance'] = $locationData['distance'];
                    // $attendanceData['is_within_range'] = $locationData['is_within_range'];
                }

                MyAttendance::create($attendanceData);
            } else {
                $updateData = [
                    'punch_in' => $punchTime->format('H:i:s'),
                    'location' => $locationData['location'],
                    'status' => 'Present'
                ];

                // Only update location fields if they exist in database
                if (Schema::hasColumn('my_attendances', 'latitude')) {
                    $updateData['latitude'] = $locationData['latitude'];
                    $updateData['longitude'] = $locationData['longitude'];
                    $updateData['accuracy'] = $locationData['accuracy'];
                    $updateData['distance'] = $locationData['distance'];
                    // $updateData['is_within_range'] = $locationData['is_within_range'];
                }

                $existing->update($updateData);
            }

            Log::info('Punch In Successful', [
                'employee_id' => $employee->id,
                'punch_time' => $punchTime->format('H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'punch_time' => $punchTime->format('h:i A'),
                'location' => $locationData['location'],
                'distance' => $locationData['distance'],
                'is_within_range' => $locationData['is_within_range']
            ]);

        } catch (\Exception $e) {
            Log::error('Punch In Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Similar error handling for other methods (punchOut, lunchStart, lunchEnd)
    public function punchOut(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }
            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');

            $attendance = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->with('breaks')
                ->first();


            if (!$attendance || !$attendance->punch_in) {
                return response()->json(['error' => 'Punch in first!'], 400);
            }

            $punchOutTime = Carbon::now('Asia/Kolkata');
            $recordDate = $attendance->date->format('Y-m-d');
            $punchInTime = Carbon::parse($recordDate . ' ' . $attendance->punch_in, 'Asia/Kolkata');

            // ✅ Total worked seconds using timestamp for absolute precision
            $totalSeconds = max(0, $punchOutTime->timestamp - $punchInTime->timestamp);

            // ✅ Subtract ALL breaks
            $totalBreakSeconds = (int)$attendance->breaks()->sum('break_seconds');
            $netWorkSeconds = max(0, $totalSeconds - $totalBreakSeconds);

            // ✅ Format values using the new helper for consistent HH:MM:SS
            $workHours = $this->formatDuration($netWorkSeconds);
            $breakHours = $this->formatDuration($totalBreakSeconds);

            // ✅ Status logic
            $status = $netWorkSeconds < 25200 ? 'Half Day' : 'Present'; // < 7 hrs

            $attendance->update([
                'punch_out' => $punchOutTime->format('H:i:s'),
                'work_hours' => $workHours,
                'break_hours' => $breakHours,
                'overtime_seconds' => max(0, $netWorkSeconds - 28800),
                'status' => $status,
            ]);

            return response()->json([
                'success' => true,
                'punch_time' => $punchOutTime->format('h:i A'),
                'work_hours' => $workHours,
                'total_break_time' => $breakHours,
            ]);

        } catch (\Exception $e) {
            Log::error('Punch Out Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }


    public function lunchStart(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }

            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');
            $record = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->first();

            if (!$record || !$record->punch_in) {
                return response()->json(['error' => 'Punch in first!'], 400);
            }

            if ($record->lunch_start) {
                return response()->json(['error' => 'Lunch already started!'], 400);
            }

            $lunchTime = Carbon::now('Asia/Kolkata');

            $updateData = [
                'lunch_start' => $lunchTime->format('H:i:s'),
                'location' => $locationData['location'],
            ];

            // Only update location fields if they exist in database
            if (Schema::hasColumn('my_attendances', 'latitude')) {
                $updateData['latitude'] = $locationData['latitude'];
                $updateData['longitude'] = $locationData['longitude'];
                $updateData['accuracy'] = $locationData['accuracy'];
                $updateData['distance'] = $locationData['distance'];
                $updateData['is_within_range'] = $locationData['is_within_range'];
            }

            $record->update($updateData);

            return response()->json([
                'success' => true,
                'lunch_time' => $lunchTime->format('h:i A'),
                'distance' => $locationData['distance'],
                'is_within_range' => $locationData['is_within_range']
            ]);

        } catch (\Exception $e) {
            Log::error('Lunch Start Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function lunchEnd(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }

            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');
            $record = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->first();

            if (!$record || !$record->lunch_start) {
                return response()->json(['error' => 'Start lunch first!'], 400);
            }

            $lunchTime = Carbon::now('Asia/Kolkata');

            $updateData = [
                'lunch_end' => $lunchTime->format('H:i:s'),
                'location' => $locationData['location'],
            ];

            // Only update location fields if they exist in database
            if (Schema::hasColumn('my_attendances', 'latitude')) {
                $updateData['latitude'] = $locationData['latitude'];
                $updateData['longitude'] = $locationData['longitude'];
                $updateData['accuracy'] = $locationData['accuracy'];
                $updateData['distance'] = $locationData['distance'];
                $updateData['is_within_range'] = $locationData['is_within_range'];
            }

            $record->update($updateData);

            return response()->json([
                'success' => true,
                'lunch_time' => $lunchTime->format('h:i A'),
                'distance' => $locationData['distance'],
                'is_within_range' => $locationData['is_within_range']
            ]);

        } catch (\Exception $e) {
            Log::error('Lunch End Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function getLog(Request $request)
    {
        try {
            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $month = $request->get('month', now()->month);
            $year = $request->get('year', now()->year);

            $records = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->with('breaks')
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($record) {
                    $breaksFormatted = $record->breaks->map(function ($b) {
                        $in = Carbon::parse($b->break_in)->format('h:i A');
                        $out = $b->break_out
                            ? Carbon::parse($b->break_out)->format('h:i A')
                            : 'Running';
                        return "$in - $out";
                    });

                    return [
                        'date' => $record->date->format('d-m-Y'),
                        'punchIn' => $record->punch_in ? Carbon::parse($record->punch_in)->format('h:i A') : '--',
                        'punchOut' => $record->punch_out ? Carbon::parse($record->punch_out)->format('h:i A') : '--',
                        'workHours' => $record->work_hours ?? '--',
                        'breaks' => $breaksFormatted->values(),
                        'totalBreak' => $this->formatDuration($record->breaks->sum('break_seconds')),
                        'status' => $record->status,
                    ];
                });

            return response()->json($records);

        } catch (\Exception $e) {
            Log::error('Get Log Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }


    /**
     * Check if action is allowed for the day
     */
    private function isActionAllowed($employeeId, $action)
    {
        $today = Carbon::today('Asia/Kolkata');
        $record = $this->baseQuery()
            ->where('employee_id', $employeeId)
            ->where('date', $today->format('Y-m-d'))
            ->first();

        if (!$record) {
            return true; // No record exists, all actions allowed
        }

        $limits = [
            'punch_in' => !$record->punch_in,
            'punch_out' => $record->punch_in && !$record->punch_out,
            'lunch_start' => $record->punch_in && !$record->lunch_start && !$record->punch_out,
            'lunch_end' => $record->lunch_start && !$record->lunch_end && !$record->punch_out,
        ];

        return $limits[$action] ?? false;
    }



    // private function isMobileRequest($request)
    // {
    //     $agent = $request->header('User-Agent');

    //     return preg_match('/Android|iPhone|iPad|iPod|Opera Mini|IEMobile|Mobile/i', $agent);
    // }


    private function isMobileRequest(Request $request)
    {
        // Always allow punching (IP/Location logic handles security)
        return true;
    }

    public function breakIn(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }
            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');

            // Find today's attendance record
            $attendance = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->first();

            $this->authorize('manage', $attendance);


            if (!$attendance) {
                return response()->json(['error' => 'Please punch in first!'], 400);
            }

            // Check if there's already an active break
            $activeBreak = $attendance->breaks()->whereNull('break_out')->first();
            if ($activeBreak) {
                return response()->json(['error' => 'Break already in progress!'], 400);
            }

            $breakTime = Carbon::now('Asia/Kolkata');


            // Create a new break record
            $break = $attendance->breaks()->create([
                'company_id' => auth()->user()->company_id,
                'break_in' => $breakTime->format('H:i:s'),
                'break_seconds' => 0,
            ]);


            Log::info('Break In Successful', [
                'employee_id' => $employee->id,
                'break_time' => $breakTime->format('H:i:s'),
                'break_id' => $break->id
            ]);

            return response()->json([
                'success' => true,
                'break_time' => $breakTime->format('h:i A'),
                'break_id' => $break->id,
                'location' => $locationData['location'],
                'distance' => $locationData['distance'],
                'is_within_range' => $locationData['is_within_range']
            ]);

        } catch (\Exception $e) {
            Log::error('Break In Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function breakOut(Request $request)
    {
        try {
            if (!$this->isMobileRequest($request)) {
                return response()->json(['error' => 'Punching allowed only from mobile devices'], 403);
            }
            $locationData = $this->processLocationData($request);
            if (isset($locationData['location_required']) && $locationData['location_required']) {
                return response()->json(['error' => 'location_required'], 428);
            }
            if (!$locationData['is_within_range']) {
                return response()->json(['error' => 'Out of allowed range (500m)'], 403);
            }
            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');

            // Find today's attendance record
            $attendance = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->first();

            $this->authorize('manage', $attendance);


            if (!$attendance) {
                return response()->json(['error' => 'No attendance record found!'], 400);
            }

            // Find the active break
            $activeBreak = $attendance->breaks()->whereNull('break_out')->first();
            if (!$activeBreak) {
                return response()->json(['error' => 'No active break found!'], 400);
            }


            $breakOutTime = Carbon::now('Asia/Kolkata');
            $recordDate = $attendance->date->format('Y-m-d');
            $breakInTime = Carbon::parse($recordDate . ' ' . $activeBreak->break_in, 'Asia/Kolkata');

            // Calculate break duration in seconds using timestamp
            $breakSeconds = max(0, $breakOutTime->timestamp - $breakInTime->timestamp);


            // Update the break record
            $activeBreak->update([
                'break_out' => $breakOutTime->format('H:i:s'),
                'break_seconds' => $breakSeconds
            ]);

            // Update total break seconds on attendance
            $attendance->refresh(); // Refresh to get updated breaks
            $totalBreakSeconds = $attendance->breaks()->sum('break_seconds');

            // Format total break time
            $totalBreakFormatted = $this->formatDuration($totalBreakSeconds);

            Log::info('Break Out Successful', [
                'employee_id' => $employee->id,
                'break_duration' => $breakSeconds,
                'total_break_seconds' => $totalBreakSeconds
            ]);

            return response()->json([
                'success' => true,
                'break_out_time' => $breakOutTime->format('h:i A'),
                'break_duration' => $this->formatDuration($breakSeconds),
                'total_break_time' => $totalBreakFormatted,
                'location' => $locationData['location'],
                'distance' => $locationData['distance'],
                'is_within_range' => $locationData['is_within_range']
            ]);

        } catch (\Exception $e) {
            Log::error('Break Out Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Add this method to your MyAttendanceController class
    /**
     * Get current break status for the authenticated user
     */
    public function getCurrentBreakStatus(Request $request)
    {
        try {
            $employee = Auth::user();
            if (!$employee) {
                return response()->json(['error' => 'Authentication required.'], 401);
            }

            $today = Carbon::today('Asia/Kolkata');

            // Find today's attendance record
            $attendance = $this->baseQuery()
                ->where('employee_id', $employee->id)
                ->where('date', $today->format('Y-m-d'))
                ->with([
                    'breaks' => function ($query) {
                        $query->whereNull('break_out')->latest();
                    }
                ])
                ->first();

            if (!$attendance) {
                return response()->json([
                    'has_attendance' => false,
                    'break_running' => false
                ]);
            }

            // Check if there's an active break
            $activeBreak = $attendance->breaks->first();
            $breakRunning = $activeBreak ? true : false;

            $response = [
                'has_attendance' => true,
                'break_running' => $breakRunning,
                'punch_in' => $attendance->punch_in,
                'punch_out' => $attendance->punch_out
            ];

            if ($breakRunning && $activeBreak) {
                $recordDate = $attendance->date->format('Y-m-d');
                $breakInTime = Carbon::parse($recordDate . ' ' . $activeBreak->break_in, 'Asia/Kolkata');
                $breakDuration = max(0, Carbon::now('Asia/Kolkata')->timestamp - $breakInTime->timestamp);

                $response['break_data'] = [
                    'break_id' => $activeBreak->id,
                    'break_in' => $activeBreak->break_in,
                    'break_duration_seconds' => $breakDuration,
                    'break_duration_formatted' => $this->formatDuration($breakDuration)
                ];
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Get Break Status Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }




}
