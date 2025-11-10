<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Crm;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\CustomerPersona;
use App\Models\User;
use App\Models\Rfp;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LeadController extends Controller
{

public function dashboard()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $categories = Categories::all();
    } else {
        $categories = $user->categories;
    }

    $categoryIds = $categories->pluck('id');

    $totalLeads = \DB::table('leads')->count();

    $priority = ['Client Category A (Priority)', 'Client Category B', 'Client Category C'];

    $leadByCategory = \DB::table('categories')
        ->leftJoin('crm', 'categories.id', '=', 'crm.category_id')
        ->leftJoin('leads', 'crm.id', '=', 'leads.crm_id')
        ->select(
            'categories.id as category_id',
            'categories.name as category_name',
            \DB::raw('COUNT(leads.id) as total')
        )
        ->whereIn('categories.id', $categoryIds)
        ->groupBy('categories.id', 'categories.name')
        ->get();

    $colors = ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-secondary', 'bg-dark'];

    $leadByCategory = $leadByCategory->map(function ($cat) use ($colors) {
        $cat->color = $colors[crc32($cat->category_name) % count($colors)];
        return $cat;
    });

    $leadByCategory = $leadByCategory->sortBy(function ($cat) use ($priority) {
        $index = array_search($cat->category_name, $priority);
        return $index === false ? 999 : $index;
    });
    $show = Carbon::now() > Auth::user()->snoozed_until ? 'yes' : 'no';
    $user_id = Auth::user()->id;
    return view('leads.dashboard', compact('totalLeads', 'leadByCategory', 'user_id', 'show'));
}




public function byCategory($category, Request $request)
{
    $categories = Categories::whereIn('id', function ($query) {
        $query->select('category_id')
              ->from('crm')
              ->whereIn('id', function ($subQuery) {
                  $subQuery->select('crm_id')->from('leads');
              });
    })->get();

    $leadsQuery = Lead::with(['crm.category', 'assignedUser', 'followUps'])
        ->whereHas('crm.category', function($q) use ($category) {
            $q->where('name', $category);
        });

    $sort = $request->get('sort', 'created_at_desc');

    switch ($sort) {
        case 'created_at_asc':
            $leadsQuery->orderBy('created_at', 'asc');
            break;
        case 'created_at_desc':
            $leadsQuery->orderBy('created_at', 'desc');
            break;
        case 'name_asc':
            $leadsQuery->orderBy(
                Crm::select('name')->whereColumn('crm.id', 'leads.crm_id'),
                'asc'
            );
            break;
        case 'name_desc':
            $leadsQuery->orderBy(
                Crm::select('name')->whereColumn('crm.id', 'leads.crm_id'),
                'desc'
            );
            break;
        case 'status_asc':
            $leadsQuery->orderBy('status', 'asc');
            break;
        case 'status_desc':
            $leadsQuery->orderBy('status', 'desc');
            break;
        case 'assigned_to_asc':
            $leadsQuery->orderBy(
                User::select('name')->whereColumn('users.id', 'leads.assigned_to'),
                'asc'
            );
            break;
        case 'assigned_to_desc':
            $leadsQuery->orderBy(
                User::select('name')->whereColumn('users.id', 'leads.assigned_to'),
                'desc'
            );
            break;
        case 'category_asc':
            $leadsQuery->orderBy('category', 'asc');
            break;
        case 'category_desc':
           $leadsQuery->orderBy('category', 'desc');
            break;
        case 'lastcontact_asc':
            $leadsQuery->orderBy(
                FollowUp::select('date')
                    ->whereColumn('follow_ups.lead_id', 'leads.id')
                    ->orderBy('date', 'asc')
                    ->take(1),
                'asc'
            );
            break;
        case 'lastcontact_desc':
            $leadsQuery->orderBy(
                FollowUp::select('date')
                    ->whereColumn('follow_ups.lead_id', 'leads.id')
                    ->orderBy('date', 'desc')
                    ->take(1),
                'desc'
            );
            break;
        default:
            $leadsQuery->orderBy('created_at', 'desc');
            break;
    }

    $leads = $leadsQuery->paginate(20)->appends($request->query());

    $selectedCategory = $category;

    return view('leads.index', compact('categories', 'leads', 'selectedCategory', 'sort'));
}




