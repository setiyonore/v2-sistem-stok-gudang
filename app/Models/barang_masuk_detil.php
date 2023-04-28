<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_masuk_detil extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk_detil';
    protected $fillable = [
        'barang_masuk_id',
        'barang_id',
        'jumlah',
    ];
}
