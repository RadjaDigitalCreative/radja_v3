<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class RecordController extends Controller
{
  private $titlePage='Record Pesanan Masuk';
  private $titlePage2='Record Pesanan Keluar';

  public function masuk(Request $request)
  {
    $params=[
      'title' => $this->titlePage
    ];
    $link = DB::table ('terjual')
    ->groupBy('cabang')
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view('backend.admin.record.masuk.index', $params, compact('link', 'role', 'bayar'));
  }
  public function keluar(Request $request)
  {
    $params=[
      'title' => $this->titlePage2
    ];
    $link = DB::table ('terjual')
    ->groupBy('cabang')
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view('backend.admin.record.keluar.index', $params, compact('link', 'role', 'bayar'));
  }
}
