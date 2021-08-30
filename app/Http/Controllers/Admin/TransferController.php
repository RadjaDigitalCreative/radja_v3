<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use DB; 
use Alert;

class TransferController extends Controller
{
    private $titlePage='Transfer';
    private $titlePage2='Tambah Transfer';
    private $titlePage3='Update Transfer';

    protected $folder   = 'backend.setting.payment';
    protected $rdr   = 'admin/user/';
    public function index()
    {
        //
    }
    public function create(Request $request)
    {
        $params=[
            'title' => $this->titlePage2
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view($this->folder.'.create',$params, compact('role','bayar'));
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Request $request, $id)
    {

    }
    public function edit($id)
    {
        $params=[
            'title' => $this->titlePage3
        ];
        $data   = User::find($id);
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $pay = DB::table('role_pay')
        ->orderBy('bulan')
        ->get();
        return view($this->folder.'.edit',$params, compact('data', 'role','bayar', 'data', 'pay'));
    }
    public function update(Request $request, $id)
    {

        $waktu = ($request->bulan * 30)." days" ;
        $harga = DB::table('role_pay')
        ->where('bulan', $request->bulan)
        ->first();

        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        DB::table('role_payment')
        ->where('user_id', '=', $request->user_id)
        ->update([
            'tgl_bayar' => date('Y-m-d', strtotime($waktu, strtotime(now()))),
            'harga' => $harga->harga,
            'pay' => 1,
            'bank' => $request->bank,
            'image' => $new_name,
        ]);

        return redirect($this->rdr)->with('success', 'Data berhasil dikirim. Silahkan tunggu dikonfirmasi');
    }
    public function destroy($id)
    {

    }
    public function konfirmasi(Request $request, $id){
        DB::table('role_payment')
        ->where('user_id', '=', $id)
        ->update([
            'pay'  => 2,
            'dibayar'  => $request->dibayar,
        ]);
        return redirect($this->rdr)->with('success', 'Data berhasil dikonfirmasi');
    }
    public function cancel_konfirmasi(Request $request, $id){
        DB::table('role_payment')
        ->where('user_id', '=', $id)
        ->update([
            'pay'  => NULL,
            'dibayar'  => NULL,
        ]);
        return redirect($this->rdr)->with('success', 'Pembayaran Berhasil Dibatalkan');
    }

}
