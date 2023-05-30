<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluarItem;
use App\Models\OrderBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\HistoryStatusItem;
use App\Models\Item;
use Carbon\Carbon;

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
            ->orderBy('referensi_status_order')
            ->orderBy('tanggal','DESC')
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
                'order_barang.id as sp_id',
                'order_barang.is_input_item'
            )
            ->first();
        $items = BarangKeluarItem::query()
            ->where('order_barang_id', $id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_item.barang_id')
            ->select('b.nama as barang', DB::raw('COUNT(item_id) as jumlah'))
            ->groupBy('barang_id')
            ->get();
        $config_status_order_approve = config('config.status_permintaan_approve');
        return Inertia::render('Apps/OutgoingGoods/Detil', [
            'barang_keluar' => $barang_keluar,
            'items' => $items,
            'config_status_order_approve' => $config_status_order_approve
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

    public function inputItem($id)
    {
        $order = OrderBarang::query()
            ->where('id', $id)
            ->select('no_sp')
            ->first();
        $item = BarangKeluarItem::query()
            ->where('order_barang_id', $id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_item.barang_id')
            ->leftJoin('order_barang as ob', 'ob.id', 'barang_keluar_item.order_barang_id')
            ->select(
                'b.id as barang_id',
                'barang_keluar_item.id',
                'b.nama',
                DB::raw("'' AS serial")

            )
            ->get();
        return Inertia::render('Apps/OutgoingGoods/InputItem', [
            'order' => $order,
            'items' => $item
        ]);
    }

    public function searchSerial(Request $request)
    {
        $serial = Item::query()
            ->where('no_serial', $request->serial)
            ->where('barang_id', $request->barang_id)
            ->count();
        $condition = Item::query()
            ->where('barang_id', $request->barang_id)
            ->where('no_serial', $request->serial)
            ->where('referensi_kondisi_barang', config('config.refensi_kondisi_barang_normal'))
            ->count();
        $match = 0;
        $normal = 0; //kondisi barang normal
        if ($serial > 0) {
            $match = 1;
        }
        if ($condition > 0) {
            $normal = 1;
        }
        return response()->json([
            'match' => $match,
            'normal' => $normal
        ]);
    }

    public function availableItem($serial)
    {
        $item = Item::query()
            ->where('no_serial', $serial)
            ->select('id')
            ->first();
        $status_avail = HistoryStatusItem::query()
            ->where('item_id', $item->id)
            ->select('referensi_status_item as status')
            ->latest()
            ->first();
        $avail = 0;
        if ($status_avail->status == config('config.referensi_status_barang_tersedia')) {
            $avail = 1;
        }
        return response()->json([
            'avail' => $avail
        ]);
    }

    public function insertItem(Request $request)
    {
        // dd($request);
        $today = Carbon::now();
        $today = $today->format('Y-m-d');
        //update barang keluar item
        for ($i = 0; $i < count($request->barang); $i++) {
            $this->validate($request,['barang.serial'=>'required']);
            $item = Item::query()
                ->where('no_serial', $request->barang[$i]['serial'])
                ->select('id')
                ->first();
            BarangKeluarItem::query()
                ->where('id', $request->barang[$i]['id'])
                ->update([
                    'item_id' => $item->id,
                ]);
            //insert history status item
            HistoryStatusItem::query()
                ->create([
                    'item_id' => $item->id,
                    'tanggal' => $today,
                    'referensi_status_item' => config('config.referensi_status_barang_terpakai'),
                    'referensi_jenis_transaksi' => config('config.referensi_jenis_transaksi_barang_keluar')
                ]);
            //update status item
            Item::query()
                ->where('no_serial', $request->barang[$i]['serial'])
                ->update([
                    'referensi_status_item' => config('config.referensi_status_barang_terpakai')
                ]);
        }
        OrderBarang::query()
            ->where('no_sp', $request->no_sp)
            ->update([
                'is_input_item' => 1
            ]);
        return redirect()->route('apps.outgoing_goods.index');
    }
}
