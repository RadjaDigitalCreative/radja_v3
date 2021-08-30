<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use DateTime;

class Harga extends Controller
{
    public function user_status(Request $request)
	{
	     $bayar = DB::table('users')
        ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
        ->where('users.id', $request->id)
        ->first();
        
        $fdate = $bayar->dibayar;
        $tdate = now()->format('Y-m-d');
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime2->diff($datetime1);
        $days = $interval->format('%a');//now do whatever you like with $days
        
        if(now()->format('Y-m-d') > $bayar->dibayar){
            return response()->json([
            'user_notifikasi' => $bayar,
            'masa_pemakaian' => 'tidak_aktif',
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
        }elseif(now()->format('Y-m-d') < $bayar->dibayar){
            return response()->json([
            'status_user' => $bayar,
            'masa_pemakaian' => $days,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
	    }
	}
    public function list_harga()
	{
	    $data = DB::table('role_pay')->get();
		return response()->json([
			'harga_menu' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function bayar(Request $request)
    {
        $image = $request->file('image');
        $image_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);

        $data = DB::table('role_payment')
        ->where('role_payment.user_id', $request->id)
        ->update([
            'role_payment.tgl_bayar'  => now(),
            'role_payment.harga'  => $request->harga,
            'role_payment.bulan'  => $request->bulan,
            'role_payment.image'  => $image_name,
            'role_payment.created_at'  => now(),
            'role_payment.updated_at'  => now(),
        ]);
        return response()->json([
            'bayar' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }
	public function notif_konfirmasi()
	{
		$data = DB::table('users')
    	->join('role_payment', 'role_payment.user_id', '=', 'users.id')
        ->select('role_payment.id', 'users.name' , 'users.notelp', 'users.email' ,'users.level', 'role_payment.image','users.lokasi', 'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at', 'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar')
        ->where('role_payment.pay', 1)
        ->get();

		return response()->json([
			'notif_konfirmasi' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function approve_konfirmasi(Request $request)
    {
    	$harga = DB::table('role_payment')
    	->where('id', $request->id)
    	->first();
    	$bulan = DB::table('role_pay')
    	->where('harga', $harga->harga)
    	->first();
    
    	$waktu = ($bulan->bulan * 30)." days" ;
    	$data = DB::table('role_payment')
    	->where('id', $request->id)
    	->update([
    		'pay' =>2,
    		'dibayar'  => date('Y-m-d', strtotime($waktu, strtotime(now()))),
    		
    	]);
    
    	return response()->json([
    		'status' => $data,
    		'status_code'   => 200,
    		'msg'           => 'success',
    	], 200);
    }
}
