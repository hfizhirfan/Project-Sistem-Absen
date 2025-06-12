<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lapizin extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'tanggal_izin',
        'tanggal_masuk',
        'keterangan',
        'bukti', // ← tambahkan ini
        'status',
        'status_hrd', // ← ini juga
        'status_kepala_divisi', // ← dan ini
        'status_direktur', // ← dan ini
        'keterangan_penolakan',
    ];
}

