<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapabsen extends Model
{
    use HasFactory;

    protected $table = 'lapabsen'; // jika nama tabel tidak jamak

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'jam_absen',
    ];

    public $timestamps = true; // gunakan jika kamu pakai created_at & updated_at
}
