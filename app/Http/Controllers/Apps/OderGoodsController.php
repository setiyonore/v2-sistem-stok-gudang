<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarItem;
use App\Models\OrderBarang;
use App\Models\Perusahaan;
use App\Models\SuratPermintaan;
use App\Traits\GoodsTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PDF;

class OderGoodsController extends Controller
{
    use GoodsTraits;
    public function index()
    {
        $order = OrderBarang::query()
            ->when(request()->q, function ($order) {
                $order->where('tanggal', request()->q);
            })
            ->leftJoin('referensi as r', 'r.id', 'order_barang.referensi_status_order')
            ->select(
                'tanggal',
                'no_sp',
                'order_barang.keterangan',
                'r.nama as status',
                'order_barang.id',
                'order_barang.pegawai_id'
            )
            ->paginate(config('config.paginate'));
        $pegawai = Auth::user()->pegawai_id;
        return Inertia::render('Apps/Order/Index', [
            'order' => $order,
            'pegawai' => $pegawai,
        ]);
    }
    public function create()
    {
        $pelanggan = Perusahaan::query()
            ->where('referensi_jenis_perusahaan', config('config.referensi_pelanggan'))
            ->select('id', 'nama as text')
            ->get();
        $barang = Barang::query()
            ->select('id', 'nama as text')
            ->get();
        return Inertia::render('Apps/Order/Create', [
            'pelanggan' => $pelanggan,
            'barang' => $barang
        ]);
    }
    public function searchGood(Request $request)
    {
        $barang = Barang::query()
            ->where('id', $request->id_barang)
            ->select('nama', 'id', 'stok')
            ->first();

        $available = 0;
        $stok = (int)$barang->stok;
        if ($stok > $request->jumlah) {
            $available = 1;
        }

        return response()->json([
            'available' => $available,
            'barang' => $barang
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'tanggal' => 'required',
            'pelanggan' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'pelanggan.required' => 'Mohon inputkan pelanggan',
            'barang.required' => 'Mohon inputkan barang',
        ]);
        /*
        10012023/DTP/01
        tanggal,bulan,tahun/dtp/surat permintaan ke x ditgl tersebut
        */
        $pegawai_id = Auth::user()->pegawai_id;
        $count = OrderBarang::query()->where('tanggal', $request->tanggal)->count() + 1;
        $count = sprintf("%03d", $count);
        $tgl = Carbon::createFromFormat('Y-m-d', $request->tanggal)->format('d/m/Y');
        $tgl = str_replace('/', '', $tgl);
        $nosp = $tgl . '/DTP/' . $count;
        //insert tbl order
        $order = OrderBarang::query()
            ->create([
                'tanggal' => $request->tanggal,
                'no_sp' => $nosp,
                'referensi_status_order' => config('config.status_permintaan_pending'),
                'keterangan' => $request->keterangan,
                'pelanggan_id' => $request->pelanggan,
                'pegawai_id' => $pegawai_id
            ]);
        //insert tbl barang keluar item
        $items = $request->barang;
        for ($i = 0;$i<count($items);$i++){
            for ($j=0;$j<$items[$i]['jumlah'];$j++){
                BarangKeluarItem::query()
                    ->create([
                        'order_barang_id' => $order->id,
                        'barang_id' => $items[$i]['barang_id'],
                        'item_id' => 0
                    ]);
            }
        }
        return redirect()->route('apps.order.index');
    }

