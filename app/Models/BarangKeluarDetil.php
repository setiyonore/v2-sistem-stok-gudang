<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetil extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar_detil';
    protected $fillable = [
        'barang_keluar_id',
        'barang_id',
        'jumlah',
    ];
}
