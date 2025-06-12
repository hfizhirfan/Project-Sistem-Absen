<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class laplemburseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laplemburs')->insert([
            [
                'nip' => '214031',
                'nama' => 'Andi Saputra',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_lembur' => '2025-06-06',
                'jam_mulai' => '18:00:00',
                'jam_selesai' => '21:00:00',
                'durasi' => 3.00,
                'keterangan' => 'Lembur untuk maintenance server',
                'status' => 'pending',
                'keterangan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '221092',
                'nama' => 'Siti Aminah',
                'jabatan' => 'Manager Finance',
                'divisi' => 'Keuangan',
                'tanggal_lembur' => '2025-06-05',
                'jam_mulai' => '19:00:00',
                'jam_selesai' => '22:00:00',
                'durasi' => 3.00,
                'keterangan' => 'Backup sistem dan testing aplikasi',
                'status' => 'pending',
                'keterangan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '214008',
                'nama' => 'Budi Pratama',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_lembur' => '2025-06-04',
                'jam_mulai' => '17:00:00',
                'jam_selesai' => '20:00:00',
                'durasi' => 3.00,
                'keterangan' => 'Lembur pengemasan barang ekspor',
                'status' => 'pending',
                'keterangan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

}
