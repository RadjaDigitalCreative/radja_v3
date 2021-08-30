<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use DataTables;
use Form;
use DB;
use Alert;

class CategoryController extends Controller
{
  protected $folder = 'backend.admin.kategori';
  protected $rdr = '/admin/category';
  private $titlePage='Kategori';
  private $titlePage2='Tambah Kategori';
  private $titlePage3='Update Kategori';


  public function index(Request $request)
  {
    $params=[
      'title' => $this->titlePage
    ];
    $data   = DB::table('categories')
    ->where('categories.id_team', auth()->user()->id_team)
    ->get();
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.index',$params, compact('data','role', 'bayar'));
  }

  public function table(Request $request)
  {

    $data  = Category::select(['id', 'name', 'created_at']);
    return Datatables::of($data)
    ->editColumn('created_at', function($index){
      return $index->created_at->format('d F Y');
    })
    ->addColumn('action', function($index){
      $tag = '<form action="'.route('category.destroy',$index->id).'" method="post"><a class="btn btn-success btn-sm" data-toggle="modal" data-target="#'.$index->id.'"><i class="fa fa-chevron-circle-right"></i></a> '.csrf_field().method_field("DELETE").'<button type="submit" class="btn btn-danger btn-sm" onclick="javascript:return confirm("Apakah anda yakin ingin menghapus data ini?")"><i class="fa fa-trash"></i></button></form>';
      return $tag;
    })
    ->rawColumns(['id','action'])
    ->make(true);
  }

  public function create()
  {
    $params=[
      'title' => $this->titlePage2
    ];
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.create', $params,  compact('role', 'bayar'));
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name'  => 'required'
    ]);
    $data   = new Category;
    $data->name   = $request->name;
    $data->id_team  = auth()->user()->id_team;
    $data->save();
    return redirect($this->rdr)->with('success', 'Data Berhasil di tambahkan');
  }
  
  public function edit($id)
  {
    $params=[
      'title' => $this->titlePage3
    ];
    $role  = DB::table('role')
    ->join('users', 'role.user_id', '=', 'users.id')
    ->get();
    $data = Category::find($id);
    $bayar = DB::table('users')
    ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
    ->get();
    return view($this->folder.'.edit',$params, compact('data', 'role', 'bayar'));
  }

  public function update(Request $request, $id)
  {
    $this->validate($request,[
      'name'  => 'required'
    ]);
    Category::find($id)->update([
      'name'  => $request->name
    ]);
    return redirect($this->rdr)->with('success', 'Data Berhasil di ubah');
  }

  public function destroy($id)
  {
    $data = Category::find($id);
    $data->delete();
    return redirect($this->rdr)->with('success', 'Data Berhasil di Hapus');
  }
}
