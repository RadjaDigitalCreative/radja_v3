<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Exports\KasExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class Image extends Controller
{
	public function index(Request $request)
	{
		$ami = DB::table('users')
		->where('id', $request->id)
		->select('image')->first();

		$image_name = $ami->image;
		$image = $request->file('image');
		if($image != '')
		{
			$image_name = rand() . '.' . $image->getClientOriginalExtension();
			$image->move(public_path('images'), $image_name);
		}
		$data = DB::table('users')
		->where('id', $request->id)
		->update([
			'image' => $image_name,
		]);
		return response()->json([
			'upload_jancuk' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
