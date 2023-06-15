<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\HistoryStatusItem;
use App\Models\Item;
use App\Models\Referensi;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Traits\HistoryStatusItemTraits;

class GoodsController extends Controller
{
    use HistoryStatusItemTraits;

    public function index()
    {
        $barang = Barang::query()
            ->when(request()->q, function ($barang) {
                $barang = $barang->where('barang.nama', 'like', '%' . request()->q . '%');
            })
            ->leftJoin('referensi as satuan', 'satuan.id', 'barang.referensi_satuan')
            ->leftJoin('referensi as kategori', 'kategori.id', 'barang.referensi_kategori')
            ->leftJoin('item as i', function ($join) {
                $join->on('barang.id', '=', 'i.barang_id')
                    ->where('i.referensi_status_item', '=', config('config.referensi_status_barang_tersedia'));
            })
            ->select(
                'barang.nama',
                'satuan.nama as satuan',
                'kategori.nama as kategori',
                'barang.id',
                DB::raw('COALESCE(COUNT(i.id), 0) AS stok')
            )
            ->groupBy('barang.id')
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

    public function edit($id)
    {
        $barang = Barang::query()->findOrFail($id);

        $kategori = Referensi::query()
            ->where('jenis_referensi_id', config('config.referensi_kategori'))
            ->select('id', 'nama')
            ->get();
        $satuan = Referensi::query()
            ->where('jenis_referensi_id', config('config.referensi_satuan'))
            ->select('id', 'nama')
            ->get();
        return Inertia::render('Apps/Goods/Edit', [
            'barang' => $barang,
            'kategori' => $kategori,
            'satuan' => $satuan,
        ]);
    }

    public function update(Request $request)
    {
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
        $barang = Barang::query()->find($request->id);
        $barang->nama = $request->nama;
        $barang->referensi_satuan = $request->satuan;
        $barang->referensi_kategori = $request->kategori;
        $barang->stok = $request->stok;
        $barang->save();
        return redirect()->route('apps.goods.index');
    }

    public function destroy($id)
    {
        $barang = Barang::query()->findOrFail($id);
        $barang->delete();
        return redirect()->route('apps.goods.index');
    }

    public function show($id)
    {
        $barang = Barang::query()
            ->where('id', $id)
            ->select('nama', 'id')
            ->first();
        $item = Item::query()
            ->when(request()->q, function ($item) {
                $item = $item->where('no_serial', request()->q);
            })
            ->leftJoin('referensi as kt', 'kt.id', 'item.referensi_status_item')
            ->leftJoin('referensi as kd', 'kd.id', 'item.referensi_kondisi_barang')
            ->where('barang_id', $id)
            ->select('item.id', 'no_serial', 'kt.nama as status', 'kd.nama as kondisi')
            ->orderBy('kt.id')
            ->paginate(config('config.paginate'));
        $status = Referensi::query()
            ->select('id', 'nama as text')
            ->where('jenis_referensi_id', config('config.referensi_status_barang'))
            ->get();
        $kondisi = Referensi::query()
            ->select('id', 'nama as text')
            ->where('jenis_referensi_id', config('config.referensi_kondisi_barang'))
            ->get();
        $jenis_transaksi = Referensi::query()
            ->select('id', 'nama as text')
            ->where('jenis_referensi_id', config('config.referensi_jenis_transaksi'))
            ->get();
        return Inertia::render('Apps/Goods/DetilItem', [
            'barang' => $barang,
            'item' => $item,
            'status' => $status,
            'kondisi' => $kondisi,
            'jenis_transaksi' => $jenis_transaksi
        ]);
    }

    public function getItem($id)
    {
        $history = HistoryStatusItem::query()
            ->where('item_id', $id)
            ->leftJoin('referensi as st', 'st.id', 'history_status_item.referensi_status_item')
            ->leftJoin('referensi as jt', 'jt.id', 'history_status_item.referensi_jenis_transaksi')
            ->select(
                'tanggal',
                'st.nama as status',
                'jt.nama as jenis_transaksi',
                'history_status_item.id'
            )
            ->get();
        return response()->json(
            ['history' => $history]
        );
    }

    public function storeEdit(Request $request)
    {
        $this->validate($request, [
            'item.itemId' => 'required',
            'item.status' => 'required',
            'item.kondisi' => 'required',
            'item.jenis_transaksi' => 'required',
        ], [
            'item.status.required' => 'Mohon Pilih status',
            'item.kondisi.required' => 'Mohon Pilih kondisi',
            'item.jenis_transaksi.required' => 'Mohon Pilih Jenis Transaksi'
        ]);

        $tanggal = Carbon::now();
        $tanggal = $tanggal->format('Y-m-d');
        $history = $this->storeHistory($request->item['itemId'], $tanggal, $request->item['status'], $request->item['jenis_transaksi']);
        $item = Item::query()
            ->where('id', $request->item['itemId'])
            ->update([
                'referensi_kondisi_barang' => $request->item['kondisi'],
                'referensi_status_item' => $request->item['status']
            ]);
        if ($history) {
            return response()->json(
                ['update' => 1]
            );
        }
        return response()->json([
            'update' => 0
        ]);
    }
}
