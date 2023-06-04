<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        //get roles
        $roles = Role::when(request()->q, function ($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(5);

        //render with inertia
        return inertia('Apps/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Apps/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ], [
            'name.required' => 'Mohon Inputkan Nama',
            'permissions.required' => 'Mohon Inputkan Hak Akses',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('apps.roles.index');
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return Inertia::render('Apps/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('apps.roles.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $role = Role::query()->findOrFail($id);
        $role->delete();
        return redirect()->route('apps.roles.index');
    }
}
