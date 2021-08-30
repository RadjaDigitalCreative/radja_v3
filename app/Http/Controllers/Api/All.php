<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class All extends Controller
{
    public function index()
    {
        $supplier = DB::table('supplier')->get();
        $categories = DB::table('categories')->get();
        $orders = DB::table('orders')->get();
        $payments = DB::table('payments')->get();
        $products = DB::table('products')->get();
        $restock = DB::table('restock')->get();
        $users = DB::table('users')->get();
        return response()->json([
            'supplier' => $supplier,
            'categories' => $categories,
            'orders' => $orders,
            'payments' => $payments,
            'restock' => $restock,
            'users' => $users,
        ], 200);
    }
    public function edit($id)
    {
        $data = DB::table('supplier')
        ->where('id', $id)
        ->get();
        return response()->json([
            $data
        ], 200);
    }
}
