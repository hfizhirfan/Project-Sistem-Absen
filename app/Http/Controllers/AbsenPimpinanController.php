<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterKaryawan;
use Carbon\Carbon;
use App\Models\lapabsen;

class AbsenPimpinanController extends Controller
{
    public function index(Request $request)
    {
        $nip = session('nip');

        $hariIni = Carbon::now()->toDateString();

        $recordAbsen = lapabsen::where('nip', $nip)
            ->whereDate('jam_absen', $hariIni)
            ->orderBy('jam_absen', 'desc')
            ->first();


        if ($recordAbsen) {
            session([
                'sudah_absen' => true,
                'waktu_absen' => $recordAbsen->jam_absen,
            ]);
        } else {
            session()->forget(['sudah_absen', 'waktu_absen']);
        }

        return view('absen_pimpinan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'divisi' => 'required|string|max:50',
            'jam_absen' => 'required|date',
        ]);

        DB::table('lapabsen')->insert([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'jam_absen' => $request->jam_absen,
        ]);

        // Set session sesuai waktu input absen
        session([
            'sudah_absen' => true,
            'waktu_absen' => $request->jam_absen,
        ]);

        $role = session('role');

        if ($role === 'hrd') {
            return redirect()->route('karyawan.index');
        } elseif ($role === 'kepala_divisi') {
            return redirect()->route('laplembur.index');
        } else {
            return redirect()->route('absen.pimpinan'); // fallback
        }

    }


}
