<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crm;
use App\Models\Categories;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


class CrmController extends Controller
{
   public function index(Request $request) 
{
    $categories = Categories::all();
    $sort = $request->get('sort', 'created_at_desc');

    $clientsQuery = Crm::query('lead');

    switch ($sort) {
        case 'created_at_asc':
        $clientsQuery->orderBy('created_at', 'asc');
        break;
    case 'created_at_desc':
        $clientsQuery->orderBy('created_at', 'desc');
        break;
    case 'name_asc':
        $clientsQuery->orderBy('name', 'asc');
        break;
    case 'name_desc':
        $clientsQuery->orderBy('name', 'desc');
        break;
    case 'position_asc':
        $clientsQuery->orderBy('name', 'asc');
        break;
    case 'position_desc':
        $clientsQuery->orderBy('name', 'desc');
        break;
    case 'company_asc':
        $clientsQuery->orderBy('company', 'asc');
        break;
    case 'company_desc':
        $clientsQuery->orderBy('company', 'desc');
        break;
    case 'email_asc':
        $clientsQuery->orderBy('email', 'asc');
        break;
    case 'email_desc':
        $clientsQuery->orderBy('email', 'desc');
        break;
    case 'phone_asc':
        $clientsQuery->orderBy('phone', 'asc');
        break;
    case 'phone_desc':
        $clientsQuery->orderBy('phone', 'desc');
        break;
    case 'website_asc':
        $clientsQuery->orderBy('website', 'asc');
        break;
    case 'website_desc':
        $clientsQuery->orderBy('website', 'desc');
        break;
    case 'address_asc':
        $clientsQuery->orderBy('address', 'asc');
        break;
    case 'address_desc':
        $clientsQuery->orderBy('address', 'desc');
        break;
    case 'notes_asc':
        $clientsQuery->orderBy('notes', 'asc');
        break;
    case 'notes_desc':
        $clientsQuery->orderBy('notes', 'desc');
        break;
    case 'category_asc':
        $clientsQuery->orderBy(
            Categories::select('name')
                ->whereColumn('categories.id', 'crm.category_id'),
            'asc'
        );
        break;
    case 'category_desc':
        $clientsQuery->orderBy(
            Categories::select('name')
                ->whereColumn('categories.id', 'crm.category_id'),
            'desc'
        );
        break;
}


    $clients = $clientsQuery->paginate(50);
    $crmCount = $clients->total();

    return view('clients.index', compact('clients', 'categories', 'crmCount'));
}




