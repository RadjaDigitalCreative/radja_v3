<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;


class Order extends Controller
{
	public function print($id)
	{
		$data = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by');
		})
		->where('orders.id', $id)
		->where('orders.keperluan', 'Penjualan')

		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->select('orders.id' ,'orders.note', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'orders.total as total_semua', 'orders.keperluan'
			,'payments.name as payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'orders.created_at', 'orders.discount' ,'users.name AS kasir')

		->first();
		$data2 = DB::table('order_details')
		->where('order_id', $id)
		->get();
		$data3 = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by');
		})
		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->where('orders.id', $id)
		->get();


		$false = DB::table('orders')
		->where('id', '!=', $id)
		->get();
		if ($data != NULL) {
			return response()->json([
				'report order' => $data,
				'detail order' => $data2,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);

		}else{
			return response()->json([
				'report order' => $data,
				'detail order' => $data2,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);

		}
	}
	public function printpdf($id)
	{
		$data = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by');
		})
		->where('orders.id', $id)
		->where('orders.keperluan', 'Penjualan')

		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->select('orders.id' ,'orders.note', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'orders.total as total_semua', 'orders.keperluan'
			,'payments.name as payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'orders.created_at', 'orders.discount' ,'users.name AS kasir')

		->first();
		$data2 = DB::table('order_details')
		->where('order_id', $id)
		->get();
		$data3 = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by');
		})
		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->where('orders.id', $id)
		->get();


		$false = DB::table('orders')
		->where('id', '!=', $id)
		->get();
		if ($data != NULL) {
			$pdf = PDF::loadView('pdf.order',compact('data', 'data2'));
			return $pdf->stream('order.pdf');

		}else{
			$pdf = PDF::loadView('pdf.document', $data);
			return $pdf->stream('order.pdf');

		}
	}

    public function index(Request $request)
    {
        if(empty($request->lokasi)){
            $data2 = DB::table('orders')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'orders.created_by')
                        ->where('orders.keperluan', 'Penjualan');
                })
                ->join('order_details', function ($join) {
                    $join->on('order_details.order_id', '=', 'orders.id');
                })
                ->join('payments', function ($join) {
                    $join->on('payments.id', '=', 'orders.payment_id');
                })
                ->select('orders.id', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                    , 'payments.name AS payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name AS kasir')
                ->addSelect('order_details.product_name')
                ->where('orders.id_team', $request->id_team)
                ->groupBy('order_details.order_id')
                ->get();
        }else{
            $data2 = DB::table('orders')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'orders.created_by')
                        ->where('orders.keperluan', 'Penjualan');
                })
                ->join('order_details', function ($join) {
                    $join->on('order_details.order_id', '=', 'orders.id');
                })
                ->join('payments', function ($join) {
                    $join->on('payments.id', '=', 'orders.payment_id');
                })
                ->select('orders.id', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                    , 'payments.name AS payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name AS kasir')
                ->addSelect('order_details.product_name')
                ->where('orders.id_team', $request->id_team)
                ->where('orders.lokasi', $request->lokasi)
                ->groupBy('order_details.order_id')
                ->get();
        }

        return response()->json([
            'orders' => $data2,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);
    }
    public function jenis_penjualan(Request $request)
    {
        if(empty($request->lokasi)){
            $data2 = DB::table('orders')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'orders.created_by')
                        ->where('orders.keperluan', 'Penjualan');
                })
                ->join('order_details', function ($join) {
                    $join->on('order_details.order_id', '=', 'orders.id');
                })
                ->join('payments', function ($join) {
                    $join->on('payments.id', '=', 'orders.payment_id');
                })
                ->select('orders.id', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                    , 'payments.name AS payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name AS kasir')
                ->addSelect('order_details.product_name')
                ->where('orders.id_team', $request->id_team)
                ->where('jenis_penjualan', $request->jenis_penjualan)
                ->groupBy('order_details.order_id')
                ->get();
        }else{
            $data2 = DB::table('orders')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'orders.created_by')
                        ->where('orders.keperluan', 'Penjualan');
                })
                ->join('order_details', function ($join) {
                    $join->on('order_details.order_id', '=', 'orders.id');
                })
                ->join('payments', function ($join) {
                    $join->on('payments.id', '=', 'orders.payment_id');
                })
                ->select('orders.id', 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                    , 'payments.name AS payment', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name AS kasir')
                ->addSelect('order_details.product_name')
                ->where('orders.id_team', $request->id_team)
                ->where('orders.lokasi', $request->lokasi)
                ->where('jenis_penjualan', $request->jenis_penjualan)
                ->groupBy('order_details.order_id')
                ->get();
        }

        return response()->json([
            'orders' => $data2,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);
    }
	public function edit($id)
	{
		$data = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by')
			->where('orders.keperluan', 'Penjualan');
		})
		->where('orders.id', $id)
		->join('order_details', function($join){
			$join->on('order_details.order_id', '=', 'orders.id');
		})
		->select('orders.id' , 'orders.table_number', 'orders.discount as bayar', 'orders.disc as discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
			,'orders.payment_id', 'orders.name', 'orders.lokasi', 'orders.notelp','users.name AS kasir')
		->addSelect('order_details.product_name')
		->groupBy('order_details.order_id')
		->get();
		$false = DB::table('orders')
		->where('id', '!=', $id)
		->get();
		if ($data) {
			return response()->json([
				'orders' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function create(Request $request)
	{
		DB::table('orders')
		->insert([
			'name' => $request->name,
			'payment_id' => $request->payment_id,
			'notelp' => $request->notelp,
			'table_number' => $request->table_number,
			'email' => $request->email,
			'lokasi' => $request->lokasi,
			'keperluan' => 'Penjualan',
			'discount' => $request->bayar,
			'total' => $request->total,
			'disc' => $request->discount,
			'created_by'   => $request->created_by,
			'id_team'   => $request->id_team,
			'jenis_penjualan'   => $request->jenis_penjualan,
			'created_at'   => now(),
			'updated_at'   => now(),
		]);


		$id = DB::getPdo()->lastInsertId();

		$count  = count($request->nama);
		for ($i=0; $i < $count; $i++) {
			DB::table('order_details')
			->insert([
				'order_id'  => $id,
				'product_name' => $request->nama[$i],
				'product_price' => $request->harga[$i],
				'purchase_price' => $request->harga_beli[$i],
				'quantity'  =>  $request->jumlah[$i],
				'subtotal'  => $request->subtotal[$i],
				'note'      =>  $request->note[$i],
				'created_at'   => now(),
				'updated_at'   => now(),
			]);

			$produk = DB::table('products')
            ->where([
                ['products.id', '=', $request->product_id[$i]],
            ])
            ->first();

			 DB::table('products')
            ->where([
                ['products.id', '=', $request->product_id[$i]],
            ])
            ->update([
                'stock' =>   $produk->stock - $request->jumlah[$i]
            ]);
		}
		DB::table('pembeli')
               ->insert([
                'name' => $request->name,
                'notelp' => $request->notelp,
                'cabang' => $request->lokasi,
                'id_team' => $request->id_team,
                'created_at' => now(),
        ]);
        for ($i=0; $i < $count; $i++) {
                DB::table('terjual')
                ->insert([
                    'name' => $request->nama[$i],
                    'terjual'  => $request->jumlah[$i],
                    'cabang'      => $request->lokasi,
                    'keperluan'      => 'Penjualan',
                    'product_id'      => $request->product_id[$i],
                    'id_team' => $request->id_team,
                    'order_id'  => $id,
                    'created_at'   => now(),
				    'updated_at'   => now(),
                ]);
        }
		return response()->json([
			'orders' => 'Order Sukses',
			'status_code'   => 200,
			'msg'           => 'success',
		], 201);
	}

	public function update(Request $request, $id)
	{
		$data = DB::table('orders')
		->where('id', $id)
		->update($request->all());
		if (is_null($data)) {
			return response()->json('data tidak ada', 404);
		}else{
			return response()->json([
				'orders' => $data,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);
		}
	}
	public function delete(Request $request, $id)
	{
		$data = DB::table('orders')
		->where('id', $id)
		->delete();
		return response()->json([
			'orders' => 'Data Berhasil Dihapus',
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function invoice($id)
	{
		$data = DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by')
			->where('orders.keperluan', 'Penjualan');
		})
		->join('cabang', function($join){
			$join->on('cabang.id_team', '=', 'orders.id_team');
		})
		->where('orders.id', $id)
		->join('order_details', function($join){
			$join->on('order_details.order_id', '=', 'orders.id');
		})
		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->select('orders.id' , 'orders.table_number', 'orders.discount AS bayar', 'orders.disc AS discount', 'orders.total as total semua', 'orders.keperluan'
			,'payments.name as payment', 'orders.name', 'orders.lokasi', 'orders.notelp','users.name AS kasir','orders.created_at', 'cabang.perusahaan', 'cabang.alamat')
		->groupBy('order_details.order_id')
		->get();
		$data2 = DB::table('order_details')
		->where('order_id', $id)
		->get();

		$false = DB::table('orders')
		->where('id', '!=', $id)
		->get();
		if ($data) {
			return response()->json([
				'invoice order' => $data,
				'detail product' => $data2,
				'status_code'   => 200,
				'msg'           => 'success',
			], 200);

		}

	}
}
