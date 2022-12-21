<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    use HasFactory;
    protected $table = 'referensi';
    protected $fillable = [
        'nama',
        'deskripsi',
        'jenis_referensi_id'
    ];
    public function jenis_referensi()
    {
        return $this->belongsTo(JenisReferensi::class);
    }
}
