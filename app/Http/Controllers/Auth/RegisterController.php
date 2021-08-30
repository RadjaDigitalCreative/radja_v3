<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Twilio\Rest\Client;

class RegisterController extends Controller
{

    use RegistersUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }
    public function referal($id)
    {
        $data = DB::table('users')
        ->where('referal', $id)
        ->select('referal')
        ->first();
        $data2 = DB::table('users')
        ->where('referal2', $id)
        ->select('referal2')
        ->first();
         $data3 = DB::table('users')
        ->where('referal3', $id)
        ->select('referal3')
        ->first();
        if ($data == TRUE) {
            return view('auth.register_referal', compact('data'));
        }elseif($data2 == TRUE){
            return view('auth.register_referal2', compact('data2'));
        }elseif($data3 == TRUE){
            return view('auth.register_referal3', compact('data3'));
        }else{
            return view('auth.register');
        }
    }
    protected function create(array $data)
    {
        $user = DB::table('users')
        ->where('email', $data['email'])
        ->first();

        if($user === NULL){
            if ($data['referal'] == NULL) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'notelp' => $data['notelp'],
                    'level' => $data['level'],
                    'agen' => '1',
                    'password' => Hash::make($data['password']),
                    'id_team' => bin2hex(random_bytes(20)),

                ]);
            }else{
                $ref2 = DB::table('users')
                ->where('referal2', $data['referal'])
                ->where('agen', 2)
                ->first();
                $ref3 = DB::table('users')
                ->where('referal3', $data['referal'])
                ->where('agen', 3)
                ->first();
                if ($ref2 == TRUE && $ref3 == FAlSE) {
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'notelp' => $data['notelp'],
                        'level' => $data['level'],
                        'referal' => $ref2->referal,
                        'referal2' => $data['referal'],
                        'agen' => '3',
                        'password' => Hash::make($data['password']),
                        'id_team' => bin2hex(random_bytes(20)),
                    ]);
                }elseif($ref2 == FAlSE && $ref3 == FAlSE){
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'notelp' => $data['notelp'],
                        'level' => $data['level'],
                        'referal' => $data['referal'],
                        'agen' => '2',
                        'password' => Hash::make($data['password']),
                        'id_team' => bin2hex(random_bytes(20)),
                    ]);
                }
                elseif($ref3 == TRUE){
                    $user = User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'notelp' => $data['notelp'],
                        'level' => $data['level'],
                        'referal' => $ref3->referal,
                        'referal2' => $ref3->referal2,
                        'referal3' => $data['referal'],
                        'agen' => '4',
                        'password' => Hash::make($data['password']),
                        'id_team' => bin2hex(random_bytes(20)),
                    ]);
                }

            }

            if ($data['level'] == 'Owner') {
                DB::table('role')
                ->insert([
                    'user_id'  =>  $user['id'],
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
                    'user_id'  =>  $user['id'],
                ]); 
            }
            DB::table('role_cabang')
            ->insert([
                'user_id'  =>  $user['id'],
            ]);
            // DB::table('cabang')
            // ->insert([

            //     'id_team'   => $user['id_team'],
            // ]);
            DB::table('agen')
            ->insert([
                'user_id'  =>  $user['id'],
                'status'  =>  1,
            ]);
            DB::table('role_payment')
            ->insert([
                'user_id' =>  $user['id'],
                 'pay' =>  2,
                'dibayar' => date('Y-m-d', strtotime('+30 days', strtotime(now())))

            ]);
            // $this->sendWhatsappNotification($otp, $data['notelp']);
            return $user;
        }else{
            return redirect('register');
        }
    }
    // private function sendWhatsappNotification(integer $otp, integer $recipient)
    // {
    //     $twilio_whatsapp_number = getenv("TWILIO_WHATSAPP_NUMBER");
    //     $account_sid = getenv("TWILIO_ACCOUNT_SID");
    //     $auth_token = getenv("TWILIO_AUTH_TOKEN");

    //     $client = new Client($account_sid, $auth_token);
    //     $message = "Your registration pin code is $otp";
    //     return $client->messages->create("whatsapp:$recipient", array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    // }
}
