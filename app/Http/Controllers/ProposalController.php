<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Lead;
use App\Models\ProposalFile;


class ProposalController extends Controller
{
    
public function index(Request $request)
{
    $search = $request->input('search');
    $sort = $request->get('sort', 'created_at_desc');
    $perPage = $request->get('per_page', 'all'); // Default 10

    // Query dasar
    $query = Proposal::with(['assignedUser', 'lead.crm']);

     if ($request->status && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // Sorting logic
    switch ($sort) {
        case 'title_asc':
            $query->orderBy('title', 'asc');
            break;
        case 'title_desc':
            $query->orderBy('title', 'desc');
            break;
        case 'status_asc':
            $query->orderBy('status', 'asc');
            break;
        case 'status_desc':
            $query->orderBy('status', 'desc');
            break;
        case 'pic_asc':
            $query->join('users', 'users.id', '=', 'proposals.assign_to')
                ->orderBy('users.name', 'asc')
                ->select('proposals.*');
            break;
        case 'pic_desc':
            $query->join('users', 'users.id', '=', 'proposals.assign_to')
                ->orderBy('users.name', 'desc')
                ->select('proposals.*');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    // Search
    if ($search) {
        $columns = \Schema::getColumnListing('proposals'); // Semua kolom
        $excluded = ['id', 'created_at', 'updated_at'];
        $columns = array_diff($columns, $excluded); // Kolom di-filter

        $query->where(function ($subQuery) use ($columns, $search) {
            foreach ($columns as $column) {
                $subQuery->orWhere($column, 'like', "%{$search}%");
            }

            // Additional fields: User name & CRM name
            $subQuery->orWhereHas('assignedUser', function ($nested) use ($search) {
                $nested->where('name', 'like', "%{$search}%");
            });

            $subQuery->orWhereHas('lead.crm', function ($nested) use ($search) {
                $nested->where('name', 'like', "%{$search}%");
            });
        });
    }

    // Pagination handling
    if ($perPage === 'all') {
        $perPage = 9999; // Agar tetap dalam bentuk paginator
    }

    $proposals = $query->paginate($perPage)->appends([
        'search' => $search,
        'sort' => $sort,
        'per_page' => $request->get('per_page'),
          'status' => $request->get('status'),
    ]);

    $statusCounts = Proposal::select('status', \DB::raw('COUNT(*) as total'))
    ->groupBy('status')
    ->pluck('total', 'status');

$totalAll = Proposal::count();


    $leads = Lead::all();

    

    return view('proposal.index', compact('proposals', 'leads', 'sort', 'perPage', 'statusCounts', 'totalAll', 'search'));
}




    public function create()
{
    $leads = Lead::all();
    $users = User::all();
    return view('proposal.create', compact('leads', 'users'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'lead_id'        => 'required|exists:leads,id',
        'title'          => 'required|string|max:255',
        'status'         => 'required|in:rfp,draft,submitted,awaiting_po,awarded,decline,lost',
        'assign_to'      => 'nullable|exists:users,id',
        'description'    => 'nullable|string',
        'decline_reason' => 'nullable|string',
        'files.*'        => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx,jpg,jpeg,png|max:10240',
    ]);

    // Atur submitted_at
    $submittedDate = $validated['status'] === 'submitted'
        ? now()
        : null;

    // Atur decline_reason (hanya saat status decline)
    $declineReason = $validated['status'] === 'decline'
        ? ($validated['decline_reason'] ?? null)
        : null;

    $proposal = Proposal::create([
        'lead_id'        => $validated['lead_id'],
        'title'          => $validated['title'],
        'status'         => $validated['status'],
        'assign_to'      => $validated['assign_to'] ?? null,
        'description'    => $validated['description'] ?? null,
        'submitted_at'   => $submittedDate,
        'decline_reason' => $declineReason,
    ]);

    // Upload files jika ada
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $path = $file->store('proposal_files', 'public');

            ProposalFile::create([
                'proposal_id' => $proposal->id,
                'file_name'   => $file->getClientOriginalName(),
                'file_path'   => $path,
            ]);
        }
    }

    return redirect()
        ->route('proposals.index')
        ->with('success', 'Proposal has been successfully created!');
}

public function destroy($id)
{
    $proposal = Proposal::findOrFail($id);
    $proposal->delete();

    return redirect()
        ->route('proposals.index')
        ->with('success', 'Proposal has been successfully deleted!');

}

public function show($id)
{
    $proposal = Proposal::with('lead.crm', 'assignedUser', 'files')->findOrFail($id);
    $followups = $proposal->followups()->orderBy('followup_date', 'desc')->paginate(5);

    return view('proposal.show', compact('proposal', 'followups'));
}

public function edit($id)
{
    $proposal = Proposal::findOrFail($id);
    $leads = Lead::all();
    $users = User::all();
    return view('proposal.edit', compact('proposal', 'leads', 'users'));

}

public function update(Request $request, $id)
{
    $proposal = Proposal::findOrFail($id);

    // Validasi dasar
    $validated = $request->validate([
        'lead_id'        => 'required|exists:leads,id',
        'title'          => 'required|string|max:255',
        'status'         => 'required|in:rfp,draft,submitted,awaiting_po,awarded,decline,lost',
        'assign_to'      => 'nullable|exists:users,id',
        'description'    => 'nullable|string',
        'submitted_at'   => 'nullable|date',
        'decline_reason' => 'nullable|string',
        'files.*'        => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,ppt,pptx,jpg,jpeg,png|max:10240',
    ]);

    // Tentukan nilai submitted_at
    $submittedDate = null;
    $declineReason = null;

    // Jika status SUBMITTED
    if ($validated['status'] === 'submitted') {
        $submittedDate = $validated['submitted_at'] ?? now()->toDateString();
    }

    // Jika status DECLINE
    if ($validated['status'] === 'decline') {
        $declineReason = $validated['decline_reason'] ?? null;
    }

    // Update Proposal
    $proposal->update([
        'lead_id'        => $validated['lead_id'],
        'title'          => $validated['title'],
        'status'         => $validated['status'],
        'assign_to'      => $validated['assign_to'] ?? null,
        'description'    => $validated['description'] ?? null,
        'submitted_at'   => $submittedDate,
        'decline_reason' => $declineReason,
    ]);

    // Upload file baru
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $path = $file->store('proposal_files', 'public');

            ProposalFile::create([
                'proposal_id' => $proposal->id,
                'file_name'   => $file->getClientOriginalName(),
                'file_path'   => $path,
            ]);
        }
    }

    return redirect()
        ->route('proposals.show', $proposal->id)
        ->with('success', 'Proposal has been successfully updated!');
}




