<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStatusItem extends Model
{
    use HasFactory;
    protected $table = 'history_status_item';
    protected $fillable = [
        'item_id',
        'tanggal',
        'referensi_status_item',
        'referensi_jenis_transaksi',
    ];
}
