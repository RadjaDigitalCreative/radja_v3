<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cabang;
use App\Model\Provinsi;
use App\Model\Regency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Adrianorosa\GeoLocation\GeoLocation;
use Stevebauman\Location\Facades\Location;
use Alert;


class CabangController extends Controller
{
  protected $folder = 'backend.admin.cabang';
  protected $rdr = '/admin/cabang';
  private $titlePage='Cabang Toko';
  private $titlePage2='Tambah Cabang Toko';
  private $titlePage3='Update Cabang Toko';

  public function index(Request $request)
  {
    $params=[
      'title' => $this->titlePage
    ];
    $data   = DB::table('cabang')
    ->where('id_team', auth()->user()->id_team)
    ->where('nama_cabang', '!=', 'NULL')
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.index',$params, compact('data','role', 'bayar'));
  }
  public function create()
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
    $provinsi = Provinsi::pluck('name', 'id');

    return view($this->folder.'.create',$params, compact('role', 'bayar', 'provinsi'));
  }
  
  public function store(Request $request)
  {
    $cities = Regency::where('province_id', $request->get('id'))
    ->pluck('name', 'id');
    return response()->json($cities);
  }
  public function show(Request $request)
  {
    $cities = Regency::where('province_id', $request->get('id'))
    ->pluck('name', 'id');

    return response()->json($cities);
  }
  public function edit($id)
  {
    $params=[
      'title' => $this->titlePage3
    ];
    $data = Cabang::find($id);
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.edit',$params, compact('data', 'role', 'bayar'));
  }

  public function update(Request $request, $id)
  {
    $this->validate($request,[
      'nama_cabang'  => 'required'
    ]);
    Cabang::find($id)->update([
      'nama_cabang'  => $request->nama_cabang
    ]);
    return redirect($this->rdr)->with('success', 'Data Berhasil di ubah');
  }

  public function destroy($id)
  {
    $data   = Cabang::find($id);
    $data->delete();
    return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');

  }
}
