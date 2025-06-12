<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lapizin;
use App\Models\lapcuti;
use App\Models\laplembur; // Pastikan model sudah di-import

class PengajuanController extends Controller
{
    public function createIzin()
    {
        return view('pengajuan.izin');
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
        Lapizin::create([
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

        return redirect()->route('absen.create')->with('success', 'Pengajuan izin berhasil dikirim.');
    }



    public function createCuti()
    {
        return view('pengajuan.cuti'); // ubah view-nya sesuai folder baru
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

        lapcuti::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'tanggal_izin' => $request->tanggal_izin,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('absen.create')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
    public function createLembur()
    {
        return view('pengajuan.lembur'); // Asumsinya kamu sudah pindahkan view-nya ke resources/views/pengajuan/lembur.blade.php
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

        lapLembur::create([
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

        return redirect()->route('absen.create')->with('success', 'Laporan lembur berhasil ditambahkan.');
    }

}
