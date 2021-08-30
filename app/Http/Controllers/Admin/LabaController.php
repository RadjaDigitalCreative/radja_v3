<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\OrderDetail;
use App\Model\Product;
use Illuminate\Support\Facades\Mail;
use DB;
use Alert;
use Carbon\Carbon;

class LabaController extends Controller
{
    private $titlePage='Report Laba';
    public function index()
    {
        $params=[
            'title' => $this->titlePage
        ];
        $data   =  DB::table('products')
        ->join('order_details', function($join){
            $join->on('products.name', '=', 'order_details.product_name');
        })
        ->join('orders', function($join){
            $join->on('orders.id', '=', 'order_details.order_id');
        })
        // ->where('products.id_team', auth()->user()->id_team)
        // ->where('orders.lokasi', auth()->user()->lokasi)
        ->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view('backend.admin.laba.index',$params, compact('data', 'role', 'bayar', 'jenis_penjualan'));
    }
    public function create()
    {
        $params=[
            'title' => $this->titlePage
        ];
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $query = request()->lokasi;
        $data   =  DB::table('products')->whereBetween('order_details.created_at', [$start, $end])
        ->where('orders.lokasi', 'LIKE', '%' . $query . '%')
        ->join('order_details', function($join){
            $join->on('products.name', '=', 'order_details.product_name');
        })
        ->join('orders', function($join){
            $join->on('orders.id', '=', 'order_details.order_id');
        })
        ->where('orders.id_team', auth()->user()->id_team)
        ->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view('backend.admin.laba.index',$params, compact('data', 'role', 'bayar', 'jenis_penjualan'));
    }

    public function filter(Request $request)
    {
        $params=[
            'title' => $this->titlePage
        ];
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $query = request()->lokasi;
        $data   =  DB::table('products')->whereBetween('order_details.created_at', [$start, $end])
            ->where('orders.lokasi', 'LIKE', '%' . $query . '%')
            ->join('order_details', function($join){
                $join->on('products.name', '=', 'order_details.product_name');
            })
            ->join('orders', function($join){
                $join->on('orders.id', '=', 'order_details.order_id');
            })
            ->where('orders.id_team', auth()->user()->id_team)
            ->where('jenis_penjualan', $request->jenis_penjualan)
            ->get();
        $role  = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view('backend.admin.laba.index',$params, compact('data', 'role', 'bayar', 'jenis_penjualan'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
