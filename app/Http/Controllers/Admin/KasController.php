<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\User;
use App\Model\Payment;
use App\Model\Product;
use App\Model\Kas;
use App\Model\Credit;
use App\Exports\OrdersExport;
use DB;
use PDF;
use Alert;
use Carbon\Carbon;


class KasController extends Controller
{
    protected $folder = 'backend.admin.kas';
    protected $rdr = '/admin/kas';
    private $titlePage = 'Laporan Kas';
    private $titlePage2 = 'Input Pengeluaran';

    public function index(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = Order::where('id_team', auth()->user()->id_team)
            ->get();
        $credit = Credit::all();
        $user = User::all();
        $total = DB::table('orders')->where('payment_id', '!=', 3)->sum('total');
        $kredit = DB::table('orders')->where('payment_id', 3)->sum('total');
        $hasil = $total - $kredit;
        $order = OrderDetail::all();
        $pay = Payment::all();
        $ord = OrderDetail::all();
        $pro = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view($this->folder . '.index', $params, compact('role', 'data', 'ord', 'pro',
            'total', 'hasil', 'order', 'credit', 'user', 'pay', 'bayar', 'jenis_penjualan'));
    }
    public function filter(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = Order::where('id_team', auth()->user()->id_team)
            ->where('jenis_penjualan', $request->jenis_penjualan)
            ->get();
        $credit = Credit::all();
        $user = User::all();
        $total = DB::table('orders')->where('payment_id', '!=', 3)->sum('total');
        $kredit = DB::table('orders')->where('payment_id', 3)->sum('total');
        $hasil = $total - $kredit;
        $order = OrderDetail::all();
        $pay = Payment::all();
        $ord = OrderDetail::all();
        $pro = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view($this->folder . '.index', $params, compact('role', 'data', 'ord', 'pro',
            'total', 'hasil', 'order', 'credit', 'user', 'pay', 'bayar', 'jenis_penjualan'));
    }
    public function create()
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

        $data = Order::where('id_team', auth()->user()->id_team)
            ->where('lokasi', 'LIKE', '%' . $query . '%')
            ->get();
        $credit = Credit::all();
        $user = User::all();
        $total = DB::table('orders')->where('payment_id', '!=', 3)->sum('total');
        $kredit = DB::table('orders')->where('payment_id', 3)->sum('total');
        $hasil = $total - $kredit;
        $order = OrderDetail::all();
        $pay = Payment::all();
        $ord = OrderDetail::all();
        $pro = Product::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();
        return view($this->folder . '.index', $params, compact('role', 'data', 'ord', 'pro', 'total',
            'hasil', 'order', 'credit', 'user', 'pay', 'bayar', 'jenis_penjualan'));

    }

    public function store(Request $request)
    {
        $total = str_replace(".", "", $request->total);
        $input_data = array(
            'name' => $request->name,
            'table_number' => $request->table_number,
            'total' => $total,
            'payment_id' => 23,
            'created_by' => $request->created_by,
            'note' => $request->note,
            'keperluan' => $request->keperluan,
            'lokasi' => $request->lokasi,
            'id_team' => auth()->user()->id_team,
        );
        Credit::create($input_data);
        return redirect($this->rdr)->with('success', 'Data Berhasil di tambahkan');
    }

    public function show(Kas $kas)
    {
        //
    }

    public function edit(Kas $kas)
    {
        //
    }

    public function update(Request $request, Kas $kas)
    {
        //
    }

    public function destroy($id)
    {
        $data = Kas::find($id);
        $data->delete();
        return redirect($this->rdr)->with('success', 'Data berhasil di Hapus');
    }
}
