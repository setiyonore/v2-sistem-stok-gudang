<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Inertia\Inertia;

class GoodsController extends Controller
{
    public function index()
    {
        $barang = Barang::query()
            ->when(request()->q, function ($barang) {
                $barang = $barang->where('barang.nama', 'like', '%' . request()->q . '%');
            })
            ->leftJoin('referensi as satuan', 'satuan.id', 'barang.referensi_satuan')
            ->leftJoin('referensi as kategori', 'kategori.id', 'barang.referensi_kategori')
            ->select(
                'barang.nama',
                'satuan.nama as satuan',
                'kategori.nama as kategori',
                'barang.id',
                'barang.stok'
            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Goods/Index', [
            'barang' => $barang
        ]);
    }
}
