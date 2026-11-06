<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    protected $fillable = [
        'karyawan_id',  // ← Tambahkan ini
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'jenis_laporan',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(\App\Models\MasterKaryawan::class, 'karyawan_id');
    }

}


