<?php

namespace App\Traits;

use App\Models\HistoryStatusItem;

trait HistoryStatusItemTraits
{
    public function storeHistory($item_id, $tanggal, $status, $jenis_transaksi)
    {

        return HistoryStatusItem::query()
            ->create([
                'item_id' => $item_id,
                'tanggal' => $tanggal,
                'referensi_status_item' => $status,
                'referensi_jenis_transaksi' => $jenis_transaksi
            ]);


    }
}
