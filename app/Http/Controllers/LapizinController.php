<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lapizin;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LapizinController extends Controller
{
    public function index()
    {
        $lapizins = lapizin::all();
        return view('lapizin.index', compact('lapizins'));  }

    public function create()
    {
        //
        return view('lapizin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'divisi' => 'required|string|max:50',
            'tanggal_cuti' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // opsional
        ]);

        // Upload file jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_izin', 'public');
        }

        // Simpan ke DB
        lapizin::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_izin' => $request->tanggal_cuti,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'keterangan_penolakan' => $request->status == 'ditolak' ? $request->keterangan : null,
            'bukti' => $buktiPath,
        ]);

        return redirect()->route('lapabsen.create')->with('success', 'Pengajuan izin berhasil dikirim.');
    }


    public function edit($id)
    {
        $lapizin = Lapizin::findOrFail($id); // Ambil data berdasarkan ID
        return view('lapizin.edit', compact('lapizin'));
    }

    public function update(Request $request, $id)
    {
        $lapizin = Lapizin::findOrFail($id);
        $role = session('role');

        // Batasi akses hanya untuk HRD, Kepala Divisi, dan Direktur
        if (!in_array($role, ['hrd', 'kepala_divisi', 'direktur'])) {
            return redirect()->route('lapizin.index')
                ->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        if ($request->action === 'acc') {
            // Setujui berdasarkan role
            if ($role === 'hrd') {
                $lapizin->status_hrd = 'disetujui';
            } elseif ($role === 'kepala_divisi') {
                $lapizin->status_kepala_divisi = 'disetujui';
            } elseif ($role === 'direktur') {
                $lapizin->status_direktur = 'disetujui';
            }

            // Update status utama jika semua menyetujui
            if (
                $lapizin->status_hrd === 'disetujui' &&
                $lapizin->status_kepala_divisi === 'disetujui' &&
                $lapizin->status_direktur === 'disetujui'
            ) {
                $lapizin->status = 'disetujui';
            }

            // Reset penolakan
            $lapizin->keterangan_penolakan = null;
            $lapizin->updated_at = now();
            $lapizin->save();

            return redirect()->route('lapizin.index')
                ->with('success', 'Izin telah disetujui oleh ' . strtoupper($role) . '.');
        }

        if ($request->action === 'tolak') {
            $request->validate([
                'keterangan_penolakan' => 'required|string|min:10',
            ]);

            // Tolak berdasarkan role
            if ($role === 'hrd') {
                $lapizin->status_hrd = 'ditolak';
            } elseif ($role === 'kepala_divisi') {
                $lapizin->status_kepala_divisi = 'ditolak';
            } elseif ($role === 'direktur') {
                $lapizin->status_direktur = 'ditolak';
            }

            // Jika salah satu menolak, status utama langsung ditolak
            $lapizin->status = 'ditolak';
            $lapizin->keterangan_penolakan = $request->keterangan_penolakan;
            $lapizin->updated_at = now();
            $lapizin->save();

            return redirect()->route('lapizin.index')
                ->with('success', 'Izin telah ditolak oleh ' . strtoupper($role) . '.');
        }

        return redirect()->route('lapizin.index')
            ->with('error', 'Aksi tidak valid.');
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

    public function destroy($id)
    {
        $lapizin = lapizin::findOrFail($id);
        $lapizin->delete();

        return redirect()->route('lapizin.index')->with('success', 'Data lembur berhasil dihapus.');
    }
    public function downloadPDF($id)
    {
        $izin = Lapizin::findOrFail($id);

        $pdf = Pdf::loadView('pdf.izin', compact('izin'));
        return $pdf->download("izin_{$izin->nip}.pdf");
    }
}
