<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_masuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $fillable = [
        'tanggal',
        'yang_menyerahkan',
        'pegawai_id',
        'keterangan',
        'penyedia_id',
    ];
}
