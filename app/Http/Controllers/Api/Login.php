<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use Socialite;
use Exception;
use DB;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use DateTime;

class Login extends Controller
{
    use VerifiesEmails;
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    public function google()
    {
        return Socialite::driver('google')->redirect();

    }
    public function status(Request $request)
    {
      $data = DB::table('users')->join('role_payment', 'users.id', '=', 'role_payment.user_id')
      ->where('role_payment.pay', 2)->where('users.id', $request->id)->first();

      $fdate = $data->dibayar;
      $tdate = now();
      $datetime1 = new DateTime($fdate);
      $datetime2 = new DateTime($tdate);
      $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');//now do whatever you like with $days
        return response()->json([
         'user' => $data,
         'masa_pemakaian' => $days,
         'status_code'   => 200,
         'msg'           => 'success',
     ], 200);
    }
    public function user_id($id)
    {
      $data = DB::table('users')->where('id', $id)->get();
      return response()->json([
         'user' => $data,
         'status_code'   => 200,
         'msg'           => 'success',
     ], 200);
  }

  public function rekap_pembayaran()
  {
    $data = DB::table('users')
    ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
    ->select('role_payment.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 
        'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay',
        'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'role_payment.dibayar AS berakhir')
    ->where('role_payment.pay', 2)
    ->get();
    
    return response()->json([
        'rekap_pembayaran' => $data,
        'tgl_saat_ini' => now()->format('Y-m-d H:i:s'),
        'status_code'   => 200,
        'msg'           => 'success',
    ], 200);
}
public function maps(Request $request)
{
  $data = DB::table('users')->where('id', $request->id)
  ->select([
      'id',
      'longitude',
      'langitude',
  ])
  ->get();
  return response()->json([
     'realtime_user' => $data,
     'status_code'   => 200,
     'msg'           => 'success',
 ], 200);
}
public function maps_update(Request $request)
{
  $data = DB::table('users')->where('id', $request->id)
  ->update([
   'id' => $request->id,
   'langitude' => $request->langitude,
   'longitude' => $request->longitude,
]);
  return response()->json([
     'realtime_maps_updated' => $data,
     'status_code'   => 200,
     'msg'           => 'success',
 ], 200);
}
public function login(Request $request)
{
  $credentials = $request->only('email', 'password');
  if (Auth::attempt($credentials)) {
     $data = DB::table('users')
     ->where('email' ,'=' , $credentials)
     ->first();
     if($data->email_verified_at == NULL ){
        return response()->json([
            'username' => 'Silahkan Verifikasi Email',
            'email' => $data->email,
            'status_code'   => 200,
            'msg'           => 'verification',
        ], 200);
    }else{
        return response()->json([
            'username' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }

}else{
 return response()->json([
    'username' => 'tidak ditemukan',
    'status_code'   => 200,
    'msg'           => 'not found',
], 200);
}
}
public function register(Request $request){
   $data = DB::table('users')
   ->where('email' ,'=' , $request->email)
   ->first();
   if($data == FALSE){
      $data = new User;
      $data->name = $request->name;
      $data->email = $request->email;
      $data->agen = 1;
      $data->notelp = $request->notelp;
      $data->level = 'Owner';
      $data->password = Hash::make($request->password);
      $data->id_team = bin2hex(random_bytes(20));
      $data->save();
      if ($data['level'] == 'Owner') {
        DB::table('role')
         ->insert([
            'user_id'  =>  $data['id'],
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
     }
     else{
         DB::table('role')
         ->insert([
            'user_id'  =>  $data['id'],
        ]);
     }
     DB::table('role_cabang')
     ->insert([
         'user_id'  =>  $data['id'],
     ]);
     DB::table('role_payment')
     ->insert([
         'user_id' =>  $data['id'],
         'pay' =>  2,
         'dibayar' => date('Y-m-d', strtotime('+30 days', strtotime(now())))
     ]);
     Auth::login($data,true);
     $data->sendEmailVerificationNotification();
     $success = 'Please confirm yourself by clicking on verify user button sent to you on your email';
     return response(['user'=> $data,  'message' =>  $success, 'status_code'   => 200]);
     }elseif($data == TRUE){
      return response()->json([
         'users' => 'Not Success',
         'status_code'   => 409,
         'msg'           => 'Email Sudah Ada',
     ], 200); 
    }
}
public function verify(Request $request)
{
    auth()->loginUsingId($request->route('id'));

    if ($request->route('id') != $request->user()->getKey()) {
        throw new AuthorizationException;
    }

    if ($request->user()->hasVerifiedEmail()) {

        return response(['message'=>'Already verified']);

            // return redirect($this->redirectPath());
    }

    if ($request->user()->markEmailAsVerified()) {
        event(new Verified($request->user()));
    }

    return response(['message'=>'Successfully verified']);

}

public function user()
{
  $data = DB::table('users')->get();
  return response()->json([
     'users' => $data,
     'status_code'   => 200,
     'msg'           => 'success',
 ], 200);

}
}
