<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\barang_masuk;
use App\Models\barang_masuk_detil;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $penyedia = Perusahaan::query()
            ->select('id', 'nama')
            ->where('referensi_jenis_perusahaan', config('config.referensi_penyedia'))
            ->get();
        return Inertia::render('Apps/GoodsReceived/Create', [
            'barang' => $barang,
            'penyedia' => $penyedia,
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
            'penyedia' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'yang_menyerahkan.required' => 'Mohon inputkan yang menyerahkan',
            'penyedia.required' => 'Mohon inputkan penyedia',
            'barang.required' => 'Mohon inputkan barang',
        ]);
        $pegawai_id = Auth::user()->pegawai_id;
        $barang_masuk = barang_masuk::query()
            ->create([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'yang_menyerahkan' => $request->yang_menyerahkan,
                'pegawai_id' => $pegawai_id,
                'penyedia_id' => $request->penyedia
            ]);
        $items = $request->barang;
        for ($i = 0; $i < count($items); $i++) {
            $barang_masuk_detil = barang_masuk_detil::query()
                ->create([
                    'barang_id' => $items[$i]['barang_id'],
                    'jumlah' => $items[$i]['jumlah'],
                    'barang_masuk_id' => $barang_masuk->id
                ]);
            $oldStock = Barang::query()
                ->where('id', $items[$i]['barang_id'])
                ->select('stok')
                ->first();
            $oldStock = $oldStock->stok;
            $newstock = $oldStock + $items[$i]['jumlah'];
            $barang = Barang::query()->find($items[$i]['barang_id']);
            $barang->stok = $newstock;
            $barang->save();
        }
        return redirect()->route('apps.received_goods.index');
    }
    public function edit($id)
    {
        $barang_masuk = barang_masuk::query()->findOrFail($id);
        $barang = barang_masuk_detil::query()
            ->leftJoin('barang as b', 'b.id', 'barang_masuk_detil.barang_id')
            ->where('barang_masuk_detil.barang_masuk_id', $id)
            ->select(
                'b.id as barang_id',
                'barang_masuk_detil.jumlah',
                'b.nama',
                'barang_masuk_detil.jumlah as jumlah_old'
            )
            ->get();
        $goods =  Barang::query()
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
            'penyedia' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'yang_menyerahkan.required' => 'Mohon inputkan yang menyerahkan',
            'penyedia.required' => 'Mohon inputkan penyedia',
            'barang.required' => 'Mohon inputkan barang',
        ]);
        $barang_masuk = barang_masuk::query()->find($request->id);
        $barang_masuk->tanggal = $request->tanggal;
        $barang_masuk->yang_menyerahkan = $request->yang_menyerahkan;
        $barang_masuk->keterangan = $request->keterangan;
        $barang_masuk->penyedia_id = $request->penyedia;
        $barang_masuk->save();
        $items = $request->barang;
        barang_masuk_detil::query()->where('barang_masuk_id', $request->id)->delete();
        for ($i = 0; $i < count($items); $i++) {
            $barang_masuk_detil = barang_masuk_detil::query()
                ->create([
                    'barang_id' => $items[$i]['barang_id'],
                    'jumlah' => $items[$i]['jumlah'],
                    'barang_masuk_id' => $request->id
                ]);
            $oldStock = $items[$i]['jumlah_old'];
            $newstock = $items[$i]['jumlah'];
            //jika stok lama lebih kecil dari stok baru
            if ($oldStock < $newstock) {
                $barang = Barang::query()->find($items[$i]['barang_id']);
                $barang->stok = $barang->stok - $oldStock + $newstock;
                $barang->save();
            } else if ($oldStock > $newstock) {
                //jika stok lama lebih besar dari stok baru
                $barang = Barang::query()->find($items[$i]['barang_id']);
                $barang->stok = $barang->stok - $newstock;
                $barang->save();
            }
        }
        return redirect()->route('apps.received_goods.index');
    }
}
