<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\SuratPermintaan;
use Illuminate\Http\Request;
use Carbon;
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
                'r.nama as status'
            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Order/Index', [
            'order' => $order,
        ]);
    }
}
