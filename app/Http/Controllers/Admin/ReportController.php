<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\User;
use App\Exports\OrdersExport;
use App\Imports\PembeliImport;
use App\Exports\PembeliExport;
use App\Jobs\ImportJob;
use DB;
use PDF;
use Alert;
use Carbon\Carbon;


class ReportController extends Controller
{
    private $titlePage = 'Report Pesanan';

    public function index(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $yr = $request->get('tahun');
        $mt = $request->get('bulan');
        $us = $request->get('kasir');

        $users = User::all();
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

        $terjual = DB::table('terjual')
            ->leftJoin('products', function ($join) {
                $join->on('products.name', '=', 'terjual.name');
            })
            ->where('terjual.id_team', auth()->user()->id_team)
            ->groupBy('terjual.terjual')
            ->get();
        $link = DB::table('terjual')
            ->where('terjual.id_team', auth()->user()->id_team)
            ->groupBy('terjual.cabang')
            ->get();
        $total = DB::table('orders')->where('payment_id', '<', 3)->sum('total');
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view('backend.admin.report.index', $params, compact('data', 'link', 'terjual', 'users', 'total', 'role', 'bayar', 'jenis_penjualan'));
    }
    public function filter(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $yr = $request->get('tahun');
        $mt = $request->get('bulan');
        $us = $request->get('kasir');

        $users = User::all();
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

        $terjual = DB::table('terjual')
            ->leftJoin('products', function ($join) {
                $join->on('products.name', '=', 'terjual.name');
            })
            ->where('terjual.id_team', auth()->user()->id_team)
            ->groupBy('terjual.terjual')
            ->get();
        $link = DB::table('terjual')
            ->where('terjual.id_team', auth()->user()->id_team)
            ->groupBy('terjual.cabang')
            ->get();
        $total = DB::table('orders')->where('payment_id', '<', 3)->sum('total');
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jenis_penjualan = DB::table('jenis_penjualan')->where('id_team', auth()->user()->id_team)->get();

        return view('backend.admin.report.index', $params, compact('data', 'link', 'terjual', 'users', 'total', 'role', 'bayar','jenis_penjualan'));
    }
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
        $yr = $request->get('tahun');
        $mt = $request->get('bulan');
        $us = $request->get('kasir');

        $users = User::all();
        $data = new Order();
        if ($yr) {
            $data = $data->whereYear('created_at', $yr);
        }
        if ($mt) {
            $data = $data->whereMonth('created_at', $mt);
        }
        if ($us) {
            $data = $data->where('created_by', $us);
        }
        $data = $data->get();
        $htg = count($data);
        if ($htg > 0) {
            $pdf = PDF::loadView('admin.report.pdf', $data, compact('data'));
            return $pdf->download('report.pdf');
        } else {
            return redirect()->back()->with('failed', 'Data tidak ada');
        }
    }

    public function excel(Request $request)
    {
        $yr = $request->get('tahun');
        $mt = $request->get('bulan');
        $us = $request->get('kasir');

        $users = User::all();
        $data = new Order();
        if ($yr) {
            $data = $data->whereYear('created_at', $yr);
        }
        if ($mt) {
            $data = $data->whereMonth('created_at', $mt);
        }
        if ($us) {
            $data = $data->where('created_by', $us);
        }
        $data = $data->get();
        $htg = count($data);
        if ($htg > 0) {
            return Excel::download(new OrdersExport($yr, $mt, $us), 'report.xlsx');
        } else {
            return redirect()->back()->with('failed', 'Data tidak ada');
        }
    }

    public function pembeli()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $query = request()->lokasi;
        $data = DB::table('pembeli')
            ->where('cabang', 'LIKE', '%' . $query . '%')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        return view('backend.admin.report.pembeli', $params, compact('data', 'role', 'bayar'));
    }

    public function import(Request $request)
    {
        Excel::import(new PembeliImport, request()->file('file'));
        return back()->with('success', 'Import Excel/CSV Suskses!!!');

    }

    public function delete()
    {
        DB::table('pembeli')->delete();
        return redirect('/admin/report/pembeli')->with('success', 'Semua Data berhasil di hapus');
    }
}
