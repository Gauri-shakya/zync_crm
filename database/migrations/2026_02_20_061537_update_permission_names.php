<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            'attendance records' => 'Attendance Records',
            'edit lead' => 'Edit Lead',
            'my attendance' => 'My Attendance',
            'todo' => 'To-Do',
            'calender' => 'Calendar',
            'links and remark' => 'Links and Remarks',
            'client service interaction' => 'Client Service Interaction',
            'ticket raise' => 'Raise Ticket',
            'employeeportal' => 'Leave Apply',
            'project management' => 'Project Management',
        ];

        foreach ($permissions as $oldName => $newName) {
            DB::table('permissions')
                ->where('name', $oldName)
                ->update(['name' => $newName]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'Attendance Records' => 'attendance records',
            'Edit Lead' => 'edit lead',
            'My Attendance' => 'my attendance',
            'To-Do' => 'todo',
            'Calendar' => 'calender',
            'Links and Remarks' => 'links and remark',
            'Client Service Interaction' => 'client service interaction',
            'Raise Ticket' => 'ticket raise',
            'Leave Apply' => 'employeeportal',
            'Project Management' => 'project management',
        ];

        foreach ($permissions as $oldName => $newName) {
            DB::table('permissions')
                ->where('name', $oldName)
                ->update(['name' => $newName]);
        }
    }
};
