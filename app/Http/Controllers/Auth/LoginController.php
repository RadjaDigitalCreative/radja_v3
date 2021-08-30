<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Socialite;

class LoginController extends Controller
{

	use AuthenticatesUsers;
	protected $redirectTo = '/admin';
	

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	// login google
	public function redirectToProvider($driver)
	{
		return Socialite::driver($driver)->redirect();
	}
	public function handleProviderCallback($driver)
	{
		try {
			$user = Socialite::driver($driver)->user();

			$create = User::firstOrCreate([
				'email' => $user->getEmail()
			], [
				'socialite_name' => $driver,
				'socialite_id' => $user->getId(),
				'name' => $user->getName(),
				'photo' => $user->getAvatar(),
				'email_verified_at' => now()
			]);

			auth()->login($create, true);
			return redirect($this->redirectPath());
		} catch (\Exception $e) {
			return redirect()->route('login');
		}
	}
}
