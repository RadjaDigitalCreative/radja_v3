<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Api\Exports\PembeliExport;
use Maatwebsite\Excel\Facades\Excel;


class Pembeli extends Controller
{
	public function export()
	{
		return Excel::download(new PembeliExport, 'pembeli.xlsx');
	}
	public function index(Request $request)
{
    if (empty($request->lokasi)) {
        $data = DB::table('pembeli')
            ->where('id_team', $request->id_team)
            ->get();
    }else{
        $data = DB::table('pembeli')
            ->where('id_team', $request->id_team)
            ->where('cabang', $request->lokasi)
            ->get();
    }
    return response()->json([
        'report pembeli' => $data,
        'status_code' => 200,
        'msg' => 'success',
    ], 200);
}
	public function edit($id)
	{
		$data = DB::table('pembeli')
		->where('id', $id)
		->get();
		return response()->json([
			'report pembeli' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
