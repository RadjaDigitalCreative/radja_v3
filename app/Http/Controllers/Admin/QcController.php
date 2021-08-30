<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use QrCode;
class QcController extends Controller
{
  private $titlePage='QC Produk';
  private $titlePage2='Atur Pola Print QC Produk';
  protected $folder   = 'backend.admin.produk';
  protected $rdr   = 'admin/item';
  public function index()
  {
    $params=[
      'title' => $this->titlePage
    ];
    $data   = DB::table('products')
    ->where('products.name', '!=', 'NAMA PRODUK')
    ->where('products.id_team', auth()->user()->id_team)
    ->select(
      'products.id',
      'products.category_id',
      'products.name',
      'products.merk',
      'products.price',
      'products.purchase_price',
      'products.status',
      'products.stock',
      'products.stock_minim',
      'products.satuan',
      'products.lokasi',
      'products.image',
      'products.qc_status',
      'products.qc',
      'products.id_team',
      'products.supplier',
      'products.tgl_buat_produk',
      'products.tgl_exp_produk',
    )
    ->get();
    $grosir = DB::table('harga_grosir')
    ->leftJoin('products', function($join){
      $join->on('harga_grosir.products_id', '=', 'products.id');
    })
    ->get();
    $terjual = DB::table('terjual')
    ->join('products', function($join){
      $join->on('products.name', '=', 'terjual.name')
      ->on('products.lokasi', '=', 'terjual.cabang');
    })
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    $supplier = DB::table('supplier')->where('id_team', auth()->user()->id_team)->get();
    return view($this->folder.'.qc',$params, compact('data', 'role', 'terjual', 'bayar', 'grosir', 'supplier'));
  }

  public function store(Request $request)
  {
    DB::table('products')
    ->where('id', $request->id)
    ->update([
      'qc'  =>  bin2hex(random_bytes(20)),
      'supplier'  =>  $request->supplier,
      'tgl_buat_produk'  =>  $request->tgl_produk,
      'tgl_exp_produk'  =>  $request->exp_produk,
      'qc_status' => $request->qc_status
    ]);
    return redirect('admin/qc/qc')->with('success', 'Quality Control Produk Berhasil Ditambahkan');
  }

  public function show($id)
  {
    $params=[
      'title' => $this->titlePage2
    ];
    $data = DB::table('products')
    ->where('id', $id)
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.qcView',$params, compact('data', 'role','bayar'));

  }
  public function qc_store(Request $request, $id)
  {
    DB::table('products')
    ->where('id', $id)
    ->update([
      'qc_print'  =>  $request->qc_print,
      'qc_copy' => $request->qc_copy
    ]);
    return redirect('admin/qc/qc/view/'.$id)->with('success', 'Quality Control Produk Berhasil Ditambahkan');
  }
  public function qc_print($id)
  {
    $data = DB::table('products')
    ->where('id', $id)
    ->get();
    return view($this->folder.'.qcPrint', compact('data'));
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
