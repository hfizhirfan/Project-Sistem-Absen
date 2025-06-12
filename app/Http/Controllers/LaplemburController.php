<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\laplembur;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LaplemburController extends Controller
{
    public function index()
    {
        $laplemburs = laplembur::all();
        return view('laplembur.index', compact('laplemburs'));
    }


    public function edit($id)
    {
        $laplembur = LapLembur::findOrFail($id); // cari data berdasarkan ID
        return view('laplembur.edit', compact('laplembur'));
    }

    public function update(Request $request, $id)
    {
        $laplembur = LapLembur::findOrFail($id);
        $role = session('role');

        if (!in_array($role, ['hrd', 'kepala_divisi', 'direktur'])) {
            return redirect()->route('laplembur.index')
                ->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }

        if ($request->action === 'acc') {
            // Setujui berdasarkan role
            if ($role === 'hrd') {
                $laplembur->status_hrd = 'disetujui';
            } elseif ($role === 'kepala_divisi') {
                $laplembur->status_kepala_divisi = 'disetujui';
            } elseif ($role === 'direktur') {
                $laplembur->status_direktur = 'disetujui';
            }

            // Jika semua sudah setuju, set status utama menjadi disetujui
            if (
                $laplembur->status_hrd === 'disetujui' &&
                $laplembur->status_kepala_divisi === 'disetujui' &&
                $laplembur->status_direktur === 'disetujui'
            ) {
                $laplembur->status = 'disetujui';
            }

            $laplembur->keterangan_penolakan = null; // bersihkan jika sebelumnya ditolak
            $laplembur->updated_at = now();
            $laplembur->save();

            return redirect()->route('laplembur.index')
                ->with('success', 'Lembur telah disetujui oleh ' . strtoupper($role) . '.');
        }

        if ($request->action === 'tolak') {
            $request->validate([
                'keterangan_penolakan' => 'required|string|min:10',
            ]);

            // Tolak berdasarkan role
            if ($role === 'hrd') {
                $laplembur->status_hrd = 'ditolak';
            } elseif ($role === 'kepala_divisi') {
                $laplembur->status_kepala_divisi = 'ditolak';
            } elseif ($role === 'direktur') {
                $laplembur->status_direktur = 'ditolak';
            }

            // Jika salah satu menolak, status utama otomatis ditolak
            $laplembur->status = 'ditolak';
            $laplembur->keterangan_penolakan = $request->keterangan_penolakan;
            $laplembur->updated_at = now();
            $laplembur->save();

            return redirect()->route('laplembur.index')
                ->with('success', 'Lembur telah ditolak oleh ' . strtoupper($role) . '.');
        }

        return redirect()->route('laplembur.index')
            ->with('error', 'Aksi tidak valid.');
    }

    public function destroy($id)
    {
        $laplembur = LapLembur::findOrFail($id);
        $laplembur->delete();

        return redirect()->route('laplembur.index')->with('success', 'Data lembur berhasil dihapus.');
    }






}

