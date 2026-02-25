<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string',
            'attachments.*' => 'file|mimes:pdf,jpg,png,doc,docx|max:10240',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_comments', 'public');
                $attachments[] = $path;
            }
        }

        $comment = $task->comments()->create([
            'user_id' => Auth::id(),
            'company_id' => Auth::user()->company_id,
            'comment' => $request->comment,
            'attachments' => $attachments,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'formatted_date' => $comment->created_at->diffForHumans(),
                'auth_id' => Auth::id()
            ]);
        }

        return back()->with('success', 'Message posted successfully!');
    }

    public function fetchNew(Request $request, Task $task)
    {
        $lastId = $request->input('last_id', 0);
        
        $newComments = $task->comments()
            ->with('user')
            ->where('id', '>', $lastId)
            ->get();

        return response()->json([
            'comments' => $newComments->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'user_name' => $comment->user->name,
                    'comment' => $comment->comment,
                    'attachments' => $comment->attachments,
                    'formatted_date' => $comment->created_at->diffForHumans(),
                    'is_me' => $comment->user_id === Auth::id()
                ];
            }),
            'auth_id' => Auth::id()
        ]);
    }
}
