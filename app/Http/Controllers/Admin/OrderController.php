<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Payment;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Cabang;
use App\Model\Terjual;
use App\Mail\SendMail;
use DB;
use Alert;
use Carbon\Carbon;


class OrderController extends Controller
{
    protected $folder = 'backend.admin.order';
    protected $rdr = '/admin/order';
    private $titlePage = 'Order Pesanan';
    private $titlePage2 = 'Tambah Pesanan';
    private $titlePage3 = 'Report Laba';

    public function index()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $query = request()->lokasi;
        $data = Order::whereBetween('created_at', [$start, $end])
            ->where('lokasi', 'LIKE', '%' . $query . '%')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $pro = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();
        return view($this->folder . '.index', $params, compact('data', 'pro', 'role', 'bayar', 'jenis_penjualan'));
    }
    public function filter(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $query = request()->lokasi;
        $data = Order::whereBetween('created_at', [$start, $end])
            ->where('lokasi', 'LIKE', '%' . $query . '%')
            ->where('id_team', auth()->user()->id_team)
            ->where('jenis_penjualan', $request->jenis_penjualan)
            ->get();
        $pro = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();
        return view($this->folder . '.index', $params, compact('data', 'pro', 'role', 'bayar', 'jenis_penjualan'));
    }

    public function create()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = DB::table('payments')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $ord = OrderDetail::all();
        $cabang = DB::table('cabang')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $pro = DB::table('products')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $grosir = DB::table('products')
            ->join('harga_grosir', 'products.id', 'harga_grosir.products_id')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();
        return view($this->folder . '.create', $params, compact('data', 'ord', 'pro', 'role', 'bayar', 'cabang', 'grosir', 'jenis_penjualan'));
    }

    public function store(Request $request)
    {
        $count = count($request->hasil);
        for ($i = 0; $i < $count; $i++) {
            if ($request->hasil[$i] < 0) {
                return redirect($this->rdr)->with('warning', 'Stock Anda Tidak Cukup');
            } else {
                $product = Product::find($request->pesanan);
                $count = count($request->pesanan);
                $nama = $request->nama;
                $harga = $request->harga;
                $harga_beli = $request->harga_beli;
                $qty = $request->jumlah;
                $note = $request->note;
                $stock = $request->hasil;
                $sub = $request->subtotal;
                $disc = $request->discount;
                $diskon = $request->disc;
                $total = $request->total;
                $lokasi = $request->lokasi;
                $notelp = $request->notelp;
                $keperluan = $request->keperluan;
                $user_id = $request->user_id;
                $request->merge([
                    'created_by' => auth()->user()->id,
                ]);
                $order = $request->only(
                    'name', 'notelp', 'table_number', 'payment_id',
                    'email', 'lokasi', 'keperluan', 'created_by', 'id_team', 'disc',
                    'jenis_penjualan'
                );
                DB::table('pembeli')
                    ->insert([
                        'name' => $request->name,
                        'notelp' => $request->notelp,
                        'cabang' => $request->lokasi,
                        'id_team' => auth()->user()->id_team,
                        'created_at' => now(),
                    ]);

                $data_pembeli = DB::table('databasepembeli')->get();
                foreach ($data_pembeli as $pembeli) {
                    if ($pembeli->number == $request->notelp) {
                        DB::table('databasepembeli')
                            ->where('number', '=', $request->notelp)
                            ->delete();
                    }
                }
                DB::table('databasepembeli')
                    ->insert([
                        'name' => $request->name,
                        'number' => $request->notelp,
                        'text' => 'from_order',
                        'created_at' => now(),
                    ]);
                $orderData = Order::create($order);
                // require data Order if grosir
                for ($i = 0; $i < $count; $i++) {
                    $grosir_awal = DB::table('harga_grosir')->where('products_id', $request->pesanan[$i])->min('qty');
                    $grosir = DB::table('harga_grosir')->where('products_id', $request->pesanan[$i])->get();
                    $grosir_kedua = DB::table('harga_grosir')->where('products_id', $request->pesanan[$i])->max('qty');
                    if ($qty[$i] < $grosir_awal && $qty[$i] < $grosir_kedua) {
                        $request->merge([
                            'order_id' => $orderData->id,
                            'product_name' => $nama[$i],
                            'product_price' => $harga[$i],
                            'purchase_price' => $harga_beli[$i],
                            'quantity' => $qty[$i],
                            'note' => $note[$i],
                            'subtotal' => $sub[$i],
                        ]);
                        $orderDetail = $request->only('order_id', 'product_name', 'purchase_price', 'product_price', 'quantity', 'note', 'subtotal');
                        OrderDetail::create($orderDetail);
                        DB::table('products')
                            ->where('id', $request->id[$i])
                            ->update([
                                'stock' => $stock[$i]
                            ]);
                        if (empty($disc)) {
                            Order::find($orderData->id)->update([
                                'total' => $total,
                            ]);
                        } else {
                            Order::find($orderData->id)->update([
                                'discount' => $disc,
                                'total' => $total,
                            ]);
                        }
                    } else {
                        $request->merge([
                            'order_id' => $orderData->id,
                            'product_name' => $nama[$i],
                            'product_price' => $harga[$i],
                            'purchase_price' => $harga_beli[$i],
                            'quantity' => $qty[$i],
                            'note' => $note[$i],
                            'subtotal' => $sub[$i],
                        ]);
                        $orderDetail = $request->only('order_id', 'product_name', 'purchase_price', 'product_price', 'quantity', 'note', 'subtotal');
                        OrderDetail::create($orderDetail);
                        DB::table('products')
                            ->where('id', $request->id[$i])
                            ->update([
                                'stock' => $stock[$i]
                            ]);
                        if (empty($disc)) {
                            Order::find($orderData->id)->update([
                                'total' => $total,
                            ]);
                        } else {
                            Order::find($orderData->id)->update([
                                'discount' => $disc,
                                'total' => $total,
                            ]);
                        }
                    }
                    foreach ($grosir as $g) {
                        if ($grosir_kedua == $g->qty && $grosir_kedua <= $qty[$i]) {
                            $request->merge([
                                'order_id' => $orderData->id,
                                'product_name' => $nama[$i],
                                'product_price' => $g->harga,
                                'purchase_price' => $harga_beli[$i],
                                'quantity' => $qty[$i],
                                'note' => $note[$i],
                                'subtotal' => $g->harga * $qty[$i],
                            ]);
                            $orderDetail = $request->only('order_id', 'product_name', 'purchase_price', 'product_price', 'quantity', 'note', 'subtotal');
                            OrderDetail::create($orderDetail);
                            DB::table('products')
                                ->where('id', $request->id[$i])
                                ->update([
                                    'stock' => $stock[$i]
                                ]);

                            $sub_total_grosir = ($g->harga * $qty[$i]);
                            $total_grosir = $sub_total_grosir + $sub_total_grosir;
                            if (empty($disc)) {
                                Order::find($orderData->id)->update([
                                    'total' => $total_grosir,
                                ]);
                            } else {
                                Order::find($orderData->id)->update([
                                    'discount' => $disc,
                                    'total' => $total_grosir,
                                ]);
                            }
                        } elseif ($grosir_awal <= $qty[$i] && $grosir_awal == $g->qty && $grosir_kedua >= $qty[$i]) {
                            $request->merge([
                                'order_id' => $orderData->id,
                                'product_name' => $nama[$i],
                                'product_price' => $g->harga,
                                'purchase_price' => $harga_beli[$i],
                                'quantity' => $qty[$i],
                                'note' => $note[$i],
                                'subtotal' => $g->harga * $qty[$i],
                            ]);
                            $orderDetail = $request->only('order_id', 'product_name', 'purchase_price', 'product_price', 'quantity', 'note', 'subtotal');
                            OrderDetail::create($orderDetail);
                            DB::table('products')
                                ->where('id', $request->id[$i])
                                ->update([
                                    'stock' => $stock[$i]
                                ]);

                            $sub_total_grosir = ($g->harga * $qty[$i]);
                            $total_grosir = $sub_total_grosir + $sub_total_grosir;
                            if (empty($disc)) {
                                Order::find($orderData->id)->update([
                                    'total' => $total_grosir,
                                ]);
                            } else {
                                Order::find($orderData->id)->update([
                                    'discount' => $disc,
                                    'total' => $total_grosir,
                                ]);
                            }
                        }


                    }
                }

                // request barang Terjual
                for ($i = 0; $i < $count; $i++) {
                    $request->merge([
                        'name' => $nama[$i],
                        'terjual' => $qty[$i],
                        'cabang' => $lokasi,
                        'keperluan' => 'Penjualan',
                        'product_id' => $request->pesanan[$i],
                        'id_team' => auth()->user()->id_team,
                        'order_id' => $orderData->id,
                    ]);
                    $terjual = $request->only('order_id', 'name', 'cabang', 'terjual', 'keperluan', 'product_id', 'id_team');
                    Terjual::create($terjual);

                }

                return redirect($this->rdr)->with('success', 'Data berhasil ditambahkan');
            }
        }

    }

    public function show($id)
    {
        $data = Order::find($id);
        $logo = DB::table('cabang')->join('users', 'users.id_team', '=', 'cabang.id_team')
            ->where('users.id', auth()->user()->id)
            ->select([
                'cabang.image',
                'cabang.alamat',
                'cabang.perusahaan'
            ])
            ->first();

        return view($this->folder . '.print', compact('data', 'logo'));
    }


    public function edit($id)
    {
        $pay = Payment::all();
        $data = Order::find($id);
        $pro = Product::all();
        $ord = OrderDetail::find($id);
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.edit', compact('data', 'pay', 'pro', 'ord', 'role', 'bayar'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'table_number' => 'required',
            'pesanan' => 'required',
            'jumlah' => 'required',
            'payment' => 'required',
            'note' => 'required',
            'user' => 'required',
        ]);
        $data1 = Order::where('id', $id)->first();
        $data1->table_number = $request->table_number;
        $data1->payment_id = $request->payment;
        $data1->created_by = $request->user;
        $data1->save();

        $data2 = OrderDetail::where('id', $id)->first();
        $data2->order_id = $data1->id;
        $data2->product_id = $request->pesanan;
        $data2->quantity = $request->jumlah;
        $data2->note = $request->note;
        $data2->save();

        $dat = Order::find($data1->id);
        $dat->total = $data2->product->price * $request->jumlah;
        $dat->save();
        return redirect($this->rdr)->with('success', 'Data berhasil di ubah');
    }

    public function destroy($id)
    {
        $data = Order::find($id);
        $data->delete();

        DB::table('terjual')
            ->where('order_id', '=', $id)
            ->delete();

        return redirect($this->rdr)->with('success', 'Data berhasil dihapus');
    }

    public function sendmail($id)
    {
        $order = Order::find($id);
        Mail::to($order)->send(new SendMail($id));
        return redirect($this->rdr)
            ->with('success', 'Email telah terkirim');
    }

}
