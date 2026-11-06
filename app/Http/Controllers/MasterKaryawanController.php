<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterKaryawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


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
        $messages = [
            'nip.required'   => 'NIP wajib diisi.',
            'nip.unique'     => 'NIP sudah terdaftar.',
            'nip.regex'      => 'Format NIP harus berupa 6 digit angka.',
            'nama.required'  => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'divisi.required'  => 'Divisi wajib diisi.',
        ];

        $validated = $request->validate([
            'nip'     => 'required|regex:/^\d{6}$/|unique:master_karyawans,nip',
            'nama'    => 'required|max:45',
            'jabatan' => 'required|max:45',
            'divisi'  => 'required|max:45',
        ], $messages);

        $nip     = $request->nip;
        $jabatan = $request->jabatan;

        // Hitung role versi NIP dan versi jabatan
        $roleFromNip     = $this->getRoleFromNip($nip);
        $roleFromJabatan = $this->getExpectedRoleFromJabatan($jabatan);

        if ($roleFromNip !== $roleFromJabatan) {
            // kembalikan dengan error
            return back()
                ->withInput()
                ->withErrors([
                    'jabatan' => 'Jabatan tidak sesuai dengan golongan NIP.',
                ]);
        }

        $password = Hash::make(Str::random(10));

        MasterKaryawan::create([
            'nip'      => $nip,
            'nama'     => $request->nama,
            'jabatan'  => $jabatan,
            'divisi'   => $request->divisi,
            'role'     => $roleFromJabatan,   // keduanya sudah sama
            'password' => $password,
        ]);

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
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
        $messages = [
            'nip.required'   => 'NIP wajib diisi.',
            'nip.unique'     => 'NIP sudah terdaftar.',
            'nama.required'  => 'Nama wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'divisi.required'  => 'Divisi wajib diisi.',
        ];

        $request->validate([
            'nip'     => 'required|regex:/^\d{6}$/|unique:master_karyawans,nip,' . $id,
            'nama'    => 'required|max:45',
            'jabatan' => 'required|max:45',
            'divisi'  => 'required|max:45',
        ], $messages);

        $karyawan = MasterKaryawan::findOrFail($id);

        // 1. role versi NIP
        $roleFromNip = $this->getRoleFromNip($request->nip);

        // 2. role versi Jabatan
        $roleFromJabatan = $this->getExpectedRoleFromJabatan($request->jabatan);

        // 3. Cek konsistensi
        if ($roleFromNip !== $roleFromJabatan) {
            return back()
                ->withInput()
                ->withErrors(['jabatan' => 'Jabatan tidak sesuai dengan golongan NIP.']);
        }

        // 4. Jika konsisten → simpan
        $karyawan->update([
            'nip'    => $request->nip,
            'nama'   => $request->nama,
            'jabatan'=> $request->jabatan,
            'divisi' => $request->divisi,
            'role'   => $roleFromNip, // keduanya sama
        ]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
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

    private function getExpectedRoleFromJabatan(string $jabatan): string
    {
        $jabatan = strtolower($jabatan);

        return match (true) {
            str_contains($jabatan, 'direktur') => 'direktur',
            str_contains($jabatan, 'hrd') => 'hrd',
            str_contains($jabatan, 'kepala') || str_contains($jabatan, 'manager') || str_contains($jabatan, 'supervisor') => 'kepala_divisi',
            default => 'karyawan',
        };
    }


}
