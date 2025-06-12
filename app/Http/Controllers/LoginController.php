<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\MasterKaryawan;

class LoginController extends Controller
{
    public function index()
    {
        return view('login'); // Tampilan login
    }

    public function authenticate(Request $request)
    {
         $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        Log::info('Login attempt:', ['nip' => $request->nip]);

        $karyawan = MasterKaryawan::where('nip', trim($request->nip))->first();

        if (!$karyawan) {
            Log::warning('Karyawan tidak ditemukan:', ['nip' => $request->nip]);
            return response()->json([
                'success' => false,
                'message' => 'NIP tidak terdaftar.'
            ], 401);
        }

        if (!Hash::check($request->password, $karyawan->password)) {
            Log::warning('Password salah untuk NIP:', ['nip' => $request->nip]);
            return response()->json([
                'success' => false,
                'message' => 'Password salah.'
            ], 401);
        }

        $request->session()->put([
            'nip' => $karyawan->nip,
            'nama' => $karyawan->nama,
            'jabatan' => $karyawan->jabatan,
            'divisi' => $karyawan->divisi,
            'role' => $karyawan->role,
        ]);

        Log::info('Role yang terdeteksi:', ['role' => $karyawan->role]);


        if ($karyawan->role === 'direktur') {
            // Direktur tidak perlu absen
            $redirectRoute = route('laplembur.index');
        } elseif (in_array($karyawan->role, ['hrd', 'kepala_divisi'])) {
            // HRD & kepala divisi tetap absen dulu
            $redirectRoute = route('absen.pimpinan');
        } else {
            // Karyawan biasa
            $redirectRoute = route('absen.create');
        }


        return response()->json([
            'success' => true,
            'redirect' => $redirectRoute
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush(); // Hapus semua data sesi
        $request->session()->regenerateToken(); // Regenerasi CSRF token

        return redirect('/'); // Redirect ke halaman login
    }

}
