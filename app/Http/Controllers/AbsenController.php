<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterKaryawan;
use App\Models\lapizin;
use Barryvdh\DomPDF\Facade\Pdf;


class AbsenController extends Controller
{
    public function create()
    {
        $nip = session('nip');

        if ($nip) {
            $karyawan = MasterKaryawan::where('nip', $nip)->first();

            if ($karyawan) {
                session()->put([
                    'jabatan' => $karyawan->jabatan,
                    'divisi' => $karyawan->divisi,
                ]);

                $hariIni = now()->toDateString();
                $sudahAbsen = DB::table('lapabsen')
                    ->where('nip', $nip)
                    ->whereDate('jam_absen', $hariIni)
                    ->exists();

                session(['sudah_absen' => $sudahAbsen]);

                if ($sudahAbsen) {
                    $waktuAbsen = DB::table('lapabsen')
                        ->where('nip', $nip)
                        ->whereDate('jam_absen', $hariIni)
                        ->value('jam_absen');

                    session(['waktu_absen' => $waktuAbsen]);
                } else {
                    session()->forget('waktu_absen');
                }

                // Cek status izin terbaru
                $izin = Lapizin::where('nip', $nip)
                    ->orderByDesc('created_at')
                    ->first();

                $izinStatus = null;
                $pdfAvailable = false;

                if ($izin) {
                    if ($izin->status_hrd === 'disetujui' && $izin->status_kepala_divisi === 'disetujui' && $izin->status_direktur === 'disetujui') {
                        $izinStatus = 'disetujui';
                        $pdfAvailable = true;
                    } elseif (
                        $izin->status_hrd === 'ditolak' ||
                        $izin->status_kepala_divisi === 'ditolak' ||
                        $izin->status_direktur === 'ditolak'
                    ) {
                        $izinStatus = 'ditolak';
                    }
                }

                return view('absen.create', compact('izinStatus', 'pdfAvailable', 'izin'));
            }
        }

        session()->forget(['sudah_absen', 'waktu_absen']);
        return view('absen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'divisi' => 'required|string|max:50',
        ]);

        DB::table('lapabsen')->insert([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'jam_absen' => now(),
        ]);

        session([
            'sudah_absen' => true,
            'waktu_absen' => now()->format('Y-m-d H:i:s'),
        ]);

        // arahkan ke route baru 'absen.create'
        return redirect()->route('absen.create');
    }
}
