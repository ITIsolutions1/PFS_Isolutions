<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crm;
use App\Models\Broadcasting;
use Illuminate\Support\Facades\Mail;
use App\Mail\BroadcastMail;
use Carbon\Carbon;
use App\Models\Categories;

class BroadcastController extends Controller
{


public function uploadEmailImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:2048'
    ]);

    $path = $request->file('image')->store('email-images', 'public');

   return response()->json([
    'url' => secure_asset('storage/' . $path)
]);

}


    public function index()
    {
        $logs = Broadcasting::orderBy('created_at', 'desc')->paginate(10);

        // Hitung broadcast bulan ini (hanya yang status 'sent')
        $totalThisMonth = Broadcasting::where('status', 'sent')
            ->whereMonth('sent_at', Carbon::now()->month)
            ->whereYear('sent_at', Carbon::now()->year)
            ->count();

        // Hitung broadcast hari ini (hanya yang status 'sent')
        $totalToday = Broadcasting::where('status', 'sent')
            ->whereDate('sent_at', Carbon::today())
            ->count();

        return view('broadcast.index', compact('logs', 'totalThisMonth', 'totalToday'));
    }

    public function create()
{
    // Ambil data client dengan relasi category
    $clients = Crm::with('category')->get();

    // Ambil daftar kategori untuk filter di view
    $categories = Categories::orderBy('name', 'asc')->get();

    return view('broadcast.create', compact('clients', 'categories'));
}


    public function send(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
            'recipients' => 'required|array|min:1',
            'attachment' => 'nullable|file|max:10048'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('broadcast_attachments', 'public');
        }

        // Simpan log sekali saja
        $log = Broadcasting::create([
            'email'      => json_encode($request->recipients),
            'subject'    => $request->subject,
            'message'    => $request->message,
            'attachment' => $attachmentPath,
            'status'     => 'pending',
            'queued_at'  => now()
        ]);

        try {
            foreach ($request->recipients as $email) {
                Mail::mailer('marketing')
                    ->to($email)
                    ->queue(new BroadcastMail(
                        $request->subject,
                        $request->message,
                        $attachmentPath ? storage_path('app/public/' . $attachmentPath) : null
                    ));
            }

            // Setelah semua dikirim (queued)
            $log->update([
                'status'  => 'sent',
                'sent_at' => now()
            ]);
        } catch (\Exception $e) {
            $log->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage()
            ]);
        }

        return redirect()->route('broadcast.index')->with('success', 'Broadcast email sent successfully!');
    }

     public function edit($id)
    {
        $broadcast = Broadcasting::findOrFail($id);
        return view('broadcast.edit', compact('broadcast'));
    }

    // Update data broadcast
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            // tambahkan validasi lain jika perlu
        ]);

        $broadcast = Broadcasting::findOrFail($id);
        $broadcast->subject = $request->subject;
        $broadcast->message = $request->message;
        // update field lain jika perlu
        $broadcast->save();

        return redirect()->route('broadcast.index')->with('success', 'Broadcast updated successfully.');
    }

    // Hapus data broadcast
    public function destroy($id)
    {
        $broadcast = Broadcasting::findOrFail($id);
        // Jika ada file attachment, hapus juga filenya
        if ($broadcast->attachment) {
            \Storage::disk('public')->delete($broadcast->attachment);
        }
        $broadcast->delete();

        return redirect()->route('broadcast.index')->with('success', 'Broadcast deleted successfully.');
    }
}
