<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lapcuti;
use Illuminate\Support\Facades\DB;

class LapcutiController extends Controller
{
    public function index()
    {
        $lapcutis = lapcuti::all();
        return view('lapcuti.index', compact('lapcutis'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lapcuti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'divisi' => 'required|string|max:50',
            'tanggal_izin' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        lapcuti::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_izin' => $request->tanggal_izin, // disesuaikan
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'status' => 'pending', // default saat pengajuan
        ]);

        return redirect()->route('lapabsen.create')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lapcuti = lapcuti::findOrFail($id); // Ambil data berdasarkan ID
        return view('lapcuti.edit', compact('lapcuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lapcuti = LapCuti::findOrFail($id);
        $role = session('role');

        if (!in_array($role, ['hrd', 'kepala_divisi', 'direktur'])) {
            return redirect()->route('lapcuti.index')
                ->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        if ($request->action === 'acc') {
            // Setujui berdasarkan role
            if ($role === 'hrd') {
                $lapcuti->status_hrd = 'disetujui';
            } elseif ($role === 'kepala_divisi') {
                $lapcuti->status_kepala_divisi = 'disetujui';
            } elseif ($role === 'direktur') {
                $lapcuti->status_direktur = 'disetujui';
            }

            // Jika semua sudah setuju, set status utama menjadi disetujui
            if (
                $lapcuti->status_hrd === 'disetujui' &&
                $lapcuti->status_kepala_divisi === 'disetujui' &&
                $lapcuti->status_direktur === 'disetujui'
            ) {
                $lapcuti->status = 'disetujui';
            }

            $lapcuti->keterangan_penolakan = null; // bersihkan jika sebelumnya ditolak
            $lapcuti->updated_at = now();
            $lapcuti->save();

            return redirect()->route('lapcuti.index')
                ->with('success', 'Cuti telah disetujui oleh ' . strtoupper($role) . '.');
        }

        if ($request->action === 'tolak') {
            $request->validate([
                'keterangan_penolakan' => 'required|string|min:10',
            ]);

            // Tolak berdasarkan role
            if ($role === 'hrd') {
                $lapcuti->status_hrd = 'ditolak';
            } elseif ($role === 'kepala_divisi') {
                $lapcuti->status_kepala_divisi = 'ditolak';
            } elseif ($role === 'direktur') {
                $lapcuti->status_direktur = 'ditolak';
            }

            // Jika salah satu menolak, status utama otomatis ditolak
            $lapcuti->status = 'ditolak';
            $lapcuti->keterangan_penolakan = $request->keterangan_penolakan;
            $lapcuti->updated_at = now();
            $lapcuti->save();

            return redirect()->route('lapcuti.index')
                ->with('success', 'Cuti telah ditolak oleh ' . strtoupper($role) . '.');
        }

        return redirect()->route('lapcuti.index')
            ->with('error', 'Aksi tidak valid.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lapcuti = lapcuti::findOrFail($id);
        $lapcuti->delete();

        return redirect()->route('lapcuti.index')->with('success', 'Data lembur berhasil dihapus.');
    }
}
