<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\barang_masuk;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GoodsReceivedController extends Controller
{
    public function index()
    {
        $barang_masuk = barang_masuk::query()
            ->when(request()->q, function ($barang_masuk) {
                $barang_masuk->where('barang_masuk.tanggal', request()->q);
            })
            ->leftJoin('pegawai as p', 'p.id', 'barang_masuk.pegawai_id')
            ->leftJoin('perusahaan as s', 's.id', 'barang_masuk.penyedia_id')
            ->select(
                'barang_masuk.id',
                'barang_masuk.tanggal',
                'barang_masuk.yang_menyerahkan',
                'p.nama as pegawai',
                'p.nama as supplier',
                'barang_masuk.keterangan'
            )
            ->get();
        return Inertia::render('Apps/GoodsReceived/Index', [
            'barang_masuk' => $barang_masuk
        ]);
    }
}
