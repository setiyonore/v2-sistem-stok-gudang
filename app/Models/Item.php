<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $fillable = [
        'barang_id',
        'referensi_kondisi_barang',
        'no_serial',
        'referensi_status_item'
    ];
}
