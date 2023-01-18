<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetil;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SuratPermintaan;
use App\Models\Barang;

class OutgoingGoodsController extends Controller
{
    public function index()
    {
        $barang_keluar = BarangKeluar::query()
            ->leftJoin('surat_permintaan as sp', 'sp.id', 'barang_keluar.sp_id')
            ->leftJoin('perusahaan as p', 'p.id', 'sp.pelanggan_id')
            ->leftJoin('referensi as r', 'r.id', 'sp.referensi_status_sp')
            ->select(
                'sp.tanggal',
                'sp.no_sp',
                'p.nama as pelanggan',
                'r.nama as status',
                'barang_keluar.id'

            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/OutgoingGoods/Index', [
            'barang_keluar' => $barang_keluar
        ]);
    }
    public function show($id)
    {
        $barang_keluar = BarangKeluar::query()
            ->leftJoin('surat_permintaan as sp', 'sp.id', 'barang_keluar.sp_id')
            ->leftJoin('pegawai as p', 'p.id', 'sp.pegawai_id')
            ->leftJoin('referensi as r', 'r.id', 'sp.referensi_status_sp')
            ->leftJoin('perusahaan as pr', 'pr.id', 'sp.pelanggan_id')
            ->where('barang_keluar.id', $id)
            ->select(
                'sp.no_sp',
                'sp.tanggal',
                'r.nama as status',
                'pr.nama as pelanggan',
                'p.nama as pegawai',
                'sp.keterangan',
                'sp.referensi_status_sp as status_sp',
                'sp.id as sp_id'
            )
            ->first();
        $items = BarangKeluarDetil::query()
            ->where('barang_keluar_id', $id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_detil.barang_id')
            ->select('b.nama as barang', 'barang_keluar_detil.jumlah')
            ->get();

        return Inertia::render('Apps/OutgoingGoods/Detil', [
            'barang_keluar' => $barang_keluar,
            'items' => $items
        ]);
    }
    public function approve(Request $request)
    {
        $order = SuratPermintaan::query()->find($request->id);
        $order->referensi_status_sp = config('config.status_permintaan_approve');
        $order->save();
        $barang_keluar = BarangKeluar::query()->where('sp_id', $request->id)
            ->select('id')
            ->first();
        $items = BarangKeluarDetil::query()
            ->where('barang_keluar_id', $barang_keluar->id)
            ->select('barang_id', 'jumlah')
            ->get();
        for ($i = 0; $i < count($items); $i++) {
            $oldStock = Barang::query()
                ->where('id', $items[$i]['barang_id'])
                ->select('stok')
                ->first();
            $oldStock = $oldStock->stok;
            $newstock = $oldStock - $items[$i]['jumlah'];
            $barang = Barang::query()->find($items[$i]['barang_id']);
            $barang->stok = $newstock;
            $barang->save();
        }
        return redirect()->route('apps.outgoing_goods.index');
    }
}
