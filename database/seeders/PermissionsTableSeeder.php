<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //permission dashboard
        Permission::create(['name'=>'dashboard.index','guard_name'=>'web']);
        Permission::create(['name'=>'dashboard.barang','guard_name'=>'web']);
        Permission::create(['name'=>'dashboard.surat_pending','guard_name'=>'web']);
        Permission::create(['name'=>'dashboard.stok_barang','guard_name'=>'web']);

        //permission pegawai
        Permission::create(['name'=>'pegawai.index','guard_name'=>'web']);
        Permission::create(['name'=>'pegawai.add','guard_name'=>'web']);
        Permission::create(['name'=>'pegawai.edit','guard_name'=>'web']);
        Permission::create(['name'=>'pegawai.delete','guard_name'=>'web']);

        //permission perusahaan
        Permission::create(['name'=>'perusahaan.index','guard_name'=>'web']);
        Permission::create(['name'=>'perusahaan.add','guard_name'=>'web']);
        Permission::create(['name'=>'perusahaan.edit','guard_name'=>'web']);
        Permission::create(['name'=>'perusahaan.delete','guard_name'=>'web']);

        //permission barang
        Permission::create(['name'=>'barang.index','guard_name'=>'web']);
        Permission::create(['name'=>'barang.add','guard_name'=>'web']);
        Permission::create(['name'=>'barang.edit','guard_name'=>'web']);
        Permission::create(['name'=>'barang.delete','guard_name'=>'web']);
        Permission::create(['name'=>'barang.field_stok','guard_name'=>'web']);

        //permission order
        Permission::create(['name'=>'order.index','guard_name'=>'web']);
        Permission::create(['name'=>'order.add','guard_name'=>'web']);
        Permission::create(['name'=>'order.edit','guard_name'=>'web']);
        Permission::create(['name'=>'order.delete','guard_name'=>'web']);
        Permission::create(['name'=>'order.approval','guard_name'=>'web']);

        //permission barang masuk
        Permission::create(['name'=>'barang_masuk.index','guard_name'=>'web']);
        Permission::create(['name'=>'barang_masuk.add','guard_name'=>'web']);
        Permission::create(['name'=>'barang_masuk.edit','guard_name'=>'web']);
        Permission::create(['name'=>'barang_masuk.delete','guard_name'=>'web']);

        //permission barang keluar
        Permission::create(['name'=>'barang_keluar.index','guard_name'=>'web']);
        Permission::create(['name'=>'barang_keluar.approval','guard_name'=>'web']);

        //permission referensi
        Permission::create(['name'=>'referensi.index','guard_name'=>'web']);
        Permission::create(['name'=>'referensi.add','guard_name'=>'web']);
        Permission::create(['name'=>'referensi.edit','guard_name'=>'web']);
        Permission::create(['name'=>'referensi.delete','guard_name'=>'web']);

        //permission jenis referensi
        Permission::create(['name'=>'jenis_referensi.index','guard_name'=>'web']);
        Permission::create(['name'=>'jenis_referensi.add','guard_name'=>'web']);
        Permission::create(['name'=>'jenis_referensi.edit','guard_name'=>'web']);
        Permission::create(['name'=>'jenis_referensi.delete','guard_name'=>'web']);

        //permission roles
        Permission::create(['name'=>'roles.index','guard_name'=>'web']);
        Permission::create(['name'=>'roles.add','guard_name'=>'web']);
        Permission::create(['name'=>'roles.edit','guard_name'=>'web']);
        Permission::create(['name'=>'roles.delete','guard_name'=>'web']);

        //permission user
        Permission::create(['name'=>'user.index','guard_name'=>'web']);
        Permission::create(['name'=>'user.add','guard_name'=>'web']);
        Permission::create(['name'=>'user.edit','guard_name'=>'web']);
        Permission::create(['name'=>'user.delete','guard_name'=>'web']);
    }
}
