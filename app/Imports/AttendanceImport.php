<?php

namespace App\Imports;

use App\Models\MyAttendance;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceImport implements ToCollection, WithHeadingRow
{
    private $errors = [];
    private $rowsProcessed = 0;

    public function getErrors()
    {
        return $this->errors;
    }

    public function getRowCount()
    {
        return $this->rowsProcessed;
    }

    public function collection(Collection $rows)
    {
        $validRows = [];
        $employeeCache = [];

        // 1. Validation Pass
        foreach ($rows as $index => $row) {
            // Skip if employee_name or date is missing
            if (!isset($row['employee_name']) || !isset($row['date'])) {
                continue;
            }

            $employeeName = trim($row['employee_name']);
            
            // Check cache first
            if (isset($employeeCache[strtolower($employeeName)])) {
                $employee = $employeeCache[strtolower($employeeName)];
            } else {
                // Find employee by name and company_id (Case Insensitive)
                $employee = User::whereRaw('LOWER(name) = ?', [strtolower($employeeName)])
                    ->where('company_id', Auth::user()->company_id)
                    ->first();
                
                if ($employee) {
                    $employeeCache[strtolower($employeeName)] = $employee;
                }
            }

            if (!$employee) {
                $this->errors[] = "Row " . ($index + 2) . ": Employee not found '$employeeName'";
                continue;
            }

            // Store valid row with resolved employee
            $validRows[] = [
                'row' => $row,
                'employee' => $employee
            ];
        }

        // If there are any errors, do not process any records
        if (count($this->errors) > 0) {
            return;
        }

        // 2. Processing Pass
        foreach ($validRows as $data) {
            $this->processRow($data['row'], $data['employee']);
            $this->rowsProcessed++;
        }
    }

    private function cleanStatus($status)
    {
        if (empty($status)) return 'Present';
        
        // 1. Convert to string and trim
        $status = trim((string)$status);
        
        // 2. Replace all whitespace (including newlines, tabs, non-breaking spaces) with a single space
        $status = preg_replace('/\s+/u', ' ', $status);
        
        // 3. Remove any remaining control characters (including invisible ones)
        $status = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $status);
        
        return trim($status);
    }

    private function processRow($row, $employee)
    {
        $date = $this->transformDate($row['date']);
        
        // Format times (support 12h AM/PM)
        $punchIn = isset($row['punch_in']) ? $this->transformTime($row['punch_in']) : null;
        $punchOut = isset($row['punch_out']) ? $this->transformTime($row['punch_out']) : null;

        // Calculate work hours if both times exist
        $workHours = null;
        if ($punchIn && $punchOut) {
            $start = Carbon::parse($punchIn);
            $end = Carbon::parse($punchOut);
            $diff = $end->diff($start);
            $workHours = $diff->format('%H:%I:%S');
        }

        $status = isset($row['status']) ? $this->cleanStatus($row['status']) : 'Present';

        // Check if attendance already exists for this date
        $attendance = MyAttendance::where('employee_id', $employee->id)
            ->where('date', $date)
            ->first();

        if ($attendance) {
            // Update existing record
            $attendance->update([
                'punch_in' => $punchIn,
                'punch_out' => $punchOut,
                'work_hours' => $workHours,
                'status' => $status,
            ]);
        } else {
            // Create new record
            MyAttendance::create([
                'company_id' => Auth::user()->company_id,
                'employee_id' => $employee->id,
                'date' => $date,
                'punch_in' => $punchIn,
                'punch_out' => $punchOut,
                'work_hours' => $workHours,
                'status' => $status,
                'location' => 'Imported via Excel'
            ]);
        }
    }

    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            
            $value = trim($value);

            // User requested "date/month/year" format (DD/MM/YYYY)
            // Prioritize DD/MM/YYYY regex matching to avoid ambiguity with MM/DD/YYYY
            if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $value, $matches)) {
                // matches[1] = Day, matches[2] = Month, matches[3] = Year
                return Carbon::createFromDate($matches[3], $matches[2], $matches[1])->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error("Date Parse Error: $value");
            return Carbon::today()->format('Y-m-d');
        }
    }

    private function transformTime($value)
    {
        if (empty($value)) return null;

        try {
            // Excel numeric time (fraction of a day)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('H:i:s');
            }

            // Clean string
            $value = trim($value);
            
            // Try standard Carbon parsing (handles most formats including AM/PM)
            return Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
