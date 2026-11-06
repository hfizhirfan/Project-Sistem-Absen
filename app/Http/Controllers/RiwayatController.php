<?php


namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\lapizin;
use App\Models\lapcuti;
use App\Models\laplembur;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
         $riwayats = \App\Models\Riwayat::where('karyawan_id', session('id'))
                        ->latest()
                        ->get();

        return view('riwayat.index', compact('riwayats'));
    }

    private function getNotifikasiData($nip)
    {
        $izin = Lapizin::where('nip', $nip)->latest()->first();
        $izinStatus = null;
        $pdfAvailable = false;
        if ($izin && $izin->status_hrd === 'disetujui' && $izin->status_kepala_divisi === 'disetujui' && $izin->status_direktur === 'disetujui') {
            $izinStatus = 'disetujui';
            $pdfAvailable = true;
        } elseif ($izin && ($izin->status_hrd === 'ditolak' || $izin->status_kepala_divisi === 'ditolak' || $izin->status_direktur === 'ditolak')) {
            $izinStatus = 'ditolak';
        }

        $lembur = Laplembur::where('nip', $nip)->latest()->first();
        $lemburStatus = null;
        $lemburPdfAvailable = false;
        if ($lembur && $lembur->status_hrd === 'disetujui' && $lembur->status_kepala_divisi === 'disetujui') {
            $lemburStatus = 'disetujui';
            $lemburPdfAvailable = true;
        } elseif ($lembur && ($lembur->status_hrd === 'ditolak' || $lembur->status_kepala_divisi === 'ditolak')) {
            $lemburStatus = 'ditolak';
        }

        $cuti = Lapcuti::where('nip', $nip)->latest()->first();
        $cutiStatus = null;
        $cutiPdfAvailable = false;
        if ($cuti && $cuti->status_hrd === 'disetujui' && $cuti->status_kepala_divisi === 'disetujui') {
            $cutiStatus = 'disetujui';
            $cutiPdfAvailable = true;
        } elseif ($cuti && ($cuti->status_hrd === 'ditolak' || $cuti->status_kepala_divisi === 'ditolak')) {
            $cutiStatus = 'ditolak';
        }

        return compact(
            'izin', 'izinStatus', 'pdfAvailable',
            'lembur', 'lemburStatus', 'lemburPdfAvailable',
            'cuti', 'cutiStatus', 'cutiPdfAvailable'
        );
    }

}
