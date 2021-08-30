<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Role $role)
    {
        //
    }
    public function edit(Role $role)
    {
        //
    }

    public function update(Request $request, Role $role)
    {
        //
    }

    public function destroy($id)
    {
        $data   = Role::find($id);
        $data->delete();
        return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');
    }
}
