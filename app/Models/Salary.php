<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Salary extends Model
{
    protected $fillable = [
        'company_id',
        'employee_id',
        'salary_month',
        'basic_salary',
        'total_allowances',
        'total_deductions',
        'overtime_amount',
        'net_salary',
        'total_present_days',
        'total_absent_days',
        'total_late_days',
        'total_half_days',
        'per_day_salary',
        'status',
        'payment_date',
        'notes'
    ];
    
    protected $dates = ['salary_month', 'payment_date'];


    protected static function booted()
    {
        static::creating(function ($salary) {
            if (auth()->check()) {
                $salary->company_id = auth()->user()->company_id;
            }
        });
    }
    
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    
    public function details()
    {
        return $this->hasMany(SalaryDetail::class);
    }
    
    // Add this method to calculate salary
   // In Salary.php model
// In Salary.php model
    public function calculateSalaryData($employee, $month, $year, $overrideBaseSalary = null)
    {
        // Get configuration or use defaults
        $config = SalaryConfig::where('company_id', $employee->company_id)->first();
        
        // Load company settings for total working days
        $company = Company::find($employee->company_id);
        
        // Default values
        $workingDaysPerMonth = $company->total_working_days ?? 22; // Fetch from company settings if available
        $overtimeRatePerHour = 0;
        $halfDayPercentage = 50;
        $deductForLate = false;
        $lateDeductionRate = 0;
        
        if ($config) {
            // Only override if config is specifically set, otherwise use company's total_working_days
            if (!empty($config->working_days_per_month)) {
                $workingDaysPerMonth = $config->working_days_per_month;
            }
            $overtimeRatePerHour = $config->overtime_rate_per_hour ?? 0;
            $halfDayPercentage = $config->half_day_percentage ?? 50;
            $deductForLate = $config->deduct_for_late;
            $lateDeductionRate = $config->late_deduction_rate;
        }
        
        // Determine base salary to use
        $employeeSalary = $overrideBaseSalary ?? $employee->salary ?? 0;
        
        // Calculate date range for the month
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        // Get attendance records for the month
        $attendances = MyAttendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
        
        // If the 'date' column doesn't exist, try 'created_at'
        if ($attendances->isEmpty()) {
            $attendances = MyAttendance::where('employee_id', $employee->id)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        }
        
        // Check if employee has ANY attendance records for the month
        if ($attendances->isEmpty()) {
            return [
                'employee_id' => $employee->id,
                'salary_month' => $startDate->format('Y-m-d'),
                'basic_salary' => $employeeSalary,
                'per_day_salary' => $employeeSalary / $workingDaysPerMonth,
                'total_present_days' => 0,
                'total_late_days' => 0,
                'total_half_days' => 0,
                'total_absent_days' => $workingDaysPerMonth, // All days considered absent
                'total_allowances' => 0,
                'total_deductions' => 0,
                'overtime_amount' => 0,
                'net_salary' => 0, // Salary will be 0 for no attendance
                'status' => 'pending',
                'details' => []
            ];
        }
        
        // Count attendance types based on your MyAttendance model status values
        $presentDays = 0;
        $lateDays = 0;
        $halfDays = 0;
        $absentDays = 0;
        
        foreach ($attendances as $attendance) {
            $status = strtolower(trim($attendance->status));
            
            if (str_contains($status, 'present')) {
                $presentDays++;
            } elseif (str_contains($status, 'late')) {
                $lateDays++;
            } elseif (str_contains($status, 'half') || str_contains($status, 'half_day')) {
                $halfDays++;
            } elseif (str_contains($status, 'absent')) {
                $absentDays++;
            } else {
                // If status is empty or unknown, count as absent
                $absentDays++;
            }
        }
        
        // Calculate total attended days (Present + Late count as full days, Half Days count as 1 day attended for record keeping)
        $totalAttendedDaysCount = $presentDays + $lateDays + $halfDays;
        
        // Recalculate absent days based on working days
        // Absent Days = Total Working Days - Total days with attendance activity
        $absentDays = max(0, $workingDaysPerMonth - $totalAttendedDaysCount);
        
        // Calculate per day salary
        $perDaySalary = round($employeeSalary / $workingDaysPerMonth, 2);
        
        // Calculate base salary for present days
        $presentSalary = round($presentDays * $perDaySalary, 2);
        
        // Calculate salary for half days (percentage of daily salary based on config)
        $halfDaySalary = round($halfDays * ($perDaySalary * ($halfDayPercentage / 100)), 2);
        
        // Calculate salary for late days
        $lateSalary = round($lateDays * $perDaySalary, 2);
        if ($deductForLate) {
            $lateSalary = round($lateDays * ($perDaySalary * (1 - $lateDeductionRate / 100)), 2);
        }
        
        // Calculate overtime - check if overtime_seconds exists in your model
        $totalOvertimeSeconds = 0;
        $overtimeAmount = 0;
        
        if (isset($attendances->first()->overtime_seconds)) {
            $totalOvertimeSeconds = $attendances->sum('overtime_seconds');
            $overtimeHours = $totalOvertimeSeconds / 3600;
            $overtimeAmount = round($overtimeHours * $overtimeRatePerHour, 2);
        }
        
        // Calculate allowances (you can customize these)
        $baseSalary = $presentSalary + $halfDaySalary + $lateSalary;
        
        // Only calculate allowances if there are working days
        $housingAllowance = 0;
        $transportAllowance = 0;
        $medicalAllowance = 0;
        $totalAllowances = 0;
        
        if ($baseSalary > 0) {
            // Allowances disabled by request
            $housingAllowance = 0; 
            $transportAllowance = 0;
            $medicalAllowance = 0;
            $totalAllowances = 0;
        }
        
        // Calculate deductions (only if there are working days)
        $tax = 0;
        $providentFund = 0;
        $totalDeductions = 0;
        
        if ($baseSalary > 0) {
            // Deductions disabled by request
            $tax = 0; 
            $providentFund = 0; 
            $totalDeductions = 0;
        }
        
        // Calculate net salary
        $netSalary = round($baseSalary + $totalAllowances + $overtimeAmount - $totalDeductions, 2);

        // Prepare details array
        $details = [];
        if ($baseSalary > 0) {
            if ($housingAllowance > 0) $details[] = ['type' => 'allowance', 'description' => 'Housing Allowance', 'amount' => $housingAllowance];
            if ($transportAllowance > 0) $details[] = ['type' => 'allowance', 'description' => 'Transport Allowance', 'amount' => $transportAllowance];
            if ($medicalAllowance > 0) $details[] = ['type' => 'allowance', 'description' => 'Medical Allowance', 'amount' => $medicalAllowance];
            if ($tax > 0) $details[] = ['type' => 'deduction', 'description' => 'Income Tax', 'amount' => $tax];
            if ($providentFund > 0) $details[] = ['type' => 'deduction', 'description' => 'Provident Fund', 'amount' => $providentFund];
            if ($overtimeAmount > 0) $details[] = ['type' => 'allowance', 'description' => 'Overtime Payment', 'amount' => $overtimeAmount];
        }

        return [
            'employee_id' => $employee->id,
            'salary_month' => $startDate->format('Y-m-d'),
            'basic_salary' => $employeeSalary,
            'per_day_salary' => $perDaySalary,
            'total_present_days' => $presentDays,
            'total_late_days' => $lateDays,
            'total_half_days' => $halfDays,
            'total_absent_days' => $absentDays,
            'total_allowances' => $totalAllowances,
            'total_deductions' => $totalDeductions,
            'overtime_amount' => $overtimeAmount,
            'net_salary' => $netSalary,
            'total_working_days' => $workingDaysPerMonth,
            'status' => 'pending',
            'details' => $details
        ];
    }

    public function calculateSalary($employee, $month, $year)
    {
        $data = $this->calculateSalaryData($employee, $month, $year);
        $details = $data['details'];
        unset($data['details']); // Remove details from main salary data

        // Create salary record
        $salary = $this->create($data);
        
        // Save salary breakdown details
        if (!empty($details)) {
            $salary->details()->createMany($details);
        }
        
        // Load the employee relationship
        $salary->load('employee');
        
        return $salary;
    }

}