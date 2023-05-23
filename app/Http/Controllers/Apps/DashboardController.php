<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Item;
use App\Models\OrderBarang;
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
        $barang_masuk_date[] = "";
        $total_barang_masuk[] = "";
        $barang_keluar_date[] = "";
        $total_barang_keluar[] = "";
        $barang_masuk = DB::table('barang_masuk_item')
            ->leftJoin('barang_masuk as bm', 'bm.id', 'barang_masuk_item.barang_masuk_id')
            ->addSelect(DB::raw('DATE(bm.created_at) as date,COUNT(barang_masuk_item.id) as jumlah'))
            // ->where('bm.created_at', '>=', $week)
            ->groupBy('date')
            ->get();
        if (count($barang_masuk)) {
            foreach ($barang_masuk as $value) {
                $barang_masuk_date[] = $value->date;
                $total_barang_masuk[] = (int)$value->jumlah;
            }
        }
        // dd($total);
        $barang_keluar = DB::table('barang_keluar_item')
            ->leftJoin('order_barang as bk', 'bk.id', 'barang_keluar_item.order_barang_id')
//            ->leftJoin('surat_permintaan as sp', 'sp.id', 'bk.sp_id')
            ->addSelect(DB::raw('DATE(bk.created_at) as date,COUNT(barang_keluar_item.id) as jumlah'))
            // ->where('bk.created_at', '>=', $week)
            ->where('bk.referensi_status_order', config('config.status_permintaan_approve'))
            ->groupBy('date')
            ->get();
        if (count($barang_keluar)) {
            foreach ($barang_keluar as $value) {
                $barang_keluar_date[] = $value->date;
                $total_barang_keluar[] = (int)$value->jumlah;
            }
        }
        $order_pending = OrderBarang::query()
            ->where('referensi_status_order', config('config.status_permintaan_pending'))
            ->orderBy('tanggal', 'ASC')
            ->get();
        $stok_barang = DB::table('item')
            ->leftJoin('barang as b', 'item.barang_id', '=', 'b.id')
            ->select(DB::raw('COUNT(item.id) as stok'), 'b.nama')
            ->where('referensi_status_item', config('config.referensi_status_barang_tersedia'))
            ->groupBy('item.barang_id')
            ->having(DB::raw('COUNT(item.id)'),'<',10)
            ->get();
        return Inertia::render('Apps/Dashboard/Index', [
            'stok' => $stok_barang,
            'order' => $order_pending,
            'date_barang_masuk' => $barang_masuk_date,
            'total_barang_masuk' => $total_barang_masuk,
            'date_barang_keluar' => $barang_keluar_date,
            'total_barang_keluar' => $total_barang_keluar,
        ]);
    }
}
