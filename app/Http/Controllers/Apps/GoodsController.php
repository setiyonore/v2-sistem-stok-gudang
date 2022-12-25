<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Referensi;
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

    public function create()
    {
        $kategori = Referensi::query()
            ->where('jenis_referensi_id', config('config.referensi_kategori'))
            ->select('id', 'nama')
            ->get();
        $satuan = Referensi::query()
            ->where('jenis_referensi_id', config('config.referensi_satuan'))
            ->select('id', 'nama')
            ->get();
        return Inertia::render('Apps/Goods/Create', [
            'kategori' => $kategori,
            'satuan' => $satuan,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'satuan' => 'required',
                'kategori' => 'required',

            ],
            [
                'nama.required' => 'Mohon Inputkan Nama',
                'satuan.required' => 'Mohon Pilih Satuan',
                'kategori.required' => 'Mohon Pilih Kategori',
            ]
        );
        $barang = Barang::query()
        ->create([
            'nama' => $request->nama,
            'referensi_satuan' => $request->satuan,
            'referensi_kategori' => $request->kategori,
            'stok' => $request->stok
        ]);
        return redirect()->route('apps.goods.index');
    }
}
