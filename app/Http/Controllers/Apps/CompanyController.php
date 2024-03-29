<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\OrderBarang;
use App\Models\Perusahaan;
use App\Traits\HelperMasterTraits;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    use HelperMasterTraits;
    public function index()
    {
        $perusahaan = Perusahaan::query()
            ->when(request()->q, function ($perusahaan) {
                $perusahaan->where('nama', 'like', '%' . request()->q . '%');
            })
            ->select('id', 'nama', 'no_hp', 'email', 'alamat')
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/Company/Index', [
            'perusahaan' => $perusahaan
        ]);
    }
    public function create()
    {
        $jenis = $this->getReferensi(config('config.jenis_perusahaan'));
        return Inertia::render('Apps/Company/Create', [
            'jenis' => $jenis
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'jenis_perusahaan' => 'required'
        ], [
            'nama.required' => 'Mohon inputkan nama',
            'no_hp.required' => 'Mohon inputkan no hp',
            'email.required' => 'Mohon inputkan email',
            'alamat.required' => 'Mohon inputkan alamat',
            'jenis_perusahaan' => 'Mohon pilih jenis perusahaan',

        ]);

        $perusahaan = Perusahaan::query()
            ->create([
                'nama' => $request->nama,
                'referensi_jenis_perusahaan' => $request->jenis_perusahaan,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'pic' => $request->pic,
                'no_hp_pic' => $request->no_pic,
            ]);
        return redirect()->route('apps.company.index');
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::query()->findOrFail($id);
        $jenis = $this->getReferensi(config('config.jenis_perusahaan'));
        return Inertia::render('Apps/Company/Edit', [
            'perusahaan' => $perusahaan,
            'jenis' => $jenis,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'jenis_perusahaan' => 'required'
        ], [
            'nama.required' => 'Mohon inputkan nama',
            'no_hp.required' => 'Mohon inputkan no hp',
            'email.required' => 'Mohon inputkan email',
            'alamat.required' => 'Mohon inputkan alamat',
            'jenis_perusahaan' => 'Mohon pilih jenis perusahaan',

        ]);
        $perusahaan = Perusahaan::query()->find($request->id);
        $perusahaan->nama = $request->nama;
        $perusahaan->referensi_jenis_perusahaan = $request->jenis_perusahaan;
        $perusahaan->alamat = $request->alamat;
        $perusahaan->no_hp = $request->no_hp;
        $perusahaan->email = $request->email;
        $perusahaan->pic = $request->pic;
        $perusahaan->no_hp_pic = $request->no_pic;
        $perusahaan->save();
        return redirect()->route('apps.company.index');
    }
    public function show($id)
    {
        $perusahaan = Perusahaan::query()
            ->leftJoin('referensi as r', 'r.id', 'perusahaan.referensi_jenis_perusahaan')
            ->select(
                'r.nama as jenis_perusahaan',
                'perusahaan.nama',
                'perusahaan.no_hp',
                'perusahaan.pic',
                'perusahaan.no_hp_pic',
                'perusahaan.email',
                'perusahaan.alamat',
            )
            ->first();
        return Inertia::render('Apps/Company/Detil', [
            'perusahaan' => $perusahaan,
        ]);
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::query()->findOrFail($id);
        $perusahaan->delete();
        return redirect()->route('apps.company.index');
    }

    public function checkUsage($id)
    {
        $usage = OrderBarang::query()
            ->where('pelanggan_id',$id)
            ->count();
        if ($usage >0){
            return response()->json(['usage'=>1]);
        }
        return response()->json(['usage'=>0]);
    }
}
