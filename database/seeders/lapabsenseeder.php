<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class lapabsenseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lapabsen')->insert([
            [
                'nip' => '12345678',
                'nama' => 'Budi Santoso',
                'jabatan' => 'Staff',
                'divisi' => 'HRD',
                'jam_absen' => Carbon::now(),
                
            ],
        ]);
    }
}