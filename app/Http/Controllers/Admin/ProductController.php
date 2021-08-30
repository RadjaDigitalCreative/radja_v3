<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Restock;
use App\Model\Category;
use App\Model\Cabang;
use App\Exports\OrdersExport;
use App\Jobs\ImportJob;
use PDF;
use DB;
use Alert;

class ProductController extends Controller
{
    protected $folder = 'backend.admin.produk';
    protected $rdr = 'admin/item';
    protected $rdr2 = 'admin/item/jenis/penjualan';
    private $titlePage = 'Produk';
    private $titlePage2 = 'Tambah Produk';
    private $titlePage3 = 'Update Produk';
    private $titlePage4 = 'Quality Control Produk';
    private $titlePage5 = 'Jenis Penjualan Produk';

    public function jenis_penjualan()
    {
        $params = [
            'title' => $this->titlePage5
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $data = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();
        return view($this->folder . '.jenis_penjualan', $params, compact('role','bayar', 'data'));
    }
    public function jenis_penjualan_create()
    {
        $params = [
            'title' => $this->titlePage5
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.jenis_penjualan_create', $params, compact('role','bayar'));
    }
    public function jenis_penjualan_store(Request $request)
    {
        DB::table('jenis_penjualan')
            ->insert([
                'nama_jenis' => $request->jenis_penjualan,
                'id_team' => auth()->user()->id_team,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        return redirect($this->rdr2)->with('success', 'Data berhasil ditambahkan');

    }
    public function jenis_penjualan_delete($id)
    {
        DB::table('jenis_penjualan')
            ->where('id', $id)
            ->delete();
        return redirect($this->rdr2)->with('success', 'Data berhasil dihapus');
    }
    public function index()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = DB::table('products')
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
                'products.id_team'
            )
            ->get();
        $grosir = DB::table('harga_grosir')
            ->leftJoin('products', function ($join) {
                $join->on('harga_grosir.products_id', '=', 'products.id');
            })
            ->get();
        $terjual = DB::table('terjual')
            ->join('products', function ($join) {
                $join->on('products.name', '=', 'terjual.name')
                    ->on('products.lokasi', '=', 'terjual.cabang');
            })
            ->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.index', $params, compact('data', 'role', 'terjual', 'bayar', 'grosir'));
    }
    
    public function cari(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $query = $request->lokasi;
        $data = Product::where('lokasi', 'LIKE', '%' . $query . '%')
            ->where('name', '!=', 'NAMA PRODUK')->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $grosir = DB::table('harga_grosir')
            ->leftJoin('products', function ($join) {
                $join->on('harga_grosir.products_id', '=', 'products.id');
            })
            ->get();
        $terjual = DB::table('terjual')
            ->join('products', function ($join) {
                $join->on('products.name', '=', 'terjual.name')
                    ->on('products.lokasi', '=', 'terjual.cabang');
            })
            ->get();
        return view($this->folder . '.index', $params, compact('data', 'role', 'bayar','grosir', 'terjual'));
    }


    public function create()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = DB::table('categories')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $stock = Restock::all();
        $cabang = DB::table('cabang')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.create', $params, compact('data', 'role', 'cabang', 'bayar'));
    }

    public function show($id)
    {
    }

    public function store(Request $request)
    {
        if (empty($request->file('image'))) {

            $data = new Product;
            $data->category_id = $request->category;
            $data->name = $request->name;
            $data->lokasi = $request->nama_cabang;
            $data->price = str_replace(".", "", $request->price);
            $data->purchase_price = str_replace(".", "", $request->purchase_price);
            $data->status = $request->status;
            $data->merk = $request->merk;
            $data->stock = $request->stock;
            $data->satuan = $request->satuan;
            $data->stock_minim = $request->stock_minim;
            $data->id_team = auth()->user()->id_team;
            $id = DB::getPdo()->lastInsertId();
            $count = count($request->qty);
            for ($i = 0; $i < $count; $i++) {
                DB::table('harga_grosir')
                    ->insert([
                        'products_id' => $id,
                        'qty' => $request->qty[$i],
                        'harga' => $request->harga[$i],
                    ]);
            }
            DB::table('terjual')
                ->insert([
                    'product_id' => $id,
                    'terjual' => $request->stock,
                    'name' => $request->name,
                    'cabang' => $request->nama_cabang,
                    'keperluan' => 'Stock Awal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            $data->save();
            return redirect($this->rdr)->with('success', 'Data berhasil ditambahkan');

        } elseif ($request->file('image')) {

            $data = new Product;
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);

            $data->category_id = $request->category;
            $data->name = $request->name;
            $data->lokasi = $request->nama_cabang;
            $data->price = str_replace(".", "", $request->price);
            $data->purchase_price = str_replace(".", "", $request->purchase_price);
            $data->status = $request->status;
            $data->merk = $request->merk;
            $data->stock = $request->stock;
            $data->satuan = $request->satuan;
            $data->stock_minim = $request->stock_minim;
            $data->image = $new_name;
            $data->id_team = auth()->user()->id_team;
            $data->save();

            $id = DB::getPdo()->lastInsertId();
            $count = count($request->qty);
            for ($i = 0; $i < $count; $i++) {
                DB::table('harga_grosir')
                    ->insert([
                        'products_id' => $id,
                        'qty' => $request->qty[$i],
                        'harga' => $request->harga[$i],
                    ]);
            }
            DB::table('terjual')
                ->insert([
                    'product_id' => $id,
                    'terjual' => $request->stock,
                    'name' => $request->name,
                    'cabang' => $request->nama_cabang,
                    'keperluan' => 'Stock Awal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            return redirect($this->rdr)->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function edit($id)
    {
        $params = [
            'title' => $this->titlePage3
        ];
        $cat = Category::all();
        $data = Product::find($id);
        $cabang = Cabang::all();
        $grosir = DB::table('products')
            ->join('harga_grosir', 'products.id', 'harga_grosir.products_id')
            ->where('products.id', $id)
            ->select('harga_grosir.*')
            ->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.edit', $params, compact('data', 'cat', 'role', 'cabang', 'bayar', 'grosir'));
    }

    public function update(Request $request, $id)
    {
        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if ($image != '') {
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
        }

        DB::table('terjual')
            ->where('product_id', '=', $id)
            ->delete();
        DB::table('terjual')
            ->insert([
                'product_id' => $id,
                'terjual' => $request->stock,
                'name' => $request->name,
                'cabang' => $request->nama_cabang,
                'keperluan' => 'Stock Awal',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        Product::find($id)->update(
            [
                'category_id' => $request->category,
                'name' => $request->name,
                'merk' => $request->merk,
                'lokasi' => $request->nama_cabang,
                'purchase_price' => str_replace(".", "", $request->purchase_price),
                'price' => str_replace(".", "", $request->price),
                'status' => $request->status,
                'satuan' => $request->satuan,
                'stock' => $request->stock,
                'stock_minim' => $request->stock_minim,
                'image' => $image_name,

            ]
        );
        // $id2 = DB::getPdo()->lastInsertId();
        $count = count($request->qty);
        for ($i = 0; $i < $count; $i++) {
            DB::table('harga_grosir')
                ->insert([
                    'products_id' => $id,
                    'qty' => $request->qty[$i],
                    'harga' => $request->harga[$i],
                ]);
        }
        return redirect($this->rdr)->with('success', 'Data berhasil di ubah');
    }

    public function destroy($id)
    {
        $data = Product::find($id);
        DB::table('harga_grosir')
            ->where('products_id', '=', $id)
            ->delete();
        $data->delete();
        return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');
    }

    public function deleteAll(Request $request)
    {
        $id = $request->id;
        DB::table("products")->whereIn('id', explode(",", $id))->delete();
        return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');
    }

    public function multiplerecordsdelete(Request $req)
    {
        $id = $req->id;
        if ($id == NULL) {
            return redirect()->back()->with('errors', 'Gagal Menghapus');
        } else {
            foreach ($id as $ke) {
                DB::table('products')->where('id', $ke)->delete();
            }
        }
        return redirect()->back()->with('success', 'Data berhasil di Hapus');
    }

    // base print
    public function download(Request $request)
    {
        $tipe = $request->get('tipe');
        if ($tipe == null) {
            return redirect()->back()->with('failed', 'Data tidak ada');
        } elseif ($tipe == 1) {
            return $this->pdf($request);
        } else {
            return $this->excel($request);
        }
    }

    public function pdf(Request $request)
    {
        $product = Product::all();
        $pdf = PDF::loadView('admin.product.item.pdf', compact('product'));
        return $pdf->download('item.pdf');

    }

    // request barang
    public function barang_masuk()
    {
        $data = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        return view($this->folder . '.index', compact('data', 'role'));
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductImport, request()->file('file'));
        } catch (\Exception $exception) {
            return back()->with('warning', 'Import Excel/CSV Gagal. Format file Anda Salah!!!');
        }
        return back()->with('success', 'Import Excel/CSV Suskses!!!');
    }

    public function harga_grosir_delete($id)
    {
        $pro = DB::table('harga_grosir')
            ->where('id', $id)
            ->first();
        DB::table('harga_grosir')
            ->where('id', $id)
            ->delete();

        return redirect('admin/item/' . $pro->products_id . '/edit')->with('success', 'Harga Grosir Berhasil di Hapus');
    }
}
