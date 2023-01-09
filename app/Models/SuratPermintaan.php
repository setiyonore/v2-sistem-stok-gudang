<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPermintaan extends Model
{
    use HasFactory;
    protected $table = 'surat_permintaan';
    protected $fillable = [
        'no_sp',
        'tanggal',
        'referensi_status_sp',
        'keterangan',
        'pelanggan_id',
    ];
}
