<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisReferensi extends Model
{
    use HasFactory;
    protected $table = 'jenis_referensi';
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
