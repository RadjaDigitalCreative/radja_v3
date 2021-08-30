<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Models\Was;
use App\Http\Controllers\Api\Models\WaImports;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ImportJob;
use DB;
use Auth;
use Response;


class Waweb extends Controller
{
    public function contoh_wa()
    {
        $file= public_path(). "/format_wa_excel.xlsx";
        $headers = array(
            'Content-Type: application/xlsx',
        );
        return Response::download($file, 'format_wa_excel.xlsx', $headers);
    }
    public function konfirmasi(Request $request)
    {
        $data = DB::table('waweb')
        ->where('id', $request->id)
        ->update([
                'status' => 1
            ]);
             return response()->json([
            'waweb_konfirmasi' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }
    public function index(Request $request)
    {
        $data = DB::table('waweb')
        ->where('name', '!=', 'NAMA')
        ->where('status', NULL)
        ->where('id_team', $request->id_team)
        ->get();
        return response()->json([
            'waweb' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }
    public function import(Request $request)
    {
        $data = Excel::import(new WaImports($request->id),request()->file('file'));
        return response()->json([
            'Wa Blast' => 'Sukses Import Data ',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }

}
