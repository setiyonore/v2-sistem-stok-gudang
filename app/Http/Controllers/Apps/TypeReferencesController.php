<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisReferensi;
use App\Models\Referensi;
use Inertia\Inertia;

class TypeReferencesController extends Controller
{
    public function index()
    {
        $jenis_referensi = JenisReferensi::query()
            ->select('id', 'nama', 'deskripsi')
            ->paginate(config('config.paginate'));
        return Inertia::render('Apps/TypeReferences/Index', [
            'jenis_referensi' => $jenis_referensi,
        ]);
    }
    public function create()
    {
        return Inertia::render('Apps/TypeReferences/Create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
        ],[
            'nama.required' => 'Mohon Inputkan Nama',
            'deskripsi.required' => 'Mohon Inputkan Deskripsi'
        ]);
        $jenis_referensi = JenisReferensi::query()
            ->create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);
        return redirect()->route('apps.type_references.index');
    }
    public function edit($id)
    {
        $jenis_referensi = JenisReferensi::query()
            ->findOrFail($id);
        return Inertia::render('Apps/TypeReferences/Edit', [
            'jenis_referensi' => $jenis_referensi,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'deskripsi' => 'required'
        ]);
        $jenis_referensi = JenisReferensi::query()->find($request->id);
        $jenis_referensi->nama = $request->nama;
        $jenis_referensi->deskripsi = $request->deskripsi;
        $jenis_referensi->save();
        return redirect()->route('apps.type_references.index');
    }

    public function destroy($id)
    {
        $referensi = Referensi::query()->where('jenis_referensi_id',$id);
        $referensi->delete();
        $jenis_referensi = JenisReferensi::query()->findOrFail($id);
        $jenis_referensi->delete();
        return redirect()->route('apps.type_references.index');
    }
}
