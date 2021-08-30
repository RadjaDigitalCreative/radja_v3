<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Category extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('categories')
        ->where('id_team', $request->id_team)
        ->get();
        return response()->json([
            'categories' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function edit($id)
    {
        $data = DB::table('categories')
        ->where('id', $id)
        ->get();
        $false = DB::table('categories')
        ->where('id', '!=', $id)
        ->get();
        if ($data) {
            return response()->json([
                'categories' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
        }
    }
    public function create(Request $request)
    {
        $data = DB::table('categories')
        ->insert([
            'name' => $request->name,
            'id_team' => $request->id_team,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json([
         'categories' => $data,
         'status_code'   => 200,
         'msg'           => 'success',
     ], 201);
    }
    public function update(Request $request, $id)
    {
        $data = DB::table('categories')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if (is_null($data)) {
            return response()->json('data tidak ada', 404);
        }else{
            return response()->json([
               'categories' => $data,
               'status_code'   => 200,
               'msg'           => 'success',
           ], 200);
        }
    }
    public function delete(Request $request, $id)
    {
        $data = DB::table('categories')
        ->where('id', $id)
        ->delete();
        return response()->json([
            'categories' => 'Data Berhasil Dihapus',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
}
