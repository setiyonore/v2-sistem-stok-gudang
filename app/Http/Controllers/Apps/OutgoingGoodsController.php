<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarItem;
use App\Models\OrderBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\SuratPermintaan;
use App\Models\Barang;

class OutgoingGoodsController extends Controller
{
    public function index()
    {
        $barang_keluar = OrderBarang::query()
            ->when(request()->q, function ($barang_keluar) {
                $barang_keluar->where('order_barang.tanggal', request()->q);
            })
            ->leftJoin('perusahaan as p', 'p.id', 'order_barang.pelanggan_id')
            ->leftJoin('referensi as r', 'r.id', 'order_barang.referensi_status_order')
            ->select(
                'order_barang.tanggal',
                'order_barang.no_sp',
                'p.nama as pelanggan',
                'r.nama as status',
                'order_barang.id'

            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/OutgoingGoods/Index', [
            'barang_keluar' => $barang_keluar
        ]);
    }
    public function show($id)
    {
        $barang_keluar = OrderBarang::query()
            ->leftJoin('pegawai as p', 'p.id', 'order_barang.pegawai_id')
            ->leftJoin('referensi as r', 'r.id', 'order_barang.referensi_status_order')
            ->leftJoin('perusahaan as pr', 'pr.id', 'order_barang.pelanggan_id')
            ->where('order_barang.id', $id)
            ->select(
                'order_barang.no_sp',
                'order_barang.tanggal',
                'r.nama as status',
                'pr.nama as pelanggan',
                'p.nama as pegawai',
                'order_barang.keterangan',
                'order_barang.referensi_status_order as status_sp',
                'order_barang.id as sp_id'
            )
            ->first();
        $items = BarangKeluarItem::query()
            ->where('order_barang_id', $id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_item.barang_id')
            ->select('b.nama as barang',DB::raw('COUNT(item_id) as jumlah'))
            ->groupBy('barang_id')
            ->get();

        return Inertia::render('Apps/OutgoingGoods/Detil', [
            'barang_keluar' => $barang_keluar,
            'items' => $items
        ]);
    }
    public function approve(Request $request)
    {
        $order = OrderBarang::query()->find($request->id);
        $order->referensi_status_order = config('config.status_permintaan_approve');
        $order->save();
        return redirect()->route('apps.outgoing_goods.index');
    }
    public function notApprove(Request $request)
    {
        $order = OrderBarang::query()->find($request->id);
        $order->referensi_status_order = config('config.status_permintaan_notApprove');
        $order->save();
        return redirect()->route('apps.outgoing_goods.index');
    }
}
