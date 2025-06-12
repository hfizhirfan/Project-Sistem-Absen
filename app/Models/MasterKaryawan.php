<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKaryawan extends Model
{
    protected $fillable = [
        'nip', 'nama', 'jabatan', 'divisi', 'role', 'password'
    ];

    protected $hidden = ['password'];

    public function getAuthIdentifierName()
    {
        return 'nip';
    }
}
