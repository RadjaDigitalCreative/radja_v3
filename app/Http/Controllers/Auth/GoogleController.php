<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use DB;
use App\Model\Cabang;
use App\Model\Provinsi;
use App\Model\Regency;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function verifymenu()
    {
        $provinsi = DB::table('regencies')->get();
        return view('auth.verifymenu', compact('provinsi'));
    }
   public function verifymenu_check($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if ($user->lokasi == NULL ) {
           return redirect('/verifymenu')->with('warning', 'Biodata anda dan perusahaan belum terisi, Silahkan isi biodata berikut!!!');
        }
        else{
            
             return redirect('/admin')->with('success', 'Biodata anda dan perusahaan berhasil sudah terisi');
        }
    
    }
    public function verifymenu_store(Request $request)
    {
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        DB::table('users')->where('id', auth()->user()->id)
        ->update([
            'lokasi' => $request->provinsi,
            'notelp' => $request->notelp,
            'image' => $new_name,
        ]);

        $image_perusahaan = $request->file('image_perusahaan');
        $new_image = rand() . '.' . $image_perusahaan->getClientOriginalExtension();
        $image_perusahaan->move(public_path('images'), $new_image);
        DB::table('cabang')
        ->insert([
            'nama_cabang'  =>  $request->provinsi,
            'perusahaan'  =>  $request->perusahaan,
            'alamat'  =>  $request->alamat,
            'id_team'   => auth()->user()->id_team,
            'image' => $new_image,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
        return redirect('/home')->with('success', 'Biodata anda dan perusahaan berhasil diupdate');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);
                if (auth()->user()->lokasi == NULL) {

                    return redirect('/verifymenu');
                }else{
                    return redirect('/home');
                }


            }else{
                $data = 'Owner';
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'level' => $data,
                    'id_team' => bin2hex(random_bytes(20)),
                    'password' => encrypt('123456dummy')
                ]);
                if ($data == 'Owner') {
                    DB::table('role')
                    ->insert([
                        'user_id'  =>  $newUser['id'],
                        'is_admin' => 1,
                        'is_akses' => 1,
                        'is_supplier' => 1,
                        'is_kategori' => 1,
                        'is_produk' => 1,
                        'is_order' => 1,
                        'is_pay' => 1,
                        'is_report' => 1,
                        'is_kas' => 1,
                        'is_stok' => 1,
                        'is_cabang' => 1,
                        'is_user' => 1
                    ]);
                }else{
                    DB::table('role')
                    ->insert([
                        'user_id'  =>  $newUser['id'],
                    ]); 
                }
                DB::table('role_cabang')
                ->insert([
                    'user_id'  =>  $newUser['id'],
                ]);
                DB::table('agen')
                ->insert([
                    'user_id'  =>  $newUser['id'],
                    'status'  =>  1,
                ]);
                DB::table('role_payment')
                ->insert([
                    'user_id' =>  $newUser['id'],
                    'pay' =>  2,
                    'dibayar' => date('Y-m-d', strtotime('+61 days', strtotime(now())))

                ]);

                Auth::login($newUser);

                return redirect('/home');
            }

        } catch (Exception $e) {
            return redirect('/home')->with('warning', 'Data Tertimpa');
        }
    }
}