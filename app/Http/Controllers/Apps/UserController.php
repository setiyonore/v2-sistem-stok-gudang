<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Testing\Concerns\Interaction;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request()->q, function ($users) {
                $users = $users->where('name', 'like', '%' . request()->q . '%');
            })->with('roles')->latest()->paginate(config('config.paginate'));

        return Inertia::render('Apps/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        $pegawai = Pegawai::query()->select('id', 'nama')->get();
        return Inertia::render('Apps/Users/Create', [
            'roles' => $roles,
            'pegawai' => $pegawai,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'pegawai' => 'required',
            'roles' => 'required'
        ], [
            'name.required' => 'Mohon Inputkan Nama',
            'email.required' => 'Mohon Inputkan Email',
            'password.required' => 'Mohon Inputkan Password',
            'pegawai.required' => 'Mohon Pilih Pegawai',
            'roles.required' => 'Mohon Pilih Roles'
        ]);

        $user = User::query()
            ->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'pegawai_id' => $request->pegawai,
            ]);
        $user->assignRole($request->roles);
        return redirect()->route('apps.users.index');
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $pegawai = Pegawai::query()->select('id', 'nama')->get();
        return Inertia::render('Apps/Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'pegawai' => $pegawai,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed'
        ]);
        if ($request->password == '') {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'pegawai_id' => $request->pegawai,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'pegawai_id' => $request->pegawai,
            ]);
        }

        $user->syncRoles($request->roles);
        return redirect()->route('apps.users.index');
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return redirect()->route('apps.users.index');
    }
}
