<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\SuratPermintaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use WeakMap;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request)
    {
        $day    = date('d');
        $week = Carbon::now()->subDays(7);
        $barang_masuk = DB::table('barang_masuk_detil')
        ->leftJoin('barang_masuk as bm','bm.id','barang_masuk_detil.barang_masuk_id')
        ->addSelect(DB::raw('DATE(bm.created_at) as date,SUM(jumlah) as jumlah'))
        ->where('bm.created_at', '>=', $week)
        ->groupBy('date')
        ->get();
        $barang_keluar = DB::table('barang_keluar_detil')
        ->leftJoin('barang_keluar as bk','bk.id','barang_keluar_detil.barang_keluar_id')
        ->leftJoin('surat_permintaan as sp','sp.id','bk.sp_id')
        ->addSelect(DB::raw('DATE(bk.created_at) as date,SUM(jumlah) as jumlah'))
        ->where('bk.created_at', '>=', $week)
        ->where('sp.referensi_status_sp',config('config.status_permintaan_approve'))
        ->groupBy('date')
        ->get();
        $order_pending = SuratPermintaan::query()
        ->where('referensi_status_sp',config('config.status_permintaan_pending'))
        ->orderBy('tanggal','ASC')
        ->get();
        $stok_barang = Barang::query()
        ->where('stok','<',10)
        ->select('nama','stok')
        ->get();
        return Inertia::render('Apps/Dashboard/Index',[
            'stok' => $stok_barang,
            'order' => $order_pending,
        ]);
    }
}
