<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarItem extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar_item';
    protected $fillable = [
        'order_barang_id',
        'barang_id',
        'item_id',
    ];
}
