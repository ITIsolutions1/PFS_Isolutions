<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\FollowUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class FollowUpController extends Controller
{
   public function index($lead_id)
{
    $previousUrl = url()->previous();

    $lead = Lead::with('followUps')->findOrFail($lead_id);
    $types = FollowUp::$types; // ambil dari model
    return view('followups.index', compact('lead', 'types', 'previousUrl'));
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

    // public function get_appointment(){

    //     $reminders = FollowUp::where('type', 'appointment')
    //     ->whereNotNull('date')
    //     ->whereNull('dismissable')
    //     ->orWhere('dismissable', '!=', 'dismissed')                // pastikan kolom date tidak kosong/null
    //     ->where('date', '>', Carbon::now())   // hanya yang tanggalnya di masa depan
    //     ->with('lead.crm.category')
    //     ->orderBy('date', 'asc')              // urutkan dari yang paling dekat
    //     ->get();

    //     return $reminders;
    // }

     public function get_appointment2(Request $request)
{
    // 1️⃣ Ambil user dan semua kategori miliknya
    $user = User::where('id', $request->user_id)->with('categories')->firstOrFail();

    // 2️⃣ Ambil nama kategori dalam bentuk array
    $array_categories = $user->categories->pluck('name')->toArray();

    if($user->role == 'admin'){
        $reminders = FollowUp::where('type', 'appointment')
            ->whereNotNull('date')
            ->whereNull('dismissable')
            ->orWhere('dismissable', '!=', 'dismissed')                // pastikan kolom date tidak kosong/null
            ->where('date', '>', Carbon::now())   // hanya yang tanggalnya di masa depan
            ->with('lead.crm.category')
            ->orderBy('date', 'asc')              // urutkan dari yang paling dekat
            ->get();

            return $reminders;
    }

    // 3️⃣ Ambil semua follow-up yang category CRM-nya termasuk kategori user
    $reminders = FollowUp::where('type', 'appointment')
        ->whereNotNull('date')
        ->where(function ($query) {
            $query->whereNull('dismissable')
                  ->orWhere('dismissable', '!=', 'dismissed');
        })
        ->where('date', '>', now())
        ->whereHas('lead.crm.category', function ($query) use ($array_categories) {
            $query->whereIn('name', $array_categories);
        })
        ->with('lead.crm.category') // biar data relasi ikut di-load
        ->orderBy('date', 'asc')
        ->get();

        return $reminders;
}


    public function dismiss_appointment($id){
        try{
            $reminder = FollowUp::findOrFail($id);
            $reminder->update([
                'dismissable' => 'dismissed'
            ]);
            return response()->json(['status' => 'success', 'message' => 'Appointment dismissed']);

        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => 'ERROR']);
        }

    }

    // public function dismiss_all_appointment(){

    //     try{

    //         $reminders = FollowUp::where('type', 'appointment')->whereNull('dismissable')->get();
    //         foreach($reminders as $reminder){
    //             $reminder->update(['dismissable' => 'dismissed']);
    //         }
    //         return response()->json(['status' => 'success', 'message' => 'All Appointment dismissed']);

    //     }catch(\Exception $e){
    //         return response()->json(['status' => 'error', 'message' => 'ERROR']);
    //     }
    // }

    public function dismiss_all_appointment2(Request $request){

        try{

            $user = User::where('id', $request->user_id)->with('categories')->firstOrFail();
            // 2️⃣ Ambil nama kategori dalam bentuk array
            $array_categories = $user->categories->pluck('name')->toArray();

            if($user->role == 'admin'){
                $reminders = FollowUp::where('type', 'appointment')->whereNull('dismissable')->get();
                foreach($reminders as $reminder){
                    $reminder->update(['dismissable' => 'dismissed']);
                }
                return response()->json(['status' => 'success', 'message' => 'All Appointment dismissed']);
            }

           $reminders = FollowUp::where('type', 'appointment')
                ->whereNotNull('date')
                ->where(function ($query) {
                    $query->whereNull('dismissable')
                        ->orWhere('dismissable', '!=', 'dismissed');
                })
                ->where('date', '>', now())
                ->whereHas('lead.crm.category', function ($query) use ($array_categories) {
                    $query->whereIn('name', $array_categories);
                })
                ->with('lead.crm.category') // biar data relasi ikut di-load
                ->orderBy('date', 'asc')
                ->get();

            foreach($reminders as $reminder){
                $reminder->update(['dismissable' => 'dismissed']);
            }
            return response()->json(['status' => 'success', 'message' => 'All Appointment dismissed']);

        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => 'ERROR']);
        }
    }

    public function snooze_reminders(Request $request){

        try{
            // $user = Auth::user();
            $user = User::findOrFail($request->user_id);
            list($duration, $time) = explode('-', $request->duration);
            // $user->update([
            //     'snoozed_until' => Carbon::now()->addSeconds(30),
            // ]);
            // $user->save();
            $category = '';
            switch ($time) {
                case 's':
                    $category = 'S';
                    $user->update([
                        'snoozed_until' => Carbon::now()->addSeconds($duration),
                    ]);
                    $user->save();
                    break;
                case 'm':
                    $category = 'M';
                    $user->update([
                        'snoozed_until' => Carbon::now()->addMinutes($duration),
                    ]);
                    $user->save();
                    break;
                case 'h':
                    $category = 'H';
                    $user->update([
                        'snoozed_until' => Carbon::now()->addHours($duration),
                    ]);
                    $user->save();
                    break;
                case 'd':
                    $category = 'D';
                    $user->update([
                        'snoozed_until' => Carbon::now()->addDays($duration),
                    ]);
                    $user->save();
                    break;
                case 'w':
                    $category = 'W';
                    $user->update([
                        'snoozed_until' => Carbon::now()->addWeeks($duration),
                    ]);
                    $user->save();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'test snooze',
                // 'duration' => $duration,
                'time' => $time,
                'duration' => $duration,
                // 'test' => $test,
                'category' => $category,
                'user_id' => $request->user_id,
                // 'user' => $user,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'FAILED',
                'message' => 'ADA KESALAHAN'
            ]);
        }
    }
}

