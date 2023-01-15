<?php

namespace App\Traits;

use App\Models\Barang;

trait GoodsTraits
{
    public function changeStock($id, $jumlah, $option)
    {
        $oldStock = Barang::query()
            ->where('id', $id)
            ->select('stok')->first();
        if ($option == "plus") {
            $newStock = $oldStock->stok + $jumlah;
        } else {
            $newStock = $oldStock->stok - $jumlah;
        }

        $barang = Barang::query()->find($id);
        $barang->stok = $newStock;
        // $barang->save();
        dd($newStock);
    }
}
