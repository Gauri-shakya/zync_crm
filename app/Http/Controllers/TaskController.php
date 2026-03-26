<?php
// Controller: app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filterDate = $request->input('filter_date', \Carbon\Carbon::today()->format('Y-m-d'));
        $authUser = Auth::user();

        $query = Task::with('users', 'role', 'assigner.roles')
            ->where('company_id', $authUser->company_id)
            ->whereDate('due_date', $filterDate);

        // Visibility Logic:
        // 1. Admins see everything in their company
        // 2. Regular users only see tasks they CREATED (assigned_by)
        // 3. Regular users only see tasks ASSIGNED to them (individual or via role/team)
        if (!$authUser->hasRole('admin')) {
            $query->where(function ($q) use ($authUser) {
                $q->where('assigned_by', $authUser->id) // Created by me
                  ->orWhereHas('users', function ($u) use ($authUser) {
                      $u->where('users.id', $authUser->id); // Assigned to me individually
                  })
                  ->orWhere(function ($r) use ($authUser) {
                      $r->where('assigned_to_team', true)
                        ->where('assigned_role_id', '!=', null)
                        ->whereIn('assigned_role_id', $authUser->roles->pluck('id')); // Assigned to my team
                  });
            });
        }

        $tasks = $query->recent()->get();
        $users = User::with('roles')->where('company_id', $authUser->company_id)->get();
        $roles = Role::forCompany($authUser->company_id)->get();

        // Calculate stats
        $totalTasks = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $completed = $tasks->where('status', 'Completed')->count();


        return view('admin.task', compact(
            'tasks',
            'users',
            'roles',
            'totalTasks',
            'pending',
            'inProgress',
            'completed'
        ));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('users', 'role', 'assigner.roles');
        return view('admin.task-show', compact('task'));
    }


    public function edit(Task $task)
    {
        $this->authorize('manage', $task);

        $task->load('users', 'role', 'assigner.roles');
        $users = User::with('roles')->where('company_id', Auth::user()->company_id)->get();
        $roles = Role::forCompany(Auth::user()->company_id)->get();

        return view('admin.task-edit', compact('task', 'users', 'roles'));
    }


    public function store(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category' => 'nullable|string',
                'priority' => 'required|in:Low,Medium,High',
                'due_date' => 'nullable|date|after_or_equal:today',
                'assigned_type' => 'required|in:individual,team',
                'attachments.*' => 'file|mimes:pdf,jpg,png,doc|max:10240',
            ];

            $assignedType = $request->input('assigned_type');
            if ($assignedType === 'individual') {
                $rules['assigned_users'] = 'required|array|min:1';
                $rules['assigned_users.*'] = 'exists:users,id';
            } elseif ($assignedType === 'team') {
                $rules['assigned_role'] = 'required|exists:roles,id';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'] ?? null,
                'priority' => $validated['priority'],
                'status' => 'Pending',
                'due_date' => $validated['due_date'] ?? null,
                'assigned_by' => Auth::id(),
            ]);

            // Handle attachments
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('task_attachments', 'public');
                    $attachments[] = $path;
                }
                $task->update(['attachments' => $attachments]);
            }

            // Handle assignment
            if ($assignedType === 'individual') {
                $userIds = $validated['assigned_users'];
                $task->assignToUsers($userIds);
            } else {
                $roleId = $validated['assigned_role'];
                $task->assignToTeam($roleId);
            }

            // Send Notifications to Assigned Users
            try {
                $assignerName = Auth::user()->name;
                $taskTitle = $task->title;
                $companyId = Auth::user()->company_id;

                foreach ($task->users as $user) {
                    if ($user->id !== Auth::id()) {
                        $user->notify(new \App\Notifications\SystemNotification([
                            'title' => 'New Task Assigned',
                            'message' => "{$assignerName} assigned a new task: {$taskTitle}",
                            'module' => 'task',
                            'url' => route('tasks.show', $task->id),
                            'icon' => 'tasks',
                        ]));
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Task Notification Failed: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'task' => $task->load('users', 'role', 'assigner.roles')->toArray()
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Task Creation Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $this->authorize('manage', $task);
        // Similar validation to store, but allow partial updates
        $rules = [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'priority' => 'sometimes|required|in:Low,Medium,High',
            'status' => 'sometimes|required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date', // Removed after_or_equal:today for updates
            'assigned_type' => 'sometimes|required|in:individual,team',
            'attachments.*' => 'file|mimes:pdf,jpg,png,doc|max:10240',
            'remove_attachments' => 'sometimes|array',
            'remove_attachments.*' => 'string',
        ];

        $assignedType = $request->input('assigned_type', $task->assigned_to_team ? 'team' : 'individual');
        if ($assignedType === 'individual') {
            $rules['assigned_users'] = 'sometimes|required|array|min:1';
            $rules['assigned_users.*'] = 'exists:users,id';
        } elseif ($assignedType === 'team') {
            $rules['assigned_role'] = 'sometimes|required|exists:roles,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Handle removals first (if provided)
        $removedAttachments = $request->input('remove_attachments', []);
        $existingAttachments = $task->attachments ?? [];
        if (!empty($removedAttachments)) {
            $filteredAttachments = array_filter($existingAttachments, function ($path) use ($removedAttachments) {
                return !in_array($path, $removedAttachments);
            });
            // Delete files from storage
            foreach ($removedAttachments as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            $task->update(['attachments' => array_values($filteredAttachments)]);
            $existingAttachments = array_values($filteredAttachments);
        }

        // Update core fields
        $updateData = [];
        if (isset($validated['title'])) $updateData['title'] = $validated['title'];
        if (isset($validated['description'])) $updateData['description'] = $validated['description'];
        if (isset($validated['category'])) $updateData['category'] = $validated['category'];
        if (isset($validated['priority'])) $updateData['priority'] = $validated['priority'];
        if (isset($validated['status'])) $updateData['status'] = $validated['status'];
        if (isset($validated['due_date'])) $updateData['due_date'] = $validated['due_date'];

        if (!empty($updateData)) {
            $task->update($updateData);
        }

        // Append new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments', 'public');
                $existingAttachments[] = $path;
            }
            $task->update(['attachments' => $existingAttachments]);
        }

        // Re-handle assignment if users or roles are provided
        if ($assignedType === 'individual' && isset($validated['assigned_users'])) {
            $task->assignToUsers($validated['assigned_users']);
        } elseif ($assignedType === 'team' && isset($validated['assigned_role'])) {
            $task->assignToTeam($validated['assigned_role']);
        } elseif (isset($validated['assigned_type']) && $validated['assigned_type'] !== ($task->assigned_to_team ? 'team' : 'individual')) {
            // Type changed but specific users/roles might not be in $validated if validation is loose
            // This is a fallback
            if ($validated['assigned_type'] === 'individual' && $request->has('assigned_users')) {
                $task->assignToUsers($request->input('assigned_users'));
            } elseif ($validated['assigned_type'] === 'team' && $request->has('assigned_role')) {
                $task->assignToTeam($request->input('assigned_role'));
            }
        }

        // Send Notifications to newly assigned users on update
        try {
            $assignerName = Auth::user()->name;
            $taskTitle = $task->title;

            foreach ($task->users as $user) {
                if ($user->id !== Auth::id()) {
                    $user->notify(new \App\Notifications\SystemNotification([
                        'title' => 'Task Updated/Re-assigned',
                        'message' => "{$assignerName} updated or re-assigned the task: {$taskTitle}",
                        'module' => 'task',
                        'url' => route('tasks.show', $task->id),
                        'icon' => 'tasks',
                    ]));
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Task Update Notification Failed: ' . $e->getMessage());
        }

        // Check if this is an AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'task' => $task->load('users', 'role', 'assigner.roles')->toArray()
            ]);
        }

        // Traditional form submission - redirect
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Task Update Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Task $task)
    {
        $this->authorize('manage', $task);
        
        // Clean up attachments
        if ($task->attachments) {
            foreach ($task->attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }

        // Clear assignments
        $task->users()->detach();
        $task->role()->dissociate();

        $task->delete();

        return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $this->authorize('updateStatus', $task);

            $validated = $request->validate([
                'status' => 'required|in:Pending,In Progress,Completed',
            ]);

            $task->update(['status' => $validated['status']]);

            // Optional: Send notification on status update
            try {
                $assignerName = Auth::user()->name;
                $taskTitle = $task->title;

                foreach ($task->users as $user) {
                    if ($user->id !== Auth::id()) {
                        $user->notify(new \App\Notifications\SystemNotification([
                            'title' => 'Task Status Updated',
                            'message' => "{$assignerName} updated the status of task: {$taskTitle} to {$validated['status']}",
                            'module' => 'task',
                            'url' => route('tasks.show', $task->id),
                            'icon' => 'tasks',
                        ]));
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Task Status Update Notification Failed: ' . $e->getMessage());
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task status updated successfully!',
                    'status' => $task->status
                ]);
            }

            return redirect()->back()->with('success', 'Task status updated successfully!');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Task Status Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
