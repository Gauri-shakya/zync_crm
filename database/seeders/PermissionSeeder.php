<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard',
            'Attendance Records',
            'users',
            'roles',
            'Edit Lead',
            'besdex',
            'my leads',
            'proposal',
            'My Attendance',
            'To-Do',
            'task',
            'Calendar',
            'Links and Remarks',
            'Client Service Interaction',
            'salary',
            'invoice',
            'report',
            'notepad',
            'contact',
            'Raise Ticket',
            'Leave Record',
            'Leave Apply',
            'Project Management',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
