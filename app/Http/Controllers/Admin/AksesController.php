<?php

namespace App\Http\Controllers\Admin;

use App\Model\Akses;
use App\Model\User;
use DB;
use App\Model\Cabang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;

class AksesController extends Controller
{
  private $titlePage='Akses Management';
  private $titlePage2='Harga Menu Management';
  private $titlePage3='Tabel Harga Perpemakaian';
  protected $folder   = 'backend.admin.akses';
  protected $rdr   = '/admin/akses';

  public function hargalist()
  {
    $params=[
      'title' => $this->titlePage3
    ];
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->join('role', 'role.user_id', '=', 'users.id')
    ->get();
    $role_bayar = DB::table('role_bayar')
    ->first();
    return view($this->folder.'.list',$params, compact('role', 'bayar', 'role_bayar'));

  }
  public function hargamenu()
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
    $role_bayar = DB::table('role_bayar')
    ->first();
    return view($this->folder.'.create',$params, compact('role', 'bayar', 'role_bayar'));

  }
  public function hargamenu_store(Request $request)
  {
    $user = DB::table('role_bayar')->first();
    if ($user === null) {
      DB::table('role_bayar')
      ->insert([
       'adminpay' => str_replace( ".", "", $request->adminpay),
       'aksespay' =>  str_replace( ".", "", $request->aksespay),
       'supplierpay' =>  str_replace( ".", "", $request->supplierpay),
       'kategoripay' => str_replace( ".", "", $request->kategoripay),
       'produkpay' => str_replace( ".", "", $request->produkpay),
       'orderpay' =>  str_replace( ".", "", $request->orderpay),
       'payementpay' =>  str_replace( ".", "", $request->payementpay),
       'reportpay' => str_replace( ".", "", $request->reportpay),
       'kaspay' =>  str_replace( ".", "", $request->kaspay),
       'stockpay' =>  str_replace( ".", "", $request->stockpay),
       'cabangpay' =>  str_replace( ".", "", $request->cabangpay),
       'userpay' =>  str_replace( ".", "", $request->userpay)
     ]);
    }else{
     DB::table('role_bayar')->delete();
     DB::table('role_bayar')
     ->insert([
      'adminpay' => str_replace( ".", "", $request->adminpay),
      'aksespay' =>  str_replace( ".", "", $request->aksespay),
      'supplierpay' =>  str_replace( ".", "", $request->supplierpay),
      'kategoripay' => str_replace( ".", "", $request->kategoripay),
      'produkpay' => str_replace( ".", "", $request->produkpay),
      'orderpay' =>  str_replace( ".", "", $request->orderpay),
      'payementpay' =>  str_replace( ".", "", $request->payementpay),
      'reportpay' => str_replace( ".", "", $request->reportpay),
      'kaspay' =>  str_replace( ".", "", $request->kaspay),
      'stockpay' =>  str_replace( ".", "", $request->stockpay),
      'cabangpay' =>  str_replace( ".", "", $request->cabangpay),
      'userpay' =>  str_replace( ".", "", $request->userpay)
    ]);
     return redirect('admin/akses')->with('success', 'Menu Harga Telah Berubah');
   }
   return redirect('admin/akses')->with('success', 'Menu Harga Telah Tersimpan');
 }

 public function index()
 {
  $params=[
    'title' => $this->titlePage
  ];
  $data =  DB::table('role')
  ->join('users', 'role.user_id', '=', 'users.id')
  ->where('id_team', '=', auth()->user()->id_team)
  ->get();
  $user = DB::table('users')
  ->where('id_team', '=', auth()->user()->id_team)

  ->get();
  $cabang = Cabang::all();
  $role_cabang = DB::table('role_cabang')
  ->join('users', 'role_cabang.user_id', '=', 'users.id')
  ->where('id_team', '=', auth()->user()->id_team)

  ->get();
  $role  = DB::table('role')
  ->join('users', 'role.user_id', '=', 'users.id')
  ->get();
  $bayar = DB::table('users')
  ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
  ->get();
  return view($this->folder.'.index',$params, compact('role_cabang', 'cabang', 'data','user','role', 'bayar'));
}

public function store(Request $request)
{
  DB::table('role')
  ->where('user_id', $request->user_id)
  ->update([
    'is_admin' => $request->is_admin,
    'is_akses' => $request->is_akses,
    'is_supplier' => $request->is_supplier,
    'is_kategori' => $request->is_kategori,
    'is_produk' => $request->is_produk,
    'is_order' => $request->is_order,
    'is_pay' => $request->is_pay,
    'is_report' => $request->is_report,
    'is_kas' => $request->is_kas,
    'is_stok' => $request->is_stok,
    'is_cabang' => $request->is_cabang,
    'is_user' => $request->is_user
  ]);
  return redirect('admin/akses')->with('success', 'Selamat Data Telah Tersimpan');
}

public function show(Request $request)
{

  DB::table('role_cabang')
  ->where('user_id', '=', $request->user_id)
  ->delete();
  $count  = count($request->cabang);
  for ($i=0; $i < $count; $i++) {
    DB::table('role_cabang')
      // ->where('user_id',  $request->user_id)
    ->insert([
      'user_id' => $request->user_id,
      'nama_cabang' => $request->cabang[$i]
    ]);
  }
    // return response()->json($request->cabang);
  return redirect('admin/akses')->with('success', 'Selamat Data Telah Tersimpan');
}
public function edit(Akses $akses)
{
        //
}


public function update(Request $request, Akses $akses)
{
        //
}
public function destroy($id)
{
  $data   = Akses::find($id);
  $data->delete();
  return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');
}

}
