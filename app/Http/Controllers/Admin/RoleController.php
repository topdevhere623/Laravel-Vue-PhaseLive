<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    protected $count = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $filter = null)
    {
        if ($request->has('search')) {
            $roles = Role::search($request->search)->paginate($this->count);
        } else {
            $roles = Role::paginate($this->count);
        }

        return view('admin.roles.index', compact('roles', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
            'permissions' => 'required'
        ]);

        $role = Role::create(['name' => $request['name']]);

        $role->syncPermissions($request['permissions']);

        Cache::forget('feed');

        return redirect('admin/roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required'
        ]);

        $role->fill(['name' => $request['name']])
            ->save();

        $role->syncPermissions($request['permissions']);

        Cache::forget('feed');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back()
            ->with(
                'flash_message',
             'Role deleted!'
            );
    }
}
