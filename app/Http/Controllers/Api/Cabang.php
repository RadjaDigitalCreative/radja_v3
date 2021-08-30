<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use app\Exceptions\Handler;
use Illuminate\Http\Request;
use DB;

class Cabang extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('cabang')
        ->where('id_team', $request->id_team)
        ->where('nama_cabang', '!=', 'NULL')
        ->get();
        return response()->json([
            'cabang' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function edit($id)
    {
        $data = DB::table('cabang')
        ->where('id', $id)
        ->get();
        $false = DB::table('cabang')
        ->where('id', '!=', $id)
        ->get();
        if ($data) {
            return response()->json([
                'cabang' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
        }
    }
    public function create(Request $request)
    {
        $data = DB::table('cabang')
        ->insert([
            'nama_cabang' => $request->nama_cabang,
            'langitude' => $request->langitude,
            'longitude' => $request->longitude,
            'id_team' => $request->id_team,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json([
         'cabang' => $data,
         'status_code'   => 200,
         'msg'           => 'success',
     ], 201);
    }
    public function update(Request $request, $id)
    {
        $data = DB::table('cabang')
        ->where('id', $id)
        ->update([
            'nama_cabang' => $request->nama_cabang,
            'langitude' => $request->langitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if (is_null($data)) {
            return response()->json('data tidak ada', 404);
        }else{
            return response()->json([
               'cabang' => $data,
               'status_code'   => 200,
               'msg'           => 'success',
           ], 200);
        }
    }
    public function delete(Request $request, $id)
    {
        $data = DB::table('cabang')
        ->where('id', $id)
        ->delete();
        return response()->json([
            'cabang' => 'Data Berhasil Dihapus',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
}
