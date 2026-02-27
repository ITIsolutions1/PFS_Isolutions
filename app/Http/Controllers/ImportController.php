<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
   use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactImport;

class ImportController extends Controller
{


public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,xlsx'
    ]);

    Excel::import(new ContactImport, $request->file('file'));

    return back()->with('success', 'Data berhasil diimport');
}

}
