<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetil;
use App\Models\Perusahaan;
use App\Models\SuratPermintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Inertia\Inertia;

class LetterRequestController extends Controller
{
    public function index()
    {
        $order = SuratPermintaan::query()
            ->when(request()->q, function ($order) {
                $order->where('tanggal', request()->q);
            })
            ->leftJoin('referensi as r', 'r.id', 'surat_permintaan.referensi_status_sp')
            ->select(
                'tanggal',
                'no_sp',
                'surat_permintaan.keterangan',
                'r.nama as status',
                'surat_permintaan.id'
            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Order/Index', [
            'order' => $order,
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
        $count = SuratPermintaan::query()->where('tanggal', $request->tanggal)->count() + 1;
        $count = sprintf("%03d", $count);
        $tgl = Carbon::createFromFormat('Y-m-d', $request->tanggal)->format('d/m/Y');
        $tgl = str_replace('/', '', $tgl);
        $nosp = $tgl . '/DTP/' . $count;
        $order = SuratPermintaan::query()
            ->create([
                'tanggal' => $request->tanggal,
                'no_sp' => $nosp,
                'referensi_status_sp' => config('config.status_permintaan_pending'),
                'keterangan' => $request->keterangan,
                'pelanggan_id' => $request->pelanggan,
                'pegawai_id' => $pegawai_id
            ]);
        $barang_keluar = BarangKeluar::query()
            ->create([
                'tanggal' => $request->tanggal,
                'sp_id' => $order->id,
            ]);
        $items = $request->barang;
        for ($i = 0; $i < count($items); $i++) {
            $barang_keluar_detil = BarangKeluarDetil::query()
                ->create([
                    'barang_keluar_id' => $barang_keluar->id,
                    'barang_id' => $items[$i]['barang_id'],
                    'jumlah' => $items[$i]['jumlah']
                ]);
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
                'surat_permintaan.id'
            )
            ->first();
        $barang_keluar = BarangKeluar::query()
            ->where('sp_id', $id)
            ->select('id')
            ->first();
        $barang = BarangKeluarDetil::query()
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
        return redirect()->route('apps.order.index');
    }
}
