<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Order;
use App\Model\Waweb;
use App\Model\Database;
use App\Model\DatabaseWa;
use Alert;


class DatabaseController extends Controller
{
	protected $rdr = '/admin/database';
	protected $rdr2 = '/admin/database/pembeli';
	private $titlePage='Database List';
	private $view='backend.database';

	public function index()
	{
		$params=[
			'title' => $this->titlePage
		];
		$data   = Waweb::all();
		$role  = DB::table('role')
		->join('users', 'role.user_id', '=', 'users.id')
		->get();
		$bayar = DB::table('users')
		->join('role_payment', 'users.id', '=', 'role_payment.user_id')
		->get();

		return view($this->view.'.index',$params, compact('bayar', 'data' ,'role'));
	}
	public function pembeli()
	{
		$params=[
			'title' => $this->titlePage
		];
		$data   = Database::all();
		$role  = DB::table('role')
		->join('users', 'role.user_id', '=', 'users.id')
		->get();
		$bayar = DB::table('users')
		->join('role_payment', 'users.id', '=', 'role_payment.user_id')
		->get();

		return view($this->view.'.pembeli',$params, compact('bayar', 'data' ,'role'));
	}
	public function wa()
	{
		$params=[
			'title' => $this->titlePage
		];
		$data   = DatabaseWa::all();
		$role  = DB::table('role')
		->join('users', 'role.user_id', '=', 'users.id')
		->get();
		$bayar = DB::table('users')
		->join('role_payment', 'users.id', '=', 'role_payment.user_id')
		->get();

		return view($this->view.'.index',$params, compact('bayar', 'data' ,'role'));
	}
	public function destroy($id)
	{
		$data = Database::find($id);
		$data->delete();
		return redirect($this->rdr2)->with('success', 'Data Berhasil di Hapus');
	}
	public function destroy2($id)
	{
		$data = DatabaseWa::find($id);
		$data->delete();
		return redirect($this->rdr)->with('success', 'Data Berhasil di Hapus');
	}
	public function deletePembeliAll()
	{
		DB::table('databasepembeli')->delete();
		return redirect($this->rdr)->with('success', 'Semua Data berhasil di hapus');
	}
	public function deleteWaAll()
	{
		DB::table('database')->delete();
		return redirect($this->rdr)->with('success', 'Semua Data berhasil di hapus');
	}
}
