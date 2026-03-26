<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // DASHBOARD VIEW
    // =========================
    public function index()
    {
        return view('admin.notepad');
    }

    // =========================
    // GET NOTES (WITH VISIBILITY)
    // =========================
    public function getNotes(Request $request)
    {
        $user = Auth::user();

        $query = Note::with('user')
            ->where('company_id', auth()->user()->company_id);


        // -------- FILTERS --------
        if ($request->filled('filter') && $request->filter !== 'all') {
            switch ($request->filter) {
                case 'pinned':
                    $query->where('pinned', true);
                    break;

                case 'recent':
                    $query->where('updated_at', '>=', now()->subDays(7));
                    break;
            }
        }

        // Category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sorting
        $query->orderBy(
            $request->get('sort_by', 'created_at'),
            $request->get('sort_order', 'desc')
        );

        $notes = $query->get()->map(function ($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'category' => $note->category,
                'tags' => $note->tags,
                'related_client' => $note->related_client,
                'related_project' => $note->related_project,
                'related_task' => $note->related_task,
                'pinned' => $note->pinned,
                'created_by' => $note->user->name,
                'created_by_id' => $note->user_id,
                'created_at' => $note->formatted_created_at,
                'updated_at' => $note->formatted_updated_at,
                'can_edit' => auth()->id() === $note->user_id || auth()->user()->role === 'admin',
                'can_delete' => auth()->id() === $note->user_id || auth()->user()->role === 'admin',
            ];
        });

        return response()->json($notes);
    }

    // =========================
    // STATS
    // =========================
    public function getStats()
    {
        $user = Auth::user();

        $baseQuery = Note::where('company_id', auth()->user()->company_id);


        return response()->json([
            'total' => (clone $baseQuery)->count(),
            'pinned' => (clone $baseQuery)->where('pinned', true)->count(),
            'recent' => (clone $baseQuery)->where('updated_at', '>=', now()->subDays(7))->count(),
        ]);
    }


    // =========================
    // SHOW SINGLE NOTE
    // =========================
    public function show($id)
    {
        $note = Note::where('company_id', auth()->user()->company_id)
            ->with('user')
            ->findOrFail($id);

        // $this->authorize('manage', $note);

        if (!$this->canViewNote($note)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($note);
    }

    // =========================
    // CREATE NOTE
    // =========================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required',
            'tags' => 'nullable|array',
            'pinned' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'visibility' => 'public',
            'tags' => $request->tags,
            'related_client' => $request->related_client,
            'related_project' => $request->related_project,
            'related_task' => $request->related_task,
            'pinned' => $request->pinned ?? false,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'note' => $note]);
    }

    // =========================
    // UPDATE NOTE
    // =========================
    public function update(Request $request, $id)
    {
        $note = Note::where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $this->authorize('manage', $note);




        $note->update($request->only([
            'title',
            'content',
            'category',
            'tags',
            'related_client',
            'related_project',
            'related_task',
            'pinned',
        ]));

        return response()->json(['success' => true]);
    }

    // =========================
    // DELETE NOTE
    // =========================
    public function destroy($id)
    {
        $note = Note::where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $this->authorize('manage', $note);




        $note->delete();

        return response()->json(['success' => true]);
    }

    // =========================
    // TOGGLE PIN
    // =========================
    public function togglePin($id)
    {
        $note = Note::where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $this->authorize('manage', $note);



        $note->update(['pinned' => !$note->pinned]);

        return response()->json([
            'success' => true,
            'pinned' => $note->pinned
        ]);
    }

    // =========================
    // PERMISSION CHECK
    // =========================
    private function canViewNote(Note $note)
    {
        // Anyone in the same company can view any note now that team/private features are removed
        return $note->company_id === auth()->user()->company_id;
    }

}
