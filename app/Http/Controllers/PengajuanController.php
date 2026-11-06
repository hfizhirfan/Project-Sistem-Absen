<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lapizin;
use App\Models\lapcuti;
use App\Models\laplembur;
use App\Models\Riwayat;

class PengajuanController extends Controller
{
    public function createIzin()
    {
         $data = $this->getNotifikasiData(session('nip'));
        return view('pengajuan.izin', $data);
    }

    public function storeIzin(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:50',
            'divisi' => 'required|string|max:50',
            'tanggal_cuti' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Proses upload file jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $originalName = pathinfo($request->file('bukti')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('bukti')->getClientOriginalExtension();
            $filename = $originalName . '_' . time() . '.' . $extension;

            // Simpan file dengan nama asli + timestamp
            $buktiPath = $request->file('bukti')->storeAs('bukti', $filename, 'public');
        }

        // Simpan data ke database
        $izin = Lapizin::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_izin' => $request->tanggal_cuti,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'bukti' => $buktiPath, // akan seperti: "bukti/surat_dokter_1718203943.png"
            'keterangan_penolakan' => null,
            'status' => 'pending',
            'status_hrd' => 'pending',
            'status_kepala_divisi' => 'pending',
            'status_direktur' => 'pending',
        ]);

        Riwayat::create([
            'karyawan_id' => session('id'), // <-- tambahkan ini
            'nip' => $izin->nip,
            'nama' => $izin->nama,
            'jabatan' => $izin->jabatan,
            'divisi' => $izin->divisi,
            'jenis_laporan' => 'izin',
            'status' => 'pending',
        ]);


        return redirect()->route('absen.create')->with('success', 'Pengajuan izin berhasil dikirim.');
    }



    public function createCuti()
    {
        $data = $this->getNotifikasiData(session('nip'));
        return view('pengajuan.cuti', $data);
    }

    public function storeCuti(Request $request)
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

        $cuti = Lapcuti::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_izin' => $request->tanggal_izin,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);


        Riwayat::create([
            'karyawan_id' => session('id'), // <-- tambahkan ini
            'nip' => $cuti->nip,
            'nama' => $cuti->nama,
            'jabatan' => $cuti->jabatan,
            'divisi' => $cuti->divisi,
            'jenis_laporan' => 'cuti',
            'status' => 'pending',
        ]);


        return redirect()->route('absen.create')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
    public function createLembur()
    {
        $data = $this->getNotifikasiData(session('nip'));
        return view('pengajuan.lembur', $data);
    }

    public function storeLembur(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'divisi' => 'required|string',
            'tanggal_lembur' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keterangan' => 'nullable|string',
            'durasi' => 'nullable|numeric|min:0',
        ]);

        $lembur = LapLembur::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_lembur' => $request->tanggal_lembur,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'durasi' => $request->durasi,
            'status' => 'pending',
            'keterangan_penolakan' => null,
        ]);


        Riwayat::create([
            'karyawan_id' => session('id'), // <-- tambahkan ini
            'nip' => $lembur->nip,
            'nama' => $lembur->nama,
            'jabatan' => $lembur->jabatan,
            'divisi' => $lembur->divisi,
            'jenis_laporan' => 'lembur',
            'status' => 'pending',
        ]);


        return redirect()->route('absen.create')->with('success', 'Laporan lembur berhasil ditambahkan.');
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
