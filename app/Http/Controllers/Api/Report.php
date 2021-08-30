<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Api\Exports\LabaExport;
use App\Http\Controllers\Api\Exports\ReportExport;
use App\Http\Controllers\Api\Exports\GradeExport;
use Maatwebsite\Excel\Facades\Excel;


class Report extends Controller
{
    public function terlaris(Request $request)
    {
        $data = DB::table('products')
            ->join('terjual', function ($join) {
                $join->on('products.name', '=', 'terjual.name');
            })
            ->where('terjual.keperluan', '=', 'Penjualan')
            ->where('terjual.id_team', '=', $request->id_team)
            ->select(
                'terjual.id',
                'products.id AS product_id',
                'products.image',
                'terjual.name AS nama_barang',
                'terjual.cabang',
                DB::raw('max(terjual.terjual) as terjual'),
                'terjual.created_at',
		)
            ->groupBy('terjual.name')
            ->get();
        return response()->json([
            'barang_terlaris' => $data,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);
    }

    public function report_grade_export(Request $request)
    {
        return Excel::download(new GradeExport($request->id), 'report_grade_orders.xlsx');
    }

    public function report_export(Request $request)
    {
        return Excel::download(new ReportExport($request->id), 'report_orders.xlsx');
    }

    public function export()
    {
        return Excel::download(new LabaExport, 'laba.xlsx');
    }

    public function grade(Request $request)
    {
        $data = DB::table('terjual')
            ->join('products', 'terjual.id_team', '=', 'products.id_team')
            ->where('terjual.keperluan', '=', 'Penjualan')
            ->where('terjual.id_team', '=', $request->id_team)
            ->select(
                'terjual.id',
                'terjual.name AS nama_barang',
                'terjual.cabang',
                'terjual.terjual',
                'terjual.created_at',
		)
            ->groupBy('terjual.id')
            ->get();
        return response()->json([
            'report grade pesananan' => $data,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);

    }

    public function laba(Request $request)
    {
        if (empty($request->lokasi)) {
            $data = DB::table('products')
                ->join('order_details', function ($join) {
                    $join->on('products.name', '=', 'order_details.product_name');
                })
                ->join('orders', function ($join) {
                    $join->on('orders.id', '=', 'order_details.order_id');
                })
                ->where('products.id_team', $request->id_team)
                ->select(
                    'products.name',
                    'order_details.purchase_price',
                    'order_details.product_price',
                    'order_details.quantity',
                    'orders.lokasi',
                    'orders.name AS customer',
                    'orders.created_at',
                )
                ->groupBy('orders.id')
                ->get();
        } else {
            $data = DB::table('products')
                ->join('order_details', function ($join) {
                    $join->on('products.name', '=', 'order_details.product_name');
                })
                ->join('orders', function ($join) {
                    $join->on('orders.id', '=', 'order_details.order_id');
                })
                ->where('products.id_team', $request->id_team)
                ->where('orders.lokasi', $request->lokasi)
                ->select(
                    'products.name',
                    'order_details.purchase_price',
                    'order_details.product_price',
                    'order_details.quantity',
                    'orders.lokasi',
                    'orders.name AS customer',
                    'orders.created_at',
                )
                ->groupBy('orders.id')
                ->get();
        }

        return response()->json([
            'report laba' => $data,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);
    }
    public function laba_jenis_penjualan(Request $request)
    {
        if (empty($request->lokasi)) {
            $data = DB::table('products')
                ->join('order_details', function ($join) {
                    $join->on('products.name', '=', 'order_details.product_name');
                })
                ->join('orders', function ($join) {
                    $join->on('orders.id', '=', 'order_details.order_id');
                })
                ->where('products.id_team', $request->id_team)
                ->where('jenis_penjualan', $request->jenis_penjualan)
                ->select(
                    'products.name',
                    'order_details.purchase_price',
                    'order_details.product_price',
                    'order_details.quantity',
                    'orders.lokasi',
                    'orders.name AS customer',
                    'orders.created_at',
                )
                ->groupBy('orders.id')
                ->get();
        } else {
            $data = DB::table('products')
                ->join('order_details', function ($join) {
                    $join->on('products.name', '=', 'order_details.product_name');
                })
                ->join('orders', function ($join) {
                    $join->on('orders.id', '=', 'order_details.order_id');
                })
                ->where('products.id_team', $request->id_team)
                ->where('orders.lokasi', $request->lokasi)
                ->where('jenis_penjualan', $request->jenis_penjualan)
                ->select(
                    'products.name',
                    'order_details.purchase_price',
                    'order_details.product_price',
                    'order_details.quantity',
                    'orders.lokasi',
                    'orders.name AS customer',
                    'orders.created_at',
                )
                ->groupBy('orders.id')
                ->get();
        }

        return response()->json([
            'report laba' => $data,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);
    }

    public function index(Request $request)
    {
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
            ->select('orders.id', 'orders.table_number', 'orders.discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                , 'payments.name AS payment name', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name', 'orders.created_at AS created_at')
            ->addSelect('order_details.product_name')
            ->where('orders.id_team', $request->id_team)
            ->groupBy('order_details.order_id')
            ->get();
        return response()->json([
            'report order' => $data2,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);

    }

    public function jenis_penjualan(Request $request)
    {
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
            ->select('orders.id', 'orders.table_number', 'orders.discount', 'order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
                , 'payments.name AS payment name', 'orders.name', 'orders.lokasi', 'orders.notelp', 'users.name', 'orders.created_at AS created_at')
            ->addSelect('order_details.product_name')
            ->where('orders.id_team', $request->id_team)

            ->groupBy('order_details.order_id')
            ->get();
        return response()->json([
            'report order' => $data2,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);

    }

    public function edit($id)
    {
        $data = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.created_by')
            ->where('orders.id', '=', $id)
            ->where('orders.keperluan', '=', 'Penjualan')
            ->select(
                'orders.id',
                'orders.table_number',
                'orders.discount',
                'orders.total',
                'orders.keperluan',
                'orders.image',
                'orders.payment_id',
                'users.name',
                'orders.lokasi',
		)
            ->get();
        $terjual = DB::table('terjual')
            ->join('products', function ($join) {
                $join->on('products.name', '=', 'terjual.name')
                    ->on('products.lokasi', '=', 'terjual.cabang');
            })
            ->orderBy('terjual.terjual', 'desc')
            ->get();
        return response()->json([
            'report order' => $data,
            'grade' => $terjual,
            'status_code' => 200,
            'msg' => 'success',
        ], 200);


    }

    public function create(Request $request)
    {
        $data = DB::table('orders')
            ->insert($request->all());
        return response()->json([
            'report' => $data,
            'status_code' => 200,
            'msg' => 'success',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('orders')
            ->where('id', $id)
            ->update($request->all());
        if (is_null($data)) {
            return response()->json('data tidak ada', 404);
        } else {
            return response()->json([
                'report' => $data,
                'status_code' => 200,
                'msg' => 'success',
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
            'status_code' => 200,
            'msg' => 'success',
        ], 200);

    }
}
