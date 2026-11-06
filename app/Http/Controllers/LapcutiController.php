<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lapcuti;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LapcutiController extends Controller
{
    public function index()
    {
        $lapcutis = lapcuti::all();
        return view('lapcuti.index', compact('lapcutis'));
    }

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

     public function downloadPDF($id)
    {
        $cuti = lapcuti::findOrFail($id);

        $pdf = Pdf::loadView('pdf.cuti', compact('cuti'));
        return $pdf->download("cuti_{$cuti->nip}.pdf");
    }
}
