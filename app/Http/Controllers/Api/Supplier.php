<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Supplier extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('supplier')
        ->where('id_team', $request->id_team)
        ->get();
        return response()->json([
            'supplier' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function edit($id)
    {
        $data = DB::table('supplier')
        ->where('id', $id)
        ->get();
        $false = DB::table('supplier')
        ->where('id', '!=', $id)
        ->get();
        if ($data) {
            return response()->json([
                'supplier' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
        }
    }
    public function create(Request $request)
    {
        $data = DB::table('supplier')
        ->insert([
            'nama' => $request->nama,
            'perusahaan' => $request->perusahaan,
            'produk' => $request->produk,
            'notelp' => $request->notelp,
            'id_team' => $request->id_team,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json([
           'supplier' => $data,
           'status_code'   => 200,
           'msg'           => 'success',
       ], 201);
    }
    public function update(Request $request, $id)
    {
        $data = DB::table('supplier')
        ->where('id', $id)
        ->update([
             'nama' => $request->nama,
            'perusahaan' => $request->perusahaan,
            'produk' => $request->produk,
            'notelp' => $request->notelp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if (is_null($data)) {
            return response()->json('data tidak ada', 404);
        }else{
            return response()->json([
             'supplier' => $data,
             'status_code'   => 200,
             'msg'           => 'success',
         ], 200);
        }
    }
    public function delete(Request $request, $id)
    {
        $data = DB::table('supplier')
        ->where('id', $id)
        ->delete();
        return response()->json([
            'supplier' => 'Data Berhasil Dihapus',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
}
