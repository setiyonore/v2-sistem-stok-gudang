<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBarang extends Model
{
    use HasFactory;

    protected $table = 'order_barang';
    protected $fillable = [
        'no_sp',
        'tanggal',
        'referensi_status_order',
        'keterangan',
        'pelanggan_id',
        'pegawai_id',
    ];
}
