<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterKaryawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class MasterKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $master_karyawans = MasterKaryawan::all();
        return view('karyawan.index', compact('master_karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|max:45|unique:master_karyawans,nip',
            'nama' => 'required|max:45',
            'jabatan' => 'required|max:45',
            'divisi' => 'required|max:45',
        ]);

        $nama = strtolower($request->nama);
        $nip = $request->nip;
        $lastThreeDigits = substr($nip, -3);
        $password = Hash::make($nama . $lastThreeDigits);

        $role = $this->getRoleFromNip($nip); // otomatis berdasarkan NIP

        MasterKaryawan::create([
            'nip' => $nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'role' => $role,
            'password' => $password,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(MasterKaryawan $karyawan)
    {
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterKaryawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|max:45|unique:master_karyawans,nip,' . $id,
            'nama' => 'required|max:45',
            'jabatan' => 'required|max:45',
            'divisi' => 'required|max:45',
        ]);

        $karyawan = MasterKaryawan::findOrFail($id);

        $role = $this->getRoleFromNip($request->nip); // otomatis update role jika NIP berubah

        $karyawan->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'role' => $role,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(MasterKaryawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')
                ->with('success','Data berhasil di hapus' );
    }

    private function getRoleFromNip(string $nip): string
    {
        return match (substr($nip, 0, 1)) {
            '1' => 'direktur',
            '2' => 'karyawan',
            '4' => 'hrd',
            '5' => 'kepala_divisi',
            default => 'karyawan',
        };
    }
}