        public function create()
    {
        $categories = Categories::all(); // Ambil semua kategori untuk dropdown
        return view('clients.create', compact('categories'));
    }






public function store(Request $request)
{
    $request->validate([
        'category_id' => 'nullable|exists:categories,id',
        'name'        => 'required|string|max:255',
        'position'    => 'nullable|string|max:255',
        'company'     => 'nullable|string|max:255',
        'email'       => 'nullable|email|max:255',
        'address'     => 'nullable|string|max:255',
        'notes'       => 'nullable|string',
        'phone'       => 'nullable|string|max:20',
        'website'     => 'nullable|url|max:255',
    ]);

    $data = $request->only([
        'category_id', 'name', 'position', 'company', 'email',
        'address', 'notes', 'phone', 'website'
    ]);

    // kalau category kosong → otomatis "Others"
    if (empty($data['category_id'])) {
        $othersCategory = Categories::firstOrCreate(['name' => 'Others']);
        $data['category_id'] = $othersCategory->id;
    }

    // simpan CRM
    $crm = Crm::create($data);

    // buat vCard
    $vcard = collect([
        "BEGIN:VCARD",
        "VERSION:3.0",
        "FN:{$crm->name}",
        $crm->position ? "TITLE:{$crm->position}" : null,
        $crm->company  ? "ORG:{$crm->company}" : null,
        $crm->phone    ? "TEL:{$crm->phone}" : null,
        $crm->email    ? "EMAIL:{$crm->email}" : null,
        $crm->website  ? "URL:{$crm->website}" : null,
        $crm->address  ? "ADR:;;{$crm->address}" : null,
        $crm->notes    ? "NOTE:{$crm->notes}" : null,
        "END:VCARD",
    ])->filter()->implode("\n");

    // path QR
    $path = "qrcodes/client_{$crm->id}.png";

    // generate pakai GD
    $qrcode = \QrCode::format('png')
        ->size(250)
        ->errorCorrection('H')
        ->generate($vcard);

    // simpan ke storage/app/public/qrcodes
    \Storage::disk('public')->put($path, $qrcode);

    // update database (pastikan ada kolom qr_code di table)
    $crm->update(['qr_code' => $path]);

    return redirect()
        ->route('crm.index')
        ->with('success', 'CRM data saved & QR generated successfully!');
}


public function edit($id)
{
    $client = Crm::findOrFail($id);
    $categories = Categories::all(); // Ambil semua kategori untuk dropdown
    return view('clients.edit', compact('client', 'categories'));
}


public function update(Request $request, $id)
{
    $crm = Crm::findOrFail($id);

    // Update data utama CRM
    $crm->update($request->only([
        'name', 'position', 'company', 'email', 'phone', 'address', 'website', 'notes', 'category_id'
    ]));

    // Update atau buat persona jika ada input
    if ($request->has('persona')) {
        $crm->persona()->updateOrCreate([], $request->input('persona'));
    }

    return redirect()->route('crm.show', $crm->id)
        ->with('green', 'CRM dan Persona berhasil diperbarui.');
}



public function destroy($id)
{
    $client = Crm::findOrFail($id);
    $client->delete();

    return redirect()->route('crm.index')->with('success', 'CRM data deleted successfully!');
}

public function formCrm()
{
    $categories = Categories::all();
    return view('clients.form', compact('categories'));
}

public function submitForm(Request $request)
{
    $request->validate([
        'category_id' => 'nullable|exists:categories,id',
        'name'        => 'required|string|max:255',
        'position'     => 'nullable|string|max:255',
        'company'     => 'nullable|string|max:255',
        'email'       => 'nullable|string|max:255',
        'address'     => 'nullable|string|max:255',
        'notes'       => 'nullable|string',
        'phone'       => 'nullable|string|max:20',
        'website'     => 'nullable|url|max:255',
    ]);

    // Ambil data dari request
    $data = $request->only([
        'name', 'position', 'email', 'phone', 'company',
        'category_id', 'website', 'address', 'notes'
    ]);

    // Kalau category_id kosong → pakai kategori "Others"
    if (empty($data['category_id'])) {
        $othersCategory = \App\Models\Categories::firstOrCreate(['name' => 'Others']);
        $data['category_id'] = $othersCategory->id;
    }

    // Crm::create($data);

    // simpan CRM
    $crm = Crm::create($data);

    // buat vCard
    $vcard = collect([
        "BEGIN:VCARD",
        "VERSION:3.0",
        "FN:{$crm->name}",
        $crm->position ? "TITLE:{$crm->position}" : null,
        $crm->company  ? "ORG:{$crm->company}" : null,
        $crm->phone    ? "TEL:{$crm->phone}" : null,
        $crm->email    ? "EMAIL:{$crm->email}" : null,
        $crm->website  ? "URL:{$crm->website}" : null,
        $crm->address  ? "ADR:;;{$crm->address}" : null,
        $crm->notes    ? "NOTE:{$crm->notes}" : null,
        "END:VCARD",
    ])->filter()->implode("\n");

    $path = "qrcodes/client_{$crm->id}.png";
    $qrcode = \QrCode::format('png')
        ->size(250)
        ->errorCorrection('H')
        ->generate($vcard);

    // simpan ke storage/app/public/qrcodes
    \Storage::disk('public')->put($path, $qrcode);

    // update database (pastikan ada kolom qr_code di table)
    $crm->update(['qr_code' => $path]);

    //flash session untuk di tampilkan di view
    session()->flash('name', $crm->name);
    session()->flash('company', $crm->company);

    // Response JSON kalau request pakai AJAX
    if ($request->ajax()) {
        return response()->json([
            'status'  => 'success',
            'message' => 'CRM data saved successfully!'
        ]);
    }

    return redirect()->back()->with('success', 'CRM data saved successfully!')->with('qrcode', $crm->qr_code);;
}

public function show($id)
{
    $crm = Crm::with('persona')->findOrFail($id);

    return view('clients.show', compact('crm'));
}

public function updateField(Request $request, Crm $crm, $field)
{
    if (!in_array($field, ['name', 'position', 'company', 'email', 'address', 'notes', 'phone', 'website'])) {
        abort(403, 'Field tidak valid.');
    }

    $crm->$field = $request->$field;
    $crm->save();

    return back()->with('success', 'Data CRM diperbarui.');
}


public function updateMultiple(Request $request, $id)
{
    $crm = Crm::findOrFail($id);

    // Field yang boleh di-update sesuai database
    $allowed = [
        'category_id',
        'name',
        'position',
        'company',
        'email',
        'address',
        'notes',
        'phone',
        'website'
    ];

    // Ambil hanya field yang dikirim dan diizinkan
    $data = $request->only($allowed);

    // Update
    $crm->update($data);

    return response()->json(['success' => true]);
}






}

