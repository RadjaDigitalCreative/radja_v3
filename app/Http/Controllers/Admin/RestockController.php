<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Payment;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Restock;
use App\Model\Cabang;
use App\Model\Supplier;
use App\Mail\SendMail;
use DB;
use Alert;

class RestockController extends Controller
{
    protected $folder   = 'backend.admin.restock';
    protected $rdr      = '/admin/restock';
    private $titlePage='Restock Barang';

    public function index()
    {
        $params=[
            'title' => $this->titlePage
        ];
        $data  = Payment::all();
        $ord   = OrderDetail::all();
        $pro   = Product::where('id_team', auth()->user()->id_team)->get();
        $cab =  DB::table('products')->groupBy('lokasi')
        ->where('id_team', auth()->user()->id_team)
        ->where('lokasi', '!=', 'LOKASI')
        ->get();
        $total   = DB::table('restock')->sum('subtotal');
        $query = request()->lokasi;
        $stock   = DB::table('restock')
        ->join('products', function($join){
            $join->on('products.name', '=', 'restock.product_name')
            ->on('products.lokasi', '=', 'restock.lokasi');
        })
        ->where('restock.lokasi', 'LIKE', '%' . $query . '%')
        ->where('restock.id_team', auth()->user()->id_team)
        ->select('products.id AS id_produk' ,'restock.id', 'restock.product_name', 'restock.name', 'restock.product_price', 'restock.quantity', 'restock.subtotal', 'restock.status','restock.lokasi', 'restock.quantity', 'products.stock', 'restock.satuan')
        ->get();
        $cabang = Cabang::all();
        $supplier = Supplier::where('id_team', auth()->user()->id_team)->get();
        $total_barang   = DB::table('restock')->where('status','=',0)->count('status');
        $quantity = DB::table('restock')->sum('quantity');
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $role_cabang  = DB::table('role_cabang')
        ->join('users', 'role_cabang.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view($this->folder.'.index',$params, compact('cabang','supplier', 'quantity', 'total_barang', 'total', 'data','ord','pro','stock', 'role', 'role_cabang', 'cab', 'bayar'));
    }
    public function create()
    {
        $data  = Payment::all();
        $ord   = OrderDetail::all();
        $pro   = Product::all();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view($this->folder.'.create', compact('data','ord','pro', 'bayar'));
    }
    public function store(Request $request)
    {
        $product    = Product::find($request->pesanan);
        $count  = count($request->pesanan);
        $nama   = $request->nama;
        $name   = $request->name;
        $harga  = $request->jumlah2;
        $qty    = $request->jumlah;
        $sub    = $request->subtotal;
        $status = $request->status;
        $satuan = $request->satuan;
        $lokasi = $request->lokasi;
        $supplier = $request->supplier;
        $barang = $request->barang;
        $request->merge([
            'created_by'   => auth()->user()->id,
        ]);

        for ($i=0; $i < $count; $i++) {
            $request->merge([
                'product_price' => $harga[$i],
                'quantity'  => $qty[$i],
                'subtotal'  => $sub[$i],
                'status'  => $status[$i],
                'lokasi'  => $lokasi,
                'supplier'  => $supplier,
                'id_team'  => auth()->user()->id_team,
                'product_name'  => $nama[$i],
                'satuan'  => $satuan[$i],
            ]);
            $restock    = $request->only('lokasi', 'supplier', 'name', 'status', 'product_name','product_price','quantity', 'subtotal', 'satuan', 'id_team');
            Restock::create($restock);
        }
        return redirect($this->rdr)->with('success', 'Data berhasil ditambahkan');
    }
    public function store2(Request $request)
    {
        $product    = Product::find($request->pesanan);
        $count  = count($request->barang);
        $nama   = $request->nama;
        $name   = $request->name;
        $harga  = $request->jumlah2;
        $qty    = $request->jumlah;
        $sub    = $request->subtotal;
        $status = $request->status;
        $lokasi = $request->lokasi;
        $satuan = $request->satuan;
        $supplier = $request->supplier;
        $barang = $request->barang;
        $request->merge([
            'created_by'   => auth()->user()->id,
        ]);

        for ($i=0; $i < $count; $i++) {
            $request->merge([
                'product_price' => $harga[$i],
                'quantity'  => $qty[$i],
                'subtotal'  => $sub[$i],
                'status'  => $status[$i],
                'lokasi'  => $lokasi,
                'supplier'  => $supplier,
                'product_name'  => $barang[$i],
                'id_team'  => auth()->user()->id_team,
                'satuan'  => $satuan[$i],

            ]);
            $restock    = $request->only('lokasi', 'supplier', 'name', 'status', 'product_name','product_price','quantity', 'subtotal', 'satuan', 'id_team');
            Restock::create($restock);
        }
        return redirect($this->rdr)->with('success', 'Data berhasil ditambahkan');
    }
    public function show($id)
    {
        $data   = Order::find($id);
        return view($this->folder.'.print', compact('data'));
    }
    public function edit($id)
    {
        $pay    = Payment::all();
        $data   = Order::find($id);
        $pro    = Product::all();
        $ord    = OrderDetail::find($id);
        return view($this->folder.'.edit', compact('data','pay','pro','ord'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'table_number'  => 'required',
            'pesanan'  => 'required',
            'jumlah'  => 'required',
            'payment'  => 'required',
            'note'  => 'required',
            'user'  => 'required',
        ]);
        $data1   = Order::where('id', $id)->first();
        $data1->table_number = $request->table_number;
        $data1->payment_id = $request->payment;
        $data1->created_by = $request->user;
        $data1->save();

        $data2  = OrderDetail::where('id',$id)->first();
        $data2->order_id = $data1->id;
        $data2->product_id = $request->pesanan;
        $data2->quantity = $request->jumlah;
        $data2->note = $request->note;
        $data2->save();

        $dat = Order::find($data1->id);
        $dat->total = $data2->product->price*$request->jumlah;
        $dat->save();
        return redirect($this->rdr)->with('success', 'Data berhasil di ubah');
    }
    
    public function destroy($id)
    {
        $data = Restock::find($id);
        $data->delete();
        return redirect($this->rdr)->with('success', 'Data berhasil dihapus');
    }
    public function sendmail($id)
    {
        $order  = Order::find($id);
        Mail::to($order)->send(new SendMail($id));
        return redirect($this->rdr)
        ->with('success', 'Email telah terkirim');
    }
    public function status(Request $request, $id)
    {
       $input_data = array(
        'status'               =>         $request->status,
    );
       Restock::whereId($id)->update($input_data); 
       return redirect($this->rdr)->with('success', 'Barang berhasil dikonfirmasi');
   }
   public function stock(Request $request, $id)
   { 

    DB::table('products')
    ->join('restock', 'restock.lokasi', '=', 'products.lokasi')
    // ->where('products.lokasi', $request->lokasi)
    // ->where('products.name', $request->barang)
    ->where([
        ['products.lokasi', '=', $request->lokasi],
        ['products.name', '=', $request->barang],
    ])
    ->update([
        'purchase_price' => $request->harga_beli,
        'stock' =>  $request->hasil +$request->stock
    ]); 
    DB::table('terjual')
    ->insert([
        'product_id' => $request->product_id,
        'terjual' => $request->hasil,
        'name' => $request->barang,
        'cabang' => $request->lokasi,
        'keperluan' => 'Barang Masuk',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $input_data = array(
        'status'               =>         $request->status,
    );
    Restock::whereId($id)->update($input_data); 

    return redirect($this->rdr)->with('success', 'Stock Berhasil Ditambah');
}

public function produk(Request $request, $id)
{
    $params=[
        'title' => $this->titlePage
    ];
    $req1   = $request->name;
    $req2   = $request->lokasi;
    $req3   = $request->satuan;
    $data  = Payment::all();
    $ord   = OrderDetail::all();
    $pro   = Product::all();
    $cab =  DB::table('products')->groupBy('lokasi')
    ->where('id_team', auth()->user()->id_team)
    ->where('lokasi', '!=', 'LOKASI')
    ->get();
    $total   = DB::table('restock')->sum('subtotal');
    $stock   = DB::table('restock')
    ->join('products', function($join){
        $join->on('products.name', '=', 'restock.product_name')
        ->on('products.lokasi', '=', 'restock.lokasi');
    })
    ->select('products.id AS id_produk' , 'restock.id', 'restock.product_name', 'restock.name', 'restock.product_price', 'restock.quantity', 'restock.subtotal', 'restock.status','restock.lokasi', 'restock.quantity', 'products.stock')
    ->get();
    $cabang = Cabang::all();
    $supplier = Supplier::where('id_team', auth()->user()->id_team)->get();
    $total_barang   = DB::table('restock')->where('status','=',0)->count('status');
    $quantity = DB::table('restock')->sum('quantity');
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $role_cabang  = DB::table('role_cabang')
    ->join('users', 'role_cabang.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.restock',$params, compact('cabang','supplier', 'quantity', 'total_barang', 'total', 'data','ord','pro','stock', 'role', 'role_cabang', 'cab', 'req1', 'req2', 'req3', 'bayar'));
}
}
