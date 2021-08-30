<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CutiController extends Controller
{
    private $titlePage='Tabel Cuti Pegawai';
    private $titlePage2='Ajukan Cuti';

    public function index()
    {
        $params=[
            'title' => $this->titlePage
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $user = DB::table('users')->where('id_team', auth()->user()->id_team)->get();
        $cuti = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')

        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)
        ->groupBy('users.id')
        ->get();
        $tanggal = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')
        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)

        ->get();

        $hitung_tanggal = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')
        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)
        ->count();


        return view('backend.admin.cuti.index',$params,  compact('user', 'cuti', 'role', 'bayar', 'tanggal', 'hitung_tanggal'));
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
        $user = DB::table('users')->where('id_team', auth()->user()->id_team)->get();
        $cuti = DB::table('setting_cuti')->join('users', 'setting_cuti.user_id', 'users.id')
        ->where('id_team', auth()->user()->id_team)
        ->select('setting_cuti.*', 'users.name')
        ->get();

        return view('backend.admin.cuti.create',$params, compact('user', 'cuti' , 'role', 'bayar'));
    }

    public function create_ajukan()
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
        $user = DB::table('users')->where('id_team', auth()->user()->id_team)->get();
        $cuti = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')

        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)
        ->groupBy('users.id')
        ->get();
        $tanggal = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')
        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)

        ->get();

        $hitung_tanggal = DB::table('gaji_cuti')
        ->join('users', 'gaji_cuti.user_id', 'users.id')
        ->select('gaji_cuti.*', 'users.name')
        ->where('id_team', auth()->user()->id_team)
        ->count();

        return view('backend.admin.cuti.ajukan',$params, compact('user', 'cuti' , 'role', 'bayar', 'tanggal', 'hitung_tanggal'));

    }
    public function store(Request $request)
    {
        DB::table('setting_cuti')
        ->insert([
            'user_id' => $request->user_id,
            'hari' => $request->hari,
            'gaji' => $request->nominal,
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        return redirect('/admin/pegawai/cuti')->with('success', 'Data Cuti Pegawai Berhasil Disimpan!');

    }
    public function store_ajukan(Request $request)
    {
        $user = DB::table('setting_cuti')
        ->where('user_id', $request->user_id)
        ->first();
        $count  = count($request->tgl_mulai_cuti);
        if ($user === NULL) {
            return redirect('/admin/pegawai/cuti/create/ajukan')->with('warning', 'Anda belum bisa mengambil cuti');

        }elseif($count >= ($user->hari + 1)){
            return redirect('/admin/pegawai/cuti/create/ajukan')->with('warning', 'Ajukan cuti melebihi batas yang ditentukan');

        }else{

            $random = bin2hex(random_bytes(20));
            for ($i=0; $i < $count; $i++) { 
                $data = DB::table('gaji_cuti')
                ->insert([
                    'user_id' => $request->user_id,
                    'tgl_mulai_cuti' => $request->tgl_mulai_cuti[$i],
                    'hari' => $count,
                    'keperluan' => $request->keperluan,
                    'gaji' => $user->gaji,
                    'id_cuti' => $random,
                    'created_at' =>now(),
                    'updated_at' =>now(),
                ]);
            }
            return redirect('/admin/pegawai/cuti/create')->with('success', 'Pengajuan Cuti, tunggu review dari atasan!');
        }

    }
    public function approve($id)
    {
        DB::table('gaji_cuti')
        ->where('id_cuti', $id)
        ->update([
            'status' => 1
        ]);
        return redirect('/admin/pegawai/cuti')->with('success', 'Data Cuti berhasil diapprove!');
    }
    public function unapprove($id)
    {
        DB::table('gaji_cuti')
        ->where('id_cuti', $id)
        ->update([
            'status' => 0
        ]);
        return redirect('/admin/pegawai/cuti')->with('success', 'Data Cuti berhasil diunapprove!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function delete($id)
    {
        DB::table('gaji_cuti')
        ->where('id', $id)
        ->delete();
        return redirect('/cuti/create')->with('success', 'Data Cuti berhasil dihapus!');
    }
}
