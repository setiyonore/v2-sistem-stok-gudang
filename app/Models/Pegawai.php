<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = [
        'referensi_jabatan',
        'nama',
        'tgl_lahir',
        'nip',
        'no_hp',
        'alamat',
    ];
}
