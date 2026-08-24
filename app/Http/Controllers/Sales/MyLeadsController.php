<?php
namespace App\Http\Controllers\Sales;
use App\Http\Controllers\Controller;
use App\Models\Mylead;
use App\Models\MyleadHistory; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class MyLeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function baseQuery()
{
    return Mylead::where('company_id', auth()->user()->company_id);
}

  public function index(Request $request)
    {
        $query = $this->baseQuery()
            ->with('client')
            ->where('user_id', Auth::id());

        // Filters
        if ($request->has('response') && $request->response != '') {
            $query->where('response', 'like', '%' . $request->response . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('project_type') && $request->project_type != '') {
            $query->where('project_type', $request->project_type);
        }

        if ($request->has('client_name') && $request->client_name != '') {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->client_name . '%')
                  ->orWhere('contact_person', 'like', '%' . $request->client_name . '%');
            });
        }

        if ($request->has('next_follow_up_date') && $request->next_follow_up_date != '') {
            $query->whereDate('next_follow_up', $request->next_follow_up_date);
        }

        $myleads = $query->latest()->paginate(20)->withQueryString();

        return view('admin.sales.myleads', compact('myleads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required',
        'response' => 'required|string',
        'project_type' => 'required|string',
        'next_follow_up' => 'nullable|date',
        'follow_up_time' => 'nullable',
        'status' => 'required|string',
    ]);

    // Update existing unlocked lead or create a new one
    $lead = Mylead::updateOrCreate(
        ['client_id' => $request->client_id, 'company_id' => auth()->user()->company_id],
        [
            'user_id' => Auth::id(),
            'response' => $request->response,
            'next_follow_up' => $request->next_follow_up ? $request->next_follow_up : null,
            'follow_up_time' => $request->follow_up_time,
            'project_type' => $request->project_type,
            'status' => $request->status,
        ]
    );

    // Log initial history
    MyleadHistory::create([
        'company_id' => auth()->user()->company_id,
        'mylead_id' => $lead->id,
        'user_id' => Auth::id(),
        'changes' => json_encode(['action_taken' => 'Initial Action Taken']),
        'response' => $request->response,
    ]);

    return back()->with('success', 'Lead response saved successfully!');
}

    public function closedLeads(Request $request)
    {
        $query = \App\Models\ClosedLead::with(['lead.client', 'user', 'updater'])
            ->where('company_id', Auth::user()->company_id)
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('lead.client', function($q) use ($search) {
                $q->where('contact_person', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('service_name')) {
            $query->where('service_name', 'like', "%{$request->service_name}%");
        }

        if ($request->filled('date_from')) {
            $query->whereDate('closed_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('closed_date', '<=', $request->date_to);
        }

        $closedLeads = $query->latest()->paginate(10)->withQueryString();
        
        $clientsList = \App\Models\Client::where('company_id', Auth::user()->company_id)->get(['id', 'company_name', 'contact_person']);
        $servicesList = [
            'Web Development',
            'Mobile App',
            'E-commerce',
            'UI/UX Design',
            'Digital Marketing',
            'SEO',
            'Custom Software',
            'Other'
        ];
            
        return view('admin.sales.closed-leads', compact('closedLeads', 'clientsList', 'servicesList'));
    }

    public function updateClosedLead(Request $request, $id)
    {
        $closedLead = \App\Models\ClosedLead::findOrFail($id);
        
        // Authorization check
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin') && $closedLead->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'service_name' => 'required|string',
            'closed_date' => 'required|date',
            'payment_type' => 'required|in:one_time,recurring',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'required|numeric|min:0',
            'next_payment_date' => 'nullable|date',
        ]);

        $closedLead->update([
            'service_name' => $request->service_name,
            'closed_date' => $request->closed_date,
            'payment_type' => $request->payment_type,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
            'next_payment_date' => $request->next_payment_date,
            'updated_by' => Auth::id(),
        ]);

        $statusStr = $request->due_amount <= 0 ? 'Fully Paid' : 'Due Pending';
        \App\Models\MyleadHistory::create([
            'company_id' => auth()->user()->company_id,
            'mylead_id' => $closedLead->lead_id,
            'user_id' => Auth::id(),
            'changes' => json_encode(['action_taken' => "Closed Deal Updated: {$statusStr}"]),
            'response' => "Closed lead details updated by " . Auth::user()->name . " (Paid: ₹{$request->paid_amount}, Due: ₹{$request->due_amount})",
        ]);

        return redirect()->back()->with('success', 'Closed lead details updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = $this->baseQuery();
        $lead = $query->findOrFail($id);

$this->authorize('manage', $lead);

    return view('admin.sales.myleads-show', compact('lead'));
    }

    /**
     * Display the history for the specified resource.
     */
    public function history(string $id)
    {
        $query = $this->baseQuery();
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin')) {
            $query->where('user_id', Auth::id());
        }
        $lead = $query->findOrFail($id);

$this->authorize('manage', $lead);


        return view('admin.sales.myleadshistory', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = $this->baseQuery();
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin')) {
            $query->where('user_id', Auth::id());
        }
        $lead = $query->findOrFail($id);

$this->authorize('manage', $lead);

       
        return view('admin.sales.myleads-edit', compact('lead'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $query = $this->baseQuery();
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('superadmin')) {
            $query->where('user_id', Auth::id());
        }
        $lead = $query->findOrFail($id);

$this->authorize('manage', $lead);

        
        // Capture old values for history
        $oldData = $lead->getOriginal();

        // Validation rules
        $request->validate([
            'response' => 'required|string|max:1000',
            'next_follow_up' => 'nullable|date',
            'project_type' => 'nullable|string',
            'status' => 'required|string',
        ]);

        // Update the lead
      $lead->update([
    'response' => $request->response,
    'next_follow_up' => $request->next_follow_up ? $request->next_follow_up : null,
    'follow_up_time' => $request->follow_up_time,
    'project_type' => $request->project_type,
    'status' => $request->status,
]);

        // Log history after update
        $this->logHistory($lead, $oldData, $request->all());

        if ($request->has('is_closed_deal') && strtolower($request->status) === 'closed') {
            \App\Models\ClosedLead::create([
                'company_id' => auth()->user()->company_id ?? null,
                'lead_id' => $lead->id,
                'user_id' => auth()->id(),
                'service_name' => $request->service_name,
                'closed_date' => $request->closed_date,
                'payment_type' => $request->payment_type,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,
                'next_payment_date' => $request->next_payment_date,
            ]);
        }

        // Optional: Redirect with success message
        if ($request->has('redirect_to') && $request->redirect_to === 'show') {
            return redirect()->back()->with('success', 'Lead updated and closed successfully!');
        }
        
        return redirect()->route('myleads')
            ->with('success', 'Lead updated successfully!');
    }

    /**
     * Helper method to log history.
     */
    private function logHistory($lead, $oldData, $newData)
    {
        $changes = [];
        $fields = ['response', 'next_follow_up', 'follow_up_time', 'project_type', 'status'];

        foreach ($fields as $field) {
            if (isset($oldData[$field]) && $oldData[$field] != ($newData[$field] ?? $lead->getAttribute($field))) {
                $changes[$field] = [
                    'old' => $oldData[$field] ?? 'N/A',
                    'new' => $newData[$field] ?? $lead->getAttribute($field)
                ];
            }
        }

        if (!empty($changes)) {
           MyleadHistory::create([
    'company_id' => auth()->user()->company_id,
    'mylead_id' => $lead->id,
    'user_id' => Auth::id(),
    'changes' => json_encode($changes),
    'response' => $newData['response'] ?? null,
]);

        }
    }

    /**
     * Update the specified history resource in storage.
     */
    public function updateHistory(Request $request, string $id)
    {
        $request->validate([
            'response' => 'required|string|max:1000',
        ]);

        $history = MyleadHistory::findOrFail($id);
        
        // Ensure the auth user owns this history or the lead
        if ($history->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $history->update([
            'response' => $request->response
        ]);

        return redirect()->back()->with('success', 'Timeline updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
  
}