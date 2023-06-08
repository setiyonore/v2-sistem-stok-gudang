<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\barang_masuk;
use App\Models\barang_masuk_item;
use App\Models\HistoryStatusItem;
use App\Models\Item;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Traits\HistoryStatusItemTraits;
use Carbon\Carbon;

class GoodsReceivedController extends Controller
{
    use HistoryStatusItemTraits;

    public function index()
    {
        $barang_masuk = barang_masuk::query()
            ->when(request()->datestart && request()->dateend, function ($barang_masuk) {
                $barang_masuk->whereBetween('barang_masuk.tanggal', [request()->datestart, request()->dateend]);
            })
            ->leftJoin('pegawai as p', 'p.id', 'barang_masuk.pegawai_id')
            ->select(
                'barang_masuk.id',
                'barang_masuk.tanggal',
                'barang_masuk.yang_menyerahkan',
                'p.nama as pegawai',
                'p.nama as supplier',
                'barang_masuk.keterangan'
            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/GoodsReceived/Index', [
            'barang_masuk' => $barang_masuk
        ]);
    }

    public function create()
    {
        $barang = Barang::query()
            ->select('id', 'nama as text')
            ->get();
        return Inertia::render('Apps/GoodsReceived/Create', [
            'barang' => $barang,
        ]);
    }

    public function searchGood(Request $request)
    {

        $barang = Barang::query()
            ->where('id', $request->id_barang)
            ->select('nama')
            ->first();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'yang_menyerahkan' => 'required',
            'no_sp' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'yang_menyerahkan.required' => 'Mohon inputkan yang menyerahkan',
            'no_sp.required' => 'Mohon inputkan No SP',
            'barang.required' => 'Mohon inputkan barang',
        ]);

        $pegawai_id = Auth::user()->pegawai_id;
        $barang_masuk = barang_masuk::query()
            ->create([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'yang_menyerahkan' => $request->yang_menyerahkan,
                'pegawai_id' => $pegawai_id,
                'no_sp' => $request->no_sp
            ]);
        $items = $request->barang;
        for ($i = 0; $i < count($items); $i++) {
            //insert to tbl item
            $item = Item::query()
                ->create([
                    'barang_id' => $items[$i]['barang_id'],
                    'referensi_kondisi_barang' => config('config.refensi_kondisi_barang_normal'),
                    'no_serial' => $items[$i]['no_serial'],
                    'referensi_status_item' => config('config.referensi_status_barang_tersedia')
                ]);
            //insert to tbl barang_masuk_item
            $barang_masuk_item = barang_masuk_item::query()
                ->create([
                    'item_id' => $item->id,
                    'barang_masuk_id' => $barang_masuk->id
                ]);
            //insert to tbl history status item
            $this->storeHistory($item->id, $request->tanggal, config('config.referensi_status_barang_tersedia'), config('config.referensi_jenis_transaksi_barang_masuk'));
        }
        return redirect()->route('apps.received_goods.index');
    }

    public function edit($id)
    {
        $barang_masuk = barang_masuk::query()->findOrFail($id);
        $barang = barang_masuk_item::query()
            ->leftJoin('item as i', 'i.id', 'barang_masuk_item.item_id')
            ->leftJoin('barang as b', 'b.id', 'i.barang_id')
            ->where('barang_masuk_item.barang_masuk_id', $id)
            ->select(

                'i.id as item_id',
                'i.no_serial',
                'b.nama',
                'b.id as barang_id'
            )
            ->get();

        $goods = Barang::query()
            ->select('id', 'nama as text')
            ->get();
        $penyedia = Perusahaan::query()
            ->select('id', 'nama')
            ->where('referensi_jenis_perusahaan', config('config.referensi_penyedia'))
            ->get();
        return Inertia::render('Apps/GoodsReceived/Edit', [
            'barang_masuk' => $barang_masuk,
            'barang' => $barang,
            'penyedia' => $penyedia,
            'goods' => $goods
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'yang_menyerahkan' => 'required',
            'no_sp' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'yang_menyerahkan.required' => 'Mohon inputkan yang menyerahkan',
            'no_sp.required' => 'Mohon inputkan No SP',
            'barang.required' => 'Mohon inputkan barang',
        ]);
        //update data di tbl barang_masuk
        $barang_masuk = barang_masuk::query()->find($request->id);
        $barang_masuk->tanggal = $request->tanggal;
        $barang_masuk->yang_menyerahkan = $request->yang_menyerahkan;
        $barang_masuk->keterangan = $request->keterangan;
        $barang_masuk->no_sp = $request->no_sp;
        $barang_masuk->save();
        $items = $request->barang;
        // insert or update tbl item
        for ($i = 0; $i < count($items); $i++) {
            $item = Item::query()
                ->where('id', $items[$i]['item_id'])->get()->count();
            if ($item > 0) {
                //update
                $itemStore = Item::query()
                    ->where('id', $items[$i]['item_id'])
                    ->update([
                        'barang_id' => $items[$i]['barang_id'],
                        'no_serial' => $items[$i]['no_serial']
                    ]);
            } else {
                $today = Carbon::now();
                $today = $today->format('Y-m-d');
                //insert
                $itemStore = Item::query()
                    ->create([
                        'barang_id' => $items[$i]['barang_id'],
                        'referensi_kondisi_barang' => config('config.refensi_kondisi_barang_normal'),
                        'no_serial' => $items[$i]['no_serial'],
                        'referensi_status_item' => config('config.referensi_status_barang_tersedia')

                    ]);
                //insert barang_masuk_item
                $barang_masuk_item = barang_masuk_item::query()
                    ->create([
                        'barang_masuk_id' => $request->id,
                        'item_id' => $itemStore->id
                    ]);
                //insert history status item
                $this->storeHistory($itemStore->id, $today, config('config.referensi_status_barang_tersedia'), config('config.referensi_jenis_transaksi_barang_masuk'));
            }
        }
        return redirect()->route('apps.received_goods.index');
    }

    public function destroy($id)
    {
        $barang_masuk_item = barang_masuk_item::query()
            ->where('barang_masuk_id', $id)
            ->select('item_id')
            ->get();
        $item_tmp = [];
        for ($i = 0; $i < count($barang_masuk_item); $i++) {
            //delete history status item
            HistoryStatusItem::query()->where('item_id', $barang_masuk_item[$i]['item_id'])
                ->delete();
            array_push($item_tmp, $barang_masuk_item[$i]['item_id']);
        }
        //delete barang masuk item
        barang_masuk_item::query()->where('barang_masuk_id', $id)->delete();
        //delete item
        for ($i = 0; $i < count($item_tmp); $i++) {
            Item::query()->findOrFail($item_tmp[$i])->delete();
        }
        barang_masuk::query()->findOrFail($id)->delete();
        return redirect()->route('apps.received_goods.index');
    }

    public function show($id)
    {
        $barang_masuk = barang_masuk::query()
            ->where('barang_masuk.id', $id)
            ->leftJoin('pegawai as p', 'p.id', 'barang_masuk.pegawai_id')
            ->select(
                'barang_masuk.tanggal',
                'barang_masuk.yang_menyerahkan',
                'p.nama as pegawai',
                'barang_masuk.keterangan',
                'barang_masuk.no_sp'
            )
            ->first();
        $barang = barang_masuk_item::query()
            ->where('barang_masuk_item.barang_masuk_id', $id)
            ->leftJoin('item as i', 'i.id', 'barang_masuk_item.item_id')
            ->leftJoin('barang as b', 'b.id', 'i.barang_id')
            ->select('nama as barang', 'i.no_serial')
            ->get();
        return Inertia::render('Apps/GoodsReceived/Detil', [
            'barang_masuk' => $barang_masuk,
            'barang' => $barang
        ]);
    }

    public function deleteItem($id)
    {
        $findItem = Item::query()->where('id', $id)->count();
        if ($findItem == 1) {
            //delete in barang masuk item
            barang_masuk_item::query()->where('item_id', $id)->delete();
            // delete in history status item
            HistoryStatusItem::query()->where('item_id', $id)->delete();
            //delete in item
            Item::query()->findOrFail($id)->delete();
            return response()->json('success');
        }
        return response()->json('failed');
    }
}
