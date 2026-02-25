<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Manage task (view / edit / update / delete)
     */
    /**
     * Determine if the user can view the task details.
     */
    public function view(User $authUser, Task $task)
    {
        if ($authUser->company_id !== $task->company_id) {
            return false;
        }

        // Creator, Admin, or Assigned users can view
        return $authUser->id === $task->assigned_by || 
               $authUser->hasRole('admin') || 
               $task->users->contains($authUser->id) ||
               ($task->role && $authUser->roles->contains($task->role->id));
    }

    /**
     * Determine if the user can edit or delete the task.
     */
    public function manage(User $authUser, Task $task)
    {
        if ($authUser->company_id !== $task->company_id) {
            return false;
        }

        // ONLY the creator or Admin can edit/delete
        return $authUser->id === $task->assigned_by || $authUser->hasRole('admin');
    }
}
