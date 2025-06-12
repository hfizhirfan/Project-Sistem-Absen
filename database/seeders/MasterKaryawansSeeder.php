<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterKaryawan;

class MasterKaryawansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nip' => '211001',
                'nama' => 'Yudha',
                'jabatan' => 'Manager',
                'divisi' => 'Produksi',
            ],
            [
                'nip' => '211021',
                'nama' => 'Pociki',
                'jabatan' => 'Pegawai',
                'divisi' => 'Produksi',
            ],
            [
                'nip' => '211013',
                'nama' => 'Iruka',
                'jabatan' => 'Pegawai',
                'divisi' => 'Gudang',
            ],
            [
                'nip' => '211049',
                'nama' => 'Sukuna',
                'jabatan' => 'Admin',
                'divisi' => 'Produksi',
            ],
            [
                'nip' => '413001',
                'nama' => 'Dina',
                'jabatan' => 'HRD Staff',
                'divisi' => 'SDM',
            ],
            [
                'nip' => '501003',
                'nama' => 'Rian',
                'jabatan' => 'Supervisor',
                'divisi' => 'Pemasaran',
            ],
            [
                'nip' => '141001',
                'nama' => 'Aldo',
                'jabatan' => 'Direktur Utama',
                'divisi' => 'Manajemen',
            ],
        ];

        foreach ($data as $item) {
            $rolePrefix = substr($item['nip'], 0, 1);
            $role = match ($rolePrefix) {
                '2' => 'karyawan',
                '4' => 'hrd',
                '5' => 'kepala_divisi',
                '1' => 'direktur',
                default => 'karyawan',
            };

            $password = Hash::make(strtolower($item['nama']) . substr($item['nip'], -3));

            MasterKaryawan::create([
                'nip' => $item['nip'],
                'nama' => $item['nama'],
                'jabatan' => $item['jabatan'],
                'divisi' => $item['divisi'],
                'role' => $role,
                'password' => $password,
            ]);
        }
    }
}
