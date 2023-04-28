<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama',
        'stok',
        'referensi_kategori',
        'referensi_satuan',
    ];

    // public function kategori(){
    //     return $this->belongsTo(Referensi::class);
    // }
    // public function satuan()
    // {
    //     return $this->belongsTo(Referensi::class);
    // }
}
