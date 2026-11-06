<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lapcuti extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'tanggal_izin',
        'tanggal_masuk',
        'keterangan',
        'status',
        'status_hrd', // ← ini juga
        'status_kepala_divisi', // ← dan ini
        'status_direktur',
        'keterangan_penolakan',
    ];

}
