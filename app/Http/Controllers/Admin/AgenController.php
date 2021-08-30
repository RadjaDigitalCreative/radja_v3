<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Agen;
use Illuminate\Http\Request;
use DB;
use Adrianorosa\GeoLocation\GeoLocation;
use Stevebauman\Location\Facades\Location;
use Alert;


class AgenController extends Controller
{
    protected $folder = 'backend.admin.agen';
    protected $rdr = '/admin/agen';
    private $titlePage='Member Agen Distributor';
    private $titlePage2='Tambah Kode Agen Distributor';
    private $titlePage3='Update Agen';
    private $titlePage4='List Bonus';
    private $titlePage5='Edit Harga Bonus';
    private $titlePage6='Copy Referal Anda';

    public function agen_dua($id)
    {
        $params=[
            'title' => $this->titlePage6
        ];
        $role  = DB::table('users')
        ->where('id', $id)
        ->where('agen', 2)
        ->update([
            'referal2' => rand(),
        ]);
        return redirect('/admin/agen')->with('success', 'Generate Referal Agen Kedua Berhasil');

    }
    public function agen_tiga($id)
    {
        $params=[
            'title' => $this->titlePage6
        ];
        $role  = DB::table('users')
        ->where('id', $id)
        ->where('agen', 3)
        ->update([
            'referal3' => rand(),
        ]);
        return redirect('/admin/agen')->with('success', 'Generate Referal Agen Kedua Berhasil');

    }
    public function referal(Request $request)
    {
        $params=[
            'title' => $this->titlePage6
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        return view($this->folder.'.referal',$params, compact('role', 'bayar'));
    }
    public function upah(Request $request)
    {
        $user = DB::table('role_upah')
        ->where('user_id', $request->user_id)
        ->first();
        if ($user === null) {
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen,
                'user_id' => $request->user_id,
                'agen_status' => 2,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen2,
                'user_id' => $request->user_id,
                'agen_status' => 3,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }else{
            DB::table('role_upah')
            ->where('user_id', $request->user_id)
            ->delete();
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen,
                'user_id' => $request->user_id,
                'agen_status' => 2,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen2,
                'user_id' => $request->user_id,
                'agen_status' => 3,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }
        return redirect('/admin/agen/bonus')->with('success', 'Upah Berhasil dimasukkan');
    }
    public function upah2(Request $request)
    {
        $user = DB::table('role_upah')
        ->where('user_id', $request->user_id)
        ->first();
        if ($user === null) {
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen2,
                'user_id' => $request->user_id,
                'agen_status' => 3,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }else{
            DB::table('role_upah')
            ->where('user_id', $request->user_id)
            ->delete();
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen2,
                'user_id' => $request->user_id,
                'agen_status' => 3,
                'created_at' => now(),
            ]);
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }
        return redirect('/admin/agen/bonus2')->with('success', 'Upah Berhasil dimasukkan');
    }
    public function upah3(Request $request)
    {
        $user = DB::table('role_upah')
        ->where('user_id', $request->user_id)
        ->first();
        if ($user === null) {
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }else{
            DB::table('role_upah')
            ->where('user_id', $request->user_id)
            ->delete();
            DB::table('role_upah')
            ->insert([
                'persen' => $request->persen3,
                'user_id' => $request->user_id,
                'agen_status' => 4,
                'created_at' => now(),
            ]);
        }
        return redirect('/admin/agen/bonus3')->with('success', 'Upah Berhasil dimasukkan');
    }
    public function bonus()
    {
        $params=[
            'title' => $this->titlePage5
        ];
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal')
        ->get();
        $upah = DB::table('role_upah') ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->groupBy('referal')
        ->get();
        return view($this->folder.'.bonus',$params, compact('role', 'bayar', 'data', 'link', 'upah'));

    }
    public function bonus2()
    {
        $params=[
            'title' => $this->titlePage5
        ];
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal','users.referal2')
        ->get();
        $upah = DB::table('role_upah') ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->where('agen', 2)
        ->groupBy('referal2')
        ->get();
        return view($this->folder.'.bonus2',$params, compact('role', 'bayar', 'data', 'link', 'upah'));

    }
    public function bonus3()
    {
        $params=[
            'title' => $this->titlePage5
        ];
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal','users.referal2','users.referal3')
        ->get();
        $upah = DB::table('role_upah') ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->where('agen', 3)
        ->groupBy('referal3')
        ->get();
        return view($this->folder.'.bonus3',$params, compact('role', 'bayar', 'data', 'link', 'upah'));

    }
    public function bonus_list()
    {
        $params=[
            'title' => $this->titlePage4
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal', 'users.created_at')
        ->groupBy('referal')
        ->get();

        $link = DB::table("users")
        ->select(DB::raw("COUNT(referal) as total, referal"))
        ->where('agen', 2)
        ->groupBy('referal')
        ->get();

        $view = DB::table("users")
        ->where('agen', 2)
        ->get();

        return view($this->folder.'.list',$params, compact('role', 'bayar', 'data', 'link', 'view'));
    }
    public function bonus_list2()
    {
        $params=[
            'title' => $this->titlePage4
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal','users.referal2', 'users.created_at')
        ->groupBy('referal2')
        ->get();

        $link = DB::table("users")
        ->select(DB::raw("COUNT(referal) as total, referal2, referal"))
        ->where('agen', 3)
        ->groupBy('referal2')
        ->get();
        $ref = DB::table("users")
        ->select(DB::raw("COUNT(referal) as total, referal, agen, name"))
        ->where('agen', 1)
        ->groupBy('referal')
        ->get();

        $view = DB::table("users")
        ->where('agen', 3)
        ->get();

        return view($this->folder.'.list2',$params, compact('role', 'bayar', 'data', 'link', 'view', 'ref'));
    }
    public function bonus_list3()
    {
        $params=[
            'title' => $this->titlePage4
        ];
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal','users.referal2' ,'users.referal3', 'users.created_at')
        ->groupBy('referal3')
        ->get();

        $link = DB::table("users")
        ->select(DB::raw("COUNT(referal) as total, referal2, referal3, referal"))
        ->where('agen', 3)
        ->groupBy('referal3')
        ->get();
        $ref = DB::table("users")
        ->select(DB::raw("COUNT(referal) as total, referal, referal2, agen, name"))
        ->where('agen', 2)
        ->groupBy('referal2')
        ->get();

        $view = DB::table("users")
        ->where('agen', 4)
        ->get();

        return view($this->folder.'.list3',$params, compact('role', 'bayar', 'data', 'link', 'view', 'ref'));
    }
    public function index(Request $request)
    {
        $params=[
            'title' => $this->titlePage
        ];

        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal', 'users.referal2')
        ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')
        ->groupBy('referal')
        ->get();
        return view($this->folder.'.index',$params, compact('role', 'bayar', 'data', 'link'));
    }
    public function index2(Request $request)
    {
        $params=[
            'title' => $this->titlePage
        ];

        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal', 'users.referal2', 'users.referal3')
        ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')

        ->get();
        return view($this->folder.'.index2',$params, compact('role', 'bayar', 'data', 'link'));
    }
    public function index3(Request $request)
    {
        $params=[
            'title' => $this->titlePage
        ];

        $data = DB::table('users')
        ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('users.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.agen', 'users.referal', 'users.referal2', 'users.referal3')
        ->get();

        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $link =  DB::table ('users')

        ->get();
        return view($this->folder.'.index3',$params, compact('role', 'bayar', 'data', 'link'));
    }


    public function create()
    {
        $params=[
            'title' => $this->titlePage2
        ];
        // $data = DB::table('users')
        // ->join('agen')
        $role  = DB::table('role')
        ->join('users', 'role.user_id', '=', 'users.id')
        ->get();
        $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->get();
        $data = DB::table('users')
        ->get();
        return view($this->folder.'.create',$params, compact('role', 'bayar', 'data'));
    }


    public function code_generate(Request $request)
    {
        DB::table('users')
        ->where('id', $request->id)
        ->update([
            'agen' => 1,
            'referal' => rand(),
        ]);
        return redirect('/admin/agen/create')->with('success', 'Kode berhasil dimasukkan');
    }
    public function createAll(Request $request)
    {
        $query = DB::table('users')
        ->count('id')
        ->get();
        $count = count($query);
        $random = rand();
        echo $count;
        // for ($i=0; $i < $count ; $i++) { 
        //     DB::table('users')
        //     ->update([
        //         'referal' => $random[$i]
        //     ]);
        // }
        // return redirect('/admin/agen/create')->with('success', 'Kode berhasil dimasukkan');
    }

    public function code_delete($id)
    {
        DB::table('users')
        ->where('id', $id)
        ->update([
            'referal' => '',
        ]);
        return redirect('/admin/agen/create')->with('success', 'Kode berhasil dihapus');
    }
    public function code_deleteAll()
    {
        DB::table('users')
        ->update([
            'referal' => '',
        ]);
        return redirect('/admin/agen/create')->with('success', 'Semua Kode berhasil dihapus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Agen  $agen
     * @return \Illuminate\Http\Response
     */
    public function show(Agen $agen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Agen  $agen
     * @return \Illuminate\Http\Response
     */
    public function edit(Agen $agen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Agen  $agen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agen $agen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Agen  $agen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agen $agen)
    {
        //
    }
}
