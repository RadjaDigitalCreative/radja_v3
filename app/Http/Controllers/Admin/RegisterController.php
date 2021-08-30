<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use DB;
class RegisterController extends Controller
{
	public function index()
	{
		return view('auth.register');
	}
	public function referal($id)
	{
		$data = DB::table('users')
		->where('referal', $id)
		->first();
		if ($data == TRUE) {
			return view('auth.register_referal', compact('data'));
		}else{
			return view('auth.register');
		}
	}
	public function store(Request $request)
	{
		$data = new User;
		$data->name     = $request->name;
		$data->email     = $request->email;
		$data->lokasi     = $request->lokasi;
		$data->level     = $request->level;
		$data->password     = bcrypt($request->password);
		$data->save();
		return redirect($this->rdr)->with('success', 'Data berhasil di tambah');
	}
}
