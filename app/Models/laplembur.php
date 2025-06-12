<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapLembur extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'laplemburs'; 

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'tanggal_lembur',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'durasi',
        'status',
        'keterangan_penolakan',
    ];
}