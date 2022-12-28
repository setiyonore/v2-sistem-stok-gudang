<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::query()
            ->when(request()->q, function ($perusahaan) {
                $perusahaan->where('nama', 'like', '%' . request()->q . '%');
            })
            ->select('id', 'nama', 'no_hp', 'email','alamat')
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Company/Index', [
            'perusahaan' => $perusahaan
        ]);
    }
}
