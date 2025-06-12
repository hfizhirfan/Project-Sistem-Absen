<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class lapizinseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lapizins')->insert([
            [
                'nip' => '214031',
                'nama' => 'Andi Saputra',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_izin' => '2025-06-07',
                'tanggal_masuk' => '2025-06-09',
                'keterangan' => 'Izin menghadiri pernikahan saudara',
                'status' => 'pending',
                'status_hrd' => 'pending',
                'status_kepala_divisi' => 'pending',
                'status_direktur' => 'pending',
                'keterangan_penolakan' => null,
                'bukti' => null, // 🔽 file opsional
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '221092',
                'nama' => 'Siti Aminah',
                'jabatan' => 'Manager Finance',
                'divisi' => 'Keuangan',
                'tanggal_izin' => '2025-06-08',
                'tanggal_masuk' => '2025-06-11',
                'keterangan' => 'Izin karena sakit',
                'status' => 'pending',
                'status_hrd' => 'pending',
                'status_kepala_divisi' => 'pending',
                'status_direktur' => 'pending',
                'keterangan_penolakan' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '214008',
                'nama' => 'Budi Pratama',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_izin' => '2025-06-09',
                'tanggal_masuk' => '2025-06-10',
                'keterangan' => 'Izin keperluan pribadi',
                'status' => 'pending',
                'status_hrd' => 'pending',
                'status_kepala_divisi' => 'pending',
                'status_direktur' => 'pending',
                'keterangan_penolakan' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
