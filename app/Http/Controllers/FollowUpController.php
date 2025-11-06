<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FollowUpController extends Controller
{
   public function index($lead_id)
{
    $lead = Lead::with('followUps')->findOrFail($lead_id);
    $types = FollowUp::$types; // ambil dari model
    return view('followups.index', compact('lead', 'types'));
}


    public function store(Request $request, $lead_id)
    {
        $request->validate([
            'date'  => 'required|date',
            'notes' => 'required|string',
            'type'  => 'nullable|in:call,email,meeting,chat',
        ]);

        $lead = Lead::findOrFail($lead_id);

        $lead->followUps()->create([
            'date'  => $request->date,
            'type'  => $request->type,
            'notes' => $request->notes,
        ]);

        $lead->status='contacted';
        $lead->save();

        return redirect()
            ->route('followups.index', $lead_id)
            ->with('success', 'Follow-up successfully added!');
    }

    public function appointments_store(Request $request, $lead_id){
        // return $request;

        $lead = Lead::findOrFail($lead_id);
        // return $lead->followUps;
        $lead->followUps()->create([
            'date'  => $request->reminder_at,
            // 'date'  => "2025-10-16 00:00:00",
            'type'  => 'appointment',
            'notes' => $request->description,
        ]);
        $lead->save();
        return redirect()
            ->route('followups.index', $lead_id)
            ->with('success', 'Appointment successfully added!');
    }

    public function edit($lead_id, $id)
    {
        $lead = Lead::findOrFail($lead_id);

        // Pastikan nama variabel konsisten: $followUp (sesuai di view)
        $followUp = FollowUp::where('lead_id', $lead_id)->findOrFail($id);

        $types = FollowUp::$types;

        return view('followups.edit', compact('lead', 'followUp', 'types'));
    }

    public function update(Request $request, $lead_id, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'date'  => 'required|date',
            'type'  => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        // Pastikan lead dan follow-up ditemukan
        $lead = Lead::findOrFail($lead_id);
        $followUp = FollowUp::where('lead_id', $lead_id)->findOrFail($id);

        // Update data
        $followUp->update($validated);

        // Redirect dengan pesan sukses
        return redirect()
            ->route('followups.index', $lead->id)
            ->with('success', 'Follow-up berhasil diperbarui!');
    }





    public function destroy($lead_id, $id)
    {
        $followup = FollowUp::where('lead_id', $lead_id)->findOrFail($id);
        $followup->delete();

        return redirect()->route('followups.index', $lead_id)
                         ->with('success', 'Follow-up successfully deleted.');
    }

    public function get_appointment(){
        // $reminders = FollowUp::where('type', 'appointment')->with('lead')->get();
        // return "test api";
        $reminders = FollowUp::where('type', 'appointment')
        ->whereNotNull('date')                // pastikan kolom date tidak kosong/null
        ->where('date', '>', Carbon::now())   // hanya yang tanggalnya di masa depan
        ->with('lead')
        ->orderBy('date', 'asc')              // urutkan dari yang paling dekat
        ->get();
        
        return $reminders;
    }
}
