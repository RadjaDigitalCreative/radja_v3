<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params=[
            'title' => 'Notifikasi Pembayaran'
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();

        $sudah_bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('role_payment.pay', 2)
        ->where('role_payment.dibayar', '>=', now())
        ->get();

        $konfirmasi = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->select('users.*', 'role_payment.user_id', 'role_payment.dibayar', 'role_payment.tgl_bayar', 'role_payment.harga', 'role_payment.bank', 'role_payment.pay', 'role_payment.image')
        ->where('role_payment.pay', 1)
        ->get();

        $belum_bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('role_payment.dibayar', '<=', now())
        ->orWhere('role_payment.pay', '!=', 2)
        ->get();

        $hitung_bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('role_payment.pay', 2)
        ->count();
        return view('notifikasi.index', $params, compact('role', 'bayar', 'sudah_bayar', 'konfirmasi', 'belum_bayar', 'hitung_bayar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
