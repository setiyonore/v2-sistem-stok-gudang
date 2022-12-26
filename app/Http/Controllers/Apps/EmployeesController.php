<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Referensi;
use Inertia\Inertia;
use App\Traits\HelperMasterTraits;

class EmployeesController extends Controller
{
    use HelperMasterTraits;
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

    public function create()
    {
        $jabatan = $this->getReferensi(config('config.referensi_jabatan'));
        return Inertia::render('Apps/Employees/Create', [
            'jabatan' => $jabatan,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jabatan' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
        ],[
            'nama.required' => 'Mohon inputkan nama',
            'tanggal_lahir.required' => 'Mohon inputkan tanggal lahir',
            'jabatan.required' => 'Mohon inputkan jabatan',
            'no_hp.required' => 'Mohon inputkan no hp',
            'alamat.required' => 'Mohon inputkan alamat',
        ]);
        $pegawai = Pegawai::query()
        ->create([
            'nama' => $request->nama,
            'referensi_jabatan' => $request->jabatan,
            'tgl_lahir' => $request->tanggal_lahir,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);
        return redirect()->route('apps.employees.index');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::query()->findOrFail($id);
        $jabatan = $this->getReferensi(config('config.referensi_jabatan'));
        return Inertia::render('Apps/Employees/Edit',[
            'pegawai' => $pegawai,
            'jabatan' => $jabatan,
        ]);
    }
}
