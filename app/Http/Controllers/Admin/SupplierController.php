<?php

namespace App\Http\Controllers\Admin;

use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Alert;
use PDF;

class SupplierController extends Controller
{ 
  private $titlePage='Supplier';
  private $titlePage2='Tambah Supplier';
  private $titlePage3='Update Supplier';

  protected $folder   = 'backend.admin.supplier';
  protected $rdr   = '/admin/supplier';
  public function index()
  {
    $params=[
      'title' => $this->titlePage
    ];
    $data = DB::table('supplier')
    ->where('supplier.id_team', auth()->user()->id_team)
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.index',$params, compact('data', 'role', 'bayar'));
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
    $data   = Supplier::all();
    return view($this->folder.'.create', $params, compact('data', 'role','bayar'));
  }
  public function show($id)
  {

  }
  public function store(Request $request)
  {
    $data   = new Supplier;
    $data->nama  = $request->nama;
    $data->perusahaan  = $request->perusahaan;
    $data->produk  = $request->produk;
    $data->notelp  = $request->notelp;
    $data->id_team  = auth()->user()->id_team;
    $data->save();
return redirect($this->rdr)->with('success', 'Data Berhasil Disimpan!');
}
public function edit($id)
{
  $params=[
    'title' => $this->titlePage3
  ];
  $data = Supplier::find($id);
  $role  = DB::table('role')
  ->join('users', 'role.user_id', '=', 'users.id')
  ->get();
  $bayar = DB::table('users')
  ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
  ->get();
  return view($this->folder.'.edit', $params, compact('data', 'role', 'bayar'));
}
public function update(Request $request, $id)
{
 Supplier::find($id)->update([
  'nama'  => $request->nama,
  'perusahaan'  => $request->perusahaan,
  'produk'  => $request->produk,
  'notelp'  => $request->notelp
]);
 return redirect($this->rdr)->with('success', 'Data Berhasil Di Update');
}
public function destroy($id)
{
  $data   = Supplier::find($id);
  $data->delete();
  return redirect($this->rdr)->with('success', 'Data Berhasil di Hapus');
}

}
