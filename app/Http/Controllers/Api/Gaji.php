<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use app\Exceptions\Handler;
use Illuminate\Http\Request;
use DB;

class Gaji extends Controller
{
    public function norek(Request $request)
	{
	    $data_rek = $request->bank;
        $data = DB::table('gaji')
		->where('user_id', $request->user_id)
		->update([
		    'bank' =>   $data_rek,
		    'norek' => $request->norek,    
		]);
		return response()->json([
			'update_norek' => $data,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);
	}
	public function index(Request $request, $id)
	{
		$pegawai = DB::table('users')
		->where('id', $id)
		->first();

		$data = DB::table("users")
		->select(DB::raw("SUM(gaji.total) as total, users.name, gaji.id, gaji.norek, gaji.bank, gaji_lembur.gaji AS total_lembur, gaji.created_at, users.image, users.notelp"))
		->leftJoin('gaji', function($join){
			$join->on('gaji.user_id', '=', 'users.id');
		})
		->leftJoin('gaji_lembur', function($join){
			$join->on('gaji_lembur.id_team', '=', 'users.id_team');
		})
		->where('users.id', $id)
		->where('users.id_team', $request->id_team)
		->groupBy("users.id")
		->first();

		$data2 = DB::table("users")
        ->select(DB::raw("SUM(potongan.total) as total, users.name"))
        ->leftJoin('potongan', function($join){
            $join->on('potongan.user_id', '=', 'users.id');
        })
        ->groupBy("users.id")
        ->where('users.id', $id)
        ->first();

		$data3 = DB::table("users")
		->select(DB::raw("COUNT(kerja.user_id) as total, SUM(kerja.lembur) as total_lembur, COUNT(kerja.lembur) as jumlah_lembur, COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur, jam_kerja.telat"))
		->leftJoin('kerja', function($join){
			$join->on('kerja.user_id', '=', 'users.id');
		})
		->leftJoin('jam_kerja', function($join){
			$join->on('jam_kerja.id_team', '=', 'users.id_team');
		})
		->groupBy("users.id")
		->where('kerja.status', 2)
		->where('users.id', $id)
		->first();

		$data4 = DB::table("absensi")
		->join('users', 'users.id_team', 'absensi.id_team')
		->select(DB::raw("COUNT(absensi.id) as total"))
		->where('users.id_team', $request->id_team)
		->where('absensi.bulan', now()->month)
		->first();

		$data5 = DB::table("users")
		->leftJoin('gaji', function($join){
			$join->on('gaji.user_id', '=', 'users.id');
		})
		->where('users.id', $id)
		->get();

		$data6 = DB::table("users")
		->leftJoin('potongan', function($join){
			$join->on('potongan.user_id', '=', 'users.id');
		})
		->where('users.id', $id)
		->get();

		$hasil = (((($data->total - $data2->total ) / $data4->total) * $data3->total) + ($data3->total_lembur * $data->total_lembur) - ($data3->total_telat * $data3->telat) );
		$hasil2 = $data->total / $data4->total;
		$hasil3 = $data3->total_lembur * $data->total_lembur;
		$hasil4 = $data3->total_telat * $data3->telat;
		return response()->json([
		    'notelp' => $data->notelp,
			'gambar_pegawai' => $data->image,
			'nama_pegawai' => $data->name,
			'jumlah_hari_kerja' => $data4->total,
			'masuk_kerja' => $data3->total,
			'lembur' => $data3->jumlah_lembur,
			'total_potongan' => $data2->total,
			'gaji_total' => $data->total,
			'gaji_saat_ini' => $hasil,
			'gaji_perhari' => $hasil2,
			'gaji_lembur_saat_ini' => $hasil3,
			'potongan_pelanggaran_saat_ini' => $hasil4,
			'no_rekening' => $data->norek,
		    'bank' => $data->bank,
			'status_code'   => 200,
			'msg'           => 'success',
		], 200);

	}
}