    public function show($id)
    {
        $order = SuratPermintaan::query()
            ->leftJoin('pegawai as e', 'e.id', 'surat_permintaan.pegawai_id')
            ->leftJoin('perusahaan as p', 'p.id', 'surat_permintaan.pelanggan_id')
            ->leftJoin('referensi as r', 'r.id', 'surat_permintaan.referensi_status_sp')
            ->where('surat_permintaan.id', $id)
            ->select(
                'tanggal',
                'no_sp',
                'p.nama as pelanggan',
                'keterangan',
                'e.nama as pegawai',
                'r.nama as status',
                'surat_permintaan.id',
                'surat_permintaan.referensi_status_sp as status'
            )
            ->first();
        $barang_keluar = BarangKeluar::query()
            ->where('sp_id', $id)
            ->select('id')
            ->first();
        $barang = BarangKeluarItem::query()
            ->where('barang_keluar_id', $barang_keluar->id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_detil.barang_id')
            ->select('b.nama', 'barang_keluar_detil.jumlah')
            ->get();
        return Inertia::render('Apps/Order/Detil', [
            'order' => $order,
            'barang' => $barang
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
        $items = BarangKeluarItem::query()
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
        return redirect()->route('apps.order.index');
    }
    public function notApprove(Request $request)
    {
        $order = SuratPermintaan::query()->find($request->id);
        $order->referensi_status_sp = config('config.status_permintaan_notApprove');
        $order->save();
        return redirect()->route('apps.order.index');
    }
    public function edit($id)
    {

        $order = OrderBarang::query()->findOrFail($id);
        $pelanggan = Perusahaan::query()
            ->where('referensi_jenis_perusahaan', config('config.referensi_pelanggan'))
            ->select('id', 'nama as text')
            ->get();
        $goods = Barang::query()
            ->select('id', 'nama as text')
            ->get();
        $barang = BarangKeluarItem::query()
            ->select('barang_id',DB::raw('COUNT(item_id) as jumlah'))
            ->groupBy('barang_id')
            ->get();
        return Inertia::render('Apps/Order/Edit', [
            'order' => $order,
            'pelanggan' => $pelanggan,
            'barang' => $barang,
            'goods' => $goods,
        ]);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'pelanggan' => 'required',
            'barang' => 'required',
        ], [
            'tanggal.required' => 'Mohon inputkan tanggal',
            'pelanggan.required' => 'Mohon inputkan pelanggan',
            'barang.required' => 'Mohon inputkan barang',
        ]);
        $order = OrderBarang::query()
            ->where('id',$request->id)
            ->update([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'pelanggan_id' => $request->pelanggan
            ]);
        BarangKeluarItem::query()
            ->where('order_barang_id',$request->id)->delete();
        //insert tbl barang keluar item
        $items = $request->barang;
        for ($i = 0;$i<count($items);$i++){
            for ($j=0;$j<$items[$i]['jumlah'];$j++){
                BarangKeluarItem::query()
                    ->create([
                        'order_barang_id' => $request->id,
                        'barang_id' => $items[$i]['barang_id'],
                        'item_id' => 0
                    ]);
            }
        }

        return redirect()->route('apps.order.index');
    }
    public function destroy($id)
    {
        $sp_status = SuratPermintaan::query()
            ->where('id', $id)
            ->select('referensi_status_sp as status')
            ->first();
        $barang_keluar = BarangKeluar::query()
            ->where('sp_id', $id)->select('id')->first();
        if ($sp_status->status == config('config.status_permintaan_approve')) {
            //cek apakah permintaan sudah di approve

            $barang_keluar_detil = BarangKeluarItem::query()
                ->where('barang_keluar_id', $barang_keluar->id)
                ->get();
            for ($i = 0; $i < count($barang_keluar_detil); $i++) {
                $barang = Barang::query()->find($barang_keluar_detil[$i]['barang_id']);
                $barang->stok = $barang->stok + $barang_keluar_detil[$i]['jumlah'];
                $barang->save();
            }
        }
        $barang_keluar_detil = BarangKeluarItem::query()
            ->where('barang_keluar_id', $barang_keluar->id)->delete();
        $barang_keluar = BarangKeluar::query()
            ->where('sp_id', $id)->delete();
        $order = SuratPermintaan::query()
            ->where('id', $id)->delete();
        return redirect()->route('apps.order.index');
    }

    public function print(Request $request)
    {
        $order = SuratPermintaan::query()
            ->where('surat_permintaan.id', $request->id)
            ->leftJoin('perusahaan as p', 'p.id', 'surat_permintaan.pelanggan_id')
            ->leftJoin('pegawai as e','e.id','surat_permintaan.pegawai_id')
            ->leftJoin('referensi as r','r.id','e.referensi_jabatan')
            ->select(
                'no_sp',
                'tanggal',
                'p.nama',
                'p.alamat',
                'p.no_hp',
                'p.email',
                'e.nama as pegawai',
                'e.nip',
                'r.nama as jabatan'

            )
            ->first();
        $barang_keluar = BarangKeluar::query()
            ->where('sp_id', $request->id)
            ->select('id')
            ->first();
        $barang_keluar_detil = BarangKeluarItem::query()
            ->where('barang_keluar_id', $barang_keluar->id)
            ->leftJoin('barang as b', 'b.id', 'barang_keluar_detil.barang_id')
            ->select('b.nama as barang', 'barang_keluar_detil.jumlah')
            ->get();
        $data = [
            'order' => $order,
            'barang' => $barang_keluar_detil
        ];
        $pdf = PDF::loadView('print_order', $data);
        return $pdf->download('order.pdf');
    }
}
