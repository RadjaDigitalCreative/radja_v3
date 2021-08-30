<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Waweb;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WaImport;
use App\Imports\DatabaseImport;
use App\Jobs\ImportJob;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DB;

class WaWebController extends Controller
{
    public function index()
    {
        $data   = Waweb::where('id_team', auth()->user()->id_team)->get();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view('backend.waweb.index', compact( 'role', 'bayar', 'data'));
    }
    
    public function create()
    {
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view('backend.waweb.create', compact( 'role', 'bayar'));
    }

    public function store(Request $request)
    {
        DB::table('waweb')
        ->insert([
            'name' => $request->nama,
            'number' => $request->number,
            'text' => $request->text,
            'id_team' => auth()->user()->id_team,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/admin/waweb')->with('success', 'Data Wa Berhasil dimasukkan');
    }

    public function show(Waweb $waweb)
    {
        //
    }

    public function edit(Waweb $waweb)
    {
        //
    }

    public function update(Request $request, Waweb $waweb)
    {
        //
    }

    public function destroy($id)
    {
        $data = Waweb::find($id);
        $data->delete();
        return redirect('/admin/waweb')->with('success', 'Data berhasil di hapus');
    }
    public function import(Request $request)
    {
        try {
            Excel::import(new WaImport,request()->file('file'));
            Excel::import(new DatabaseImport,request()->file('file'));
        } catch (\Exception $exception) {
            return back()->with('warning', 'Import Excel/CSV Gagal. Format file Anda Salah!!!');
        }
        return back()->with('success', 'Import CSV Suskses!!!');
    }
    public function send(Request $request)
    {
        $url = $request->send;
        $itung = count($request->send);

        for ($i=0; $i < $itung; $i++) { 
            echo "<script>window.open('".$url[$i]."', '_blank')</script>";
        }
        // return redirect('admin/waweb')->with('success', 'Data Berhasil di tambahkan');
    }
    public function status(Request $request)
    {   
        $id = $request->id;
        DB::table('waweb')
        ->where('id', '=', $id)
        ->update([
            'status' => 1
        ]); 
        DB::table('database')
        ->insert([
            'name' => $request->name,
            'number' => $request->number,
            'text' => $request->text,
            'created_at' => date('Y-m-d', strtotime(now())),
            'updated_at' => date('Y-m-d', strtotime(now())),
        ]);
        $url =  "https://wa.me/".$request->number."/?text=".$request->text;

        echo "<script>window.open('".$url."', '_blank')</script>";

        $data   = Waweb::all();
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();


        return view('backend.waweb.index', compact( 'role', 'bayar', 'data'));
    }
    public function delete()
    {
        DB::table('waweb')->delete();
        return redirect('/admin/waweb')->with('success', 'Semua Data berhasil di hapus');
    }
}
