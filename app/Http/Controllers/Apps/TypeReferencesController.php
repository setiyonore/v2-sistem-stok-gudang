<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisReferensi;
use Inertia\Inertia;

class TypeReferencesController extends Controller
{
    public function index()
    {
        $jenis_referensi = JenisReferensi::query()
            ->select('id', 'nama', 'deskripsi')
            ->paginate(config('config.paginate'));
            // dd($jenis_referensi);
        return Inertia::render('Apps/TypeReferences/Index',[
            'jenis_referensi' => $jenis_referensi,
        ]);
    }
}
