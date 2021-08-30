<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Restock extends Controller
{
	public function index(Request $request)
	{
	if (empty($request->lokasi)) {
    $data = DB::table('restock')
        ->where('id_team', $request->id_team)
        ->get();
    } else {
        $data = DB::table('restock')
            ->where('id_team', $request->id_team)
            ->where('lokasi', $request->lokasi)
            ->get();
    }
    return response()->json([
        'products' => $data,
        'status_code' => 200,
        'msg' => 'success',
    ], 200);

	}
	public function edit($id)
	{
		$data = DB::table('restock')
		->where('id', $id)
		->get();
		$false = DB::table('restock')
		->where('id', '!=', $id)
		->get();
		if ($data) {
			return response()->json([
				'restock' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	
	public function create(Request $request)
	{
		$count  = count($request->name);
		for ($i=0; $i < $count; $i++) {
			$data = DB::table('restock')
			->insert([
				'name' => $request->nama_penanggung,
				'product_name' => $request->name[$i],
				'product_price' => $request->harga_beli[$i],
				'quantity'  =>  $request->jumlah[$i],
				'subtotal'      =>  $request->subtotal[$i],
				'status'      =>  $request->status,
				'lokasi'      =>  $request->lokasi,
				'supplier'      =>  $request->supplier,
				'satuan'      =>  $request->satuan[$i],
				'id_team' => $request->id_team,
				'created_at'   => now(),
				'updated_at'   => now(),
			]);
		}
		return response()->json([
			'restock' => $data,
			'data' => 'Berhasil restock barang',
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function konfirmasi(Request $request, $id)
	{
		$a = DB::table('restock')
		->where('id', $id)
		->select('status')
		->get();
		foreach ($a as $key) {
			$konfirmasi = $key->status;	
		}
		if ($konfirmasi == 0) {
			$data = DB::table('restock')
			->where('id', $id)
			->update([
				'status' => $konfirmasi +1,
			]);
			return response()->json([
				'restock' => $data,
				'data' => 'Berhasil Konfirmasi Barang',
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}elseif ($konfirmasi == 1) {
			$data = DB::table('restock')
			->where('id', $id)
			->update([
				'status' => $konfirmasi +1,
			]);
			return response()->json([
				'restock' => $data,
				'data' => 'Berhasil Terima Barang',
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}elseif ($konfirmasi == 2) {
			$data = DB::table('restock')
			->where('id', $id)
			->update([
				'status' => $konfirmasi +1,
			]);
			
			$produk = DB::table('products')
            ->where([
                ['products.name', '=', $request->nama],
                ['products.lokasi', '=', $request->lokasi],
            ])
            ->first();
			DB::table('products')
            ->where([
                ['name', '=', $request->nama],
                ['lokasi', '=', $request->lokasi],
            ])
            ->update([
                'purchase_price' => $request->product_price,
                'stock' =>  $produk->stock + $request->stock
            ]); 
			return response()->json([
				'restock' => $data,
				'data' => 'Berhasil Simpan Barang',
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}else{
			return response()->json([
				'restock' => 'Data Berhasil dimasukkan',
				'data' => 'Barang Berhasil Disimpan',
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
		
	}
	public function update(Request $request, $id)
	{
		$data = DB::table('restock')
		->where('id', $id)
		->update($request->all());
		if (is_null($data)) {
			return response()->json('data tidak ada', 404);
		}else{
			return response()->json([
				'restock' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function delete(Request $request, $id)
	{
		$data = DB::table('restock')
		->where('id', $id)
		->delete();
		return response()->json([
			'restock' => 'Data Berhasil Dihapus',
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
