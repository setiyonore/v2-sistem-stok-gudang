<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\JenisReferensi;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Referensi;

class ReferencesController extends Controller
{
    public function index()
    {   $jenis_referensi = JenisReferensi::query()->select('id','nama')->get();
        return Inertia::render('Apps/References/Index',[
            'jenis_referensi' => $jenis_referensi
        ]);
    }
}