public function index(Request $request)
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        $categories = \App\Models\Categories::all();
    } else {
        $categories = $user->categories;
    }

    $categoryIds = $categories->pluck('id');
    $selectedCategoryId = $request->get('category_id');
    $sort = $request->get('sort', 'created_at_desc');

    $leadsQuery = Lead::with(['crm.category', 'assignedUser', 'followUps'])
        ->whereHas('crm', function ($q) use ($categoryIds) {
            $q->whereIn('category_id', $categoryIds);
        });

    if ($selectedCategoryId && $categoryIds->contains($selectedCategoryId)) {
        $leadsQuery->whereHas('crm', function ($q) use ($selectedCategoryId) {
            $q->where('category_id', $selectedCategoryId);
        });
    }

    switch ($sort) {
        case 'created_at_asc':
            $leadsQuery->orderBy('created_at', 'asc');
            break;
        case 'created_at_desc':
            $leadsQuery->orderBy('created_at', 'desc');
            break;
        case 'name_asc':
            $leadsQuery->orderBy(
                Crm::select('name')->whereColumn('crm.id', 'leads.crm_id'),
                'asc'
            );
            break;
        case 'name_desc':
            $leadsQuery->orderBy(
                Crm::select('name')->whereColumn('crm.id', 'leads.crm_id'),
                'desc'
            );
            break;
        case 'status_asc':
            $leadsQuery->orderBy('status', 'asc');
            break;
        case 'status_desc':
            $leadsQuery->orderBy('status', 'desc');
            break;
        case 'assigned_to_asc':
            $leadsQuery->orderBy(
                User::select('name')->whereColumn('users.id', 'leads.assigned_to'),
                'asc'
            );
            break;
        case 'assigned_to_desc':
            $leadsQuery->orderBy(
                User::select('name')->whereColumn('users.id', 'leads.assigned_to'),
                'desc'
            );
            break;
        case 'lastcontact_asc':
            $leadsQuery->orderBy(
                FollowUp::select('date')
                    ->whereColumn('follow_ups.lead_id', 'leads.id')
                    ->latest('date')
                    ->take(1),
                'asc'
            );
            break;
        case 'lastcontact_desc':
            $leadsQuery->orderBy(
                FollowUp::select('date')
                    ->whereColumn('follow_ups.lead_id', 'leads.id')
                    ->latest('date')
                    ->take(1),
                'desc'
            );
            break;
        default:
            $leadsQuery->orderBy('created_at', 'desc');
            break;
    }

    $leads = $leadsQuery->paginate(20)->appends($request->query());

    return view('leads.index', compact('categories', 'leads', 'selectedCategoryId', 'sort'));
}










public function createFromCrm($crmId)
{
    $exists = Lead::where('crm_id', $crmId)->exists();

    if ($exists) {
        return response()->json(['success' => false, 'message' => 'Lead already exists.']);
    }

    $crm = Crm::findOrFail($crmId);

    $lead = Lead::create([
        'crm_id' => $crm->id,
        'source' => $crm->source ?? '',
        'status' => 'new',
        'assigned_to' => null,
    ]);

    return redirect()->route('leads.index')->with('success', 'Lead successfully created!');
}


public function create()
{
    $crms = Crm::orderBy('name')->get();
    $users = User::orderBy('name')->get();
    return view('leads.create', compact('crms', 'users'));
}


    public function store(Request $request)
    {
        $request->validate([
            'crm_id' => 'required|exists:crm,id',
            'source' => 'nullable|string|max:255',
            'status' => 'required|string',
            'assigned_to' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead berhasil ditambahkan.');
    }

    public function edit(Lead $lead)
    {
         $categories = Categories::orderBy('name')->get();
        $crms = Crm::all();
        $users = User::all();
        return view('leads.edit', compact('lead', 'crms', 'users', 'categories'));
    }



public function update(Request $request, Lead $lead)
{
    $request->validate([
        'crm_id'      => 'required|exists:crm,id',
        // 'status'      => 'required|string',
        'assigned_to' => 'nullable|exists:users,id',
        'notes'       => 'nullable|string',
        // 'category'    => 'required|string',
    ]);

    // Simpan status dan kategori lama
    // $oldStatus = $lead->status;
    // $oldCategory = $lead->category;

    // Update lead
    $lead->update($request->only('crm_id', 'assigned_to', 'notes', ));

    // Update juga kategori di CRM terkait
    if ($lead->crm) {
        $lead->crm->update(['category_id' => $request->category_id]);
    }

    // Jika status berubah menjadi 'qualified', buat RFP otomatis
    if ($request->status === 'qualified' && $oldStatus !== 'qualified') {
        Rfp::create([
            'lead_id'     => $lead->id,
            'title'       => 'RFP for ' . ($lead->crm->company_name ?? 'Lead #' . $lead->id),
            'description' => 'Auto-generated from qualified lead.',
            'status'      => 'draft',
        ]);
    }

    return redirect()->route('leads.index')->with('success', 'Lead & CRM berhasil diperbarui.');
}



    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead berhasil dihapus.');
    }

    public function show(Lead $lead)
    {
        // Load semua relasi yang dibutuhkan untuk lead ini
        $lead->load('crm', 'followUps', 'persona', 'assignedUser');

        $types = FollowUp::$types;

        return view('leads.show', compact('lead', 'types'));
    }


    public function leadByStatus($status, Request $request)
{


    // Validasi status
    if (!in_array($status, ['new', 'contacted', 'qualified'])) {
        abort(404);
    }

    // Base query
    $query = Lead::with('crm')
        ->where('status', $status);

    // Filter untuk non-admin → hanya project yang dia punya

    // Tentukan jumlah item per halaman
    $perPage = 5;

    // Eksekusi query
    $leads = $query->latest()
                   ->paginate($perPage)
                   ->appends($request->query());

    return view('leads.by_status', compact('leads', 'status'));
}





}
