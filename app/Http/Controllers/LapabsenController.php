<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lapabsen;
use Illuminate\Support\Facades\DB;

class LapabsenController extends Controller

{
    public function index()
    {
        $lapabsen = lapabsen::all();
        return view('lapabsen.index', compact('lapabsen'));
    }


    public function destroy($id)
    {

        $lapabsen = lapabsen::findOrFail($id);
        $lapabsen->delete();

        return redirect()->route('lapabsen.index')->with('success', 'Data lembur berhasil dihapus.');
    }




}
