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
    {
        $jenis_referensi = JenisReferensi::query()->select('id', 'nama')->get();
        $referensi = Referensi::query()
            ->where('jenis_referensi_id', 1)
            ->select('id', 'nama', 'deskripsi')
            ->get();

        return Inertia::render('Apps/References/Index', [
            'jenis_referensi' => $jenis_referensi,
            'referensi' => $referensi
        ]);
    }

    public function create()
    {
        $jenis_referensi = JenisReferensi::query()
            ->select('id', 'nama')
            ->get();
        return Inertia::render('Apps/References/Create', [
            'jenis_referensi' => $jenis_referensi,
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'deskripsi' => 'required',
            'jenis_referensi' => 'required',
        ]);
        $referensi = Referensi::query()
        ->create([
            'jenis_referensi_id' => $request->jenis_referensi,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ]);
        return redirect()->route('apps.references.index');
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'jenis_referensi' => 'required'
        ]);
        $jenis_referensi = JenisReferensi::query()->select('id', 'nama')->get();
        $referensi = Referensi::query()
            ->where('jenis_referensi_id', $request->jenis_referensi)
            ->select('id', 'nama', 'deskripsi')
            ->get();
        return Inertia::render('Apps/References/Index', [
            'referensi' => $referensi,
            'jenis_referensi' => $jenis_referensi,
            'id_jenis_referensi' => (int)$request->jenis_referensi,
        ]);
    }
}
