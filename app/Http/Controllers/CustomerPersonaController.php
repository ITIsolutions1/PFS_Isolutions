<?php

namespace App\Http\Controllers;

use App\Models\CustomerPersona;
use App\Models\Crm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerPersonaController extends Controller
{
    public function index()
    {
        $personas = CustomerPersona::with('crm')->paginate(20);
        return view('personas.index', compact('personas'));
    }

    public function create(Request $request)
    {
        $crms = Crm::all();
        $selectedCrmId = $request->get('crm_id');
        return view('personas.create', compact('crms', 'selectedCrmId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crm_id' => 'required|exists:crm,id',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'income_level' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'key_interest' => 'nullable|string|max:255',
            'pain_point' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        CustomerPersona::create($request->all());

        return redirect()->route('client.index')->with('success', 'Customer Persona berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $persona = CustomerPersona::findOrFail($id);
        $crms = Crm::all();
        return view('personas.edit', compact('persona', 'crms'));
    }

    public function update(Request $request, $id)
    {
        $persona = CustomerPersona::findOrFail($id);
        $persona->update($request->all());

        return redirect()->route('personas.index')->with('success', 'Customer Persona berhasil diperbarui!');
    }

    public function destroy($id)
    {
        CustomerPersona::findOrFail($id)->delete();
        return redirect()->route('personas.index')->with('success', 'Customer Persona berhasil dihapus!');
    }

    public function updateField(Request $request, CustomerPersona $persona, $field)
{
    if (!in_array($field, ['date_of_birth', 'gender', 'occupation', 'income_level', 'education_level', 'key_interest', 'pain_point', 'notes'])) {
        abort(403, 'Field tidak valid.');
    }

    $persona->$field = $request->$field;
    $persona->save();

    return back()->with('success', 'Data persona diperbarui.');
}

public function updateMultiple(Request $request, $id)
{
    $persona = CustomerPersona::findOrFail($id);

    foreach ($request->all() as $field => $value) {
        if (in_array($field, $persona->getFillable())) {
            $persona->$field = $value;
        }
    }

    $persona->save();

    return response()->json(['success' => true]);
}







}
