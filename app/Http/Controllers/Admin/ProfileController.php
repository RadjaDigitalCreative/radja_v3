<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $titlePage='Profilku';
    private $titlePage2='Edit Profilku';


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
        return view('profile.index', $params, compact('role', 'bayar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function image_store(Request $request)
    {
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        DB::table('users')
        ->where('id', $request->id)
        ->update([
            'image' => $new_name
        ]);
        return redirect('/admin/profile/edit')->with('success', 'Data Pribadi Berhasil Diupdate');

    }
    public function store(Request $request)
    {
        if ($request->password == NULL) {
            DB::table('users')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'notelp' => $request->notelp,
            ]);
        }else{
            DB::table('users')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'notelp' => $request->notelp,
            ]);
        }
        return redirect('/admin/profile/edit')->with('success', 'Data Pribadi Berhasil Diupdate');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function show(Profil $profil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
        return view('profile.edit', $params, compact('role', 'bayar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profil $profil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profil $profil)
    {
        //
    }
}
