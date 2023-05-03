<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_masuk_item extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk_item';
    protected $fillable = [
        'barang_masuk_id',
        'item_id',
    ];
}
