<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LapcutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lapcutis')->insert([
            [
                'nip' => '214031',
                'nama' => 'Andi Saputra',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_izin' => Carbon::parse('2025-06-10'),
                'tanggal_masuk' => Carbon::parse('2025-06-12'),
                'keterangan' => 'Izin karena urusan keluarga',
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
                'tanggal_izin' => Carbon::parse('2025-06-05'),
                'tanggal_masuk' => Carbon::parse('2025-06-07'),
                'keterangan' => 'Izin karena sakit',
                'status' => 'disetujui',
                'keterangan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '214008',
                'nama' => 'Budi Pratama',
                'jabatan' => 'IT Support',
                'divisi' => 'IT',
                'tanggal_izin' => Carbon::parse('2025-06-03'),
                'tanggal_masuk' => Carbon::parse('2025-06-04'),
                'keterangan' => 'Izin pribadi',
                'status' => 'pending',
                'keterangan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
