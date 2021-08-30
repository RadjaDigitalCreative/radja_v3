<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Alert;

class AuthController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
    	$credentials	= $request->only('email', 'password');
    	$check			= Auth::attempt($credentials);
        
    	if ($check) {
    		return redirect()->intended('admin/');
    	}else{
    		return redirect()->back();
    	}
    }
    public function logout()
    {
    	Auth::logout();
    	return redirect('/');
    }
}
