<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cabang;
use App\Model\Provinsi;
use App\Model\Regency;
use App\Model\District;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Adrianorosa\GeoLocation\GeoLocation;
use Stevebauman\Location\Facades\Location;
use Alert;


class WilayahController extends Controller
{
	public function store(Request $request)
	{ 
		$data   = new Cabang;
		$data->nama_cabang   = $request->nama_cabang;
		$data->longitude   = $request->long;
		$data->langitude   = $request->lang;
		$data->id_team   = auth()->user()->id_team;
		$data->save();
		DB::table('role_cabang')->insert([
			'nama_cabang' =>  $request->nama_cabang
		]);
		return redirect('/admin/cabang')->with('success', 'Data Berhasil di tambahkan');
	}

}
