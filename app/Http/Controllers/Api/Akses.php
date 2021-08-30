<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use app\Exceptions\Handler;
use Illuminate\Http\Request;
use DB;

class Akses extends Controller
{
     public function ver()
    {
        $data = DB::table('version')
        ->get();
        return response()->json([
            'version' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function index(Request $request)
    {
        $data = DB::table('role')
        ->join('users', 'users.id' , '=', 'role.user_id')
        ->where('role.user_id', $request->id)
        ->get();
        return response()->json([
            'role admin & owner' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function update(Request $request)
    {
        $data = DB::table('role')
        ->join('users', 'users.id' , '=', 'role.user_id')
        ->where('role.user_id', $request->user_id)
        ->update([
            'is_admin' => $request->is_admin,
            'is_akses' => $request->is_akses,
            'is_supplier' => $request->is_supplier,
            'is_kategori' => $request->is_kategori,
            'is_produk' => $request->is_produk,
            'is_order' => $request->is_order,
            'is_pay' => $request->is_pay,
            'is_report' => $request->is_report,
            'is_kas' => $request->is_kas,
            'is_stok' => $request->is_stok,
            'is_cabang' => $request->is_cabang,
            'is_user' => $request->is_user,
        ]);
        return response()->json([
            'role admin & owner' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }

    public function edit($id)
    {
        $data = DB::table('role')
        ->join('users', 'users.id' , '=', 'role.user_id')
        ->where('user_id', $id)
        ->get();
        if ($data) {
            return response()->json([
                'role' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
        }
    }
    public function create(Request $request)
    {
        $data = DB::table('cabang')
        ->insert($request->all());
        return response()->json([
         'role' => $data,
         'status_code'   => 200,
         'msg'           => 'success',
     ], 201);
    }
    
    public function delete(Request $request, $id)
    {
        $data = DB::table('role')
        ->where('id', $id)
        ->delete();
        return response()->json([
            'role' => 'Data Berhasil Dihapus',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
}
