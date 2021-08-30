<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use app\Exceptions\Handler;
use Illuminate\Http\Request;
use DB;

class QC extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('products')
        ->where('id_team', $request->id_team)
        ->where('qc', '!=', 'NULL')
        ->get();
        return response()->json([
            'QR_products' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
    public function get(Request $request)
    {
        $data = DB::table('products')
        ->where('qc', $request->qc)
        ->get();
        return response()->json([
            'QR_product_get' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);

    }
}
