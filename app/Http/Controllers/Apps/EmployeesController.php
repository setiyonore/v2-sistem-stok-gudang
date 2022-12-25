<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Inertia\Inertia;

class EmployeesController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::query()
            ->when(request()->q, function ($pegawai) {
                $pegawai->where('pegawai.nama', 'like', '%' . request()->q . '%');
            })
            ->leftJoin('referensi as r', 'r.id', 'pegawai.referensi_jabatan')
            ->select(
                'r.nama as jabatan',
                'pegawai.nama',
                'pegawai.no_hp',
                'pegawai.nip',
                'pegawai.id',
            )
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Employees/Index', [
            'pegawai' => $pegawai
        ]);
    }
}