public function show2($id)
{
    $proposal = Proposal::with('lead.followUps','lead.crm','lead.persona', 'assignedUser', 'files.file_name')->findOrFail($id);
    return view('proposal.show2', compact('proposal'));
}


public function byProposalStatus($status)
{

    
    $proposals = Proposal::with('assignedUser')
        ->where('status', $status)
        ->paginate(10);

    return view('proposal.index', compact('proposals', 'status'));
}

// Follow-up proposal methods

    public function createFollowup(Proposal $proposal)
    {
        return view('proposal.followups.create', compact('proposal'));
    }

    public function storeFollowup(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'followup_date' => 'required|date',
            'type'          => 'required|in:call,chat,meeting,email,visit,other',
            'notes'         => 'nullable|string',
        ]);

        $proposal->followups()->create($validated);

    return redirect()->route('proposals.show', $proposal->id)
                    ->with('success', 'Follow-up added!');
    }

    public function editFollowup(Proposal $proposal, $followupId)
    {
        $followup = $proposal->followups()->findOrFail($followupId);
        return view('proposal.followups.edit', compact('proposal', 'followup'));
    }

    public function updateFollowup(Request $request, Proposal $proposal, $followupId)
    {
        $followup = $proposal->followups()->findOrFail($followupId);

        $validated = $request->validate([
            'followup_date' => 'required|date',
            'type'          => 'required|in:call,chat,meeting,email,visit,other',
            'notes'         => 'nullable|string',
        ]);

        $followup->update($validated);

        return redirect()->route('proposals.show', $proposal->id)
                         ->with('success', 'Follow-up updated!');
    }
    
public function deleteFollowup(Proposal $proposal, $followupId)
{
    $followup = $proposal->followups()->findOrFail($followupId);
    $followup->delete();

    return redirect()->route('proposals.show', $proposal->id)
                     ->with('success', 'Follow-up deleted!');
}

public function followupReminder()
{
    $proposals = Proposal::where('status', 'submitted')
        ->where(function ($q) {
            $q->whereDoesntHave('followups')                  // belum pernah follow up
              ->orWhereHas('followups', function ($q2) {       // sudah followup tapi > 7 hari
                  $q2->whereDate('followup_date', '<', now()->subDays(7));
              });
        })
        ->get();

    return view('proposal.modal_reminder', compact('proposals'));
}




}
  