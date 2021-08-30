<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class Payment extends Controller
{
    public function hapus(Request $request)
	{
	     $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('role_payment.pay', 1)
        ->where('role_payment.id', $request->id)
        ->update([
                'role_payment.is_read' => 1
          ]);
          return response()->json([
			'notif_hapus' => $bayar,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
    public function notif()
	{
	    $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('role_payment.pay', 1)
        ->where('role_payment.is_read', NULL)
        ->get();
        return response()->json([
			'konfirmasi' => $bayar,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function index(Request $request)
	{
		$data = DB::table('payments')
		->where('id_team', $request->id_team)
		->get();
		return response()->json([
			'payments' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
	public function edit($id)
	{
		$data = DB::table('payments')
		->where('id', $id)
		->get();
		$false = DB::table('payments')
		->where('id', '!=', $id)
		->get();
		if ($data) {
			return response()->json([
				'payments' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function create(Request $request)
	{
		$data = DB::table('payments')
		->insert($request->all());
		return response()->json([
			'payments' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 201);
	}
	public function update(Request $request, $id)
	{
		$data = DB::table('payments')
		->where('id', $id)
		->update($request->all());
		if (is_null($data)) {
			return response()->json('data tidak ada', 404);
		}else{
			return response()->json([
				'payments' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function delete(Request $request, $id)
	{
		$data = DB::table('payments')
		->where('id', $id)
		->delete();
		return response()->json([
			'payments' => 'Data Berhasil Dihapus',
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
