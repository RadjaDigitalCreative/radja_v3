<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Cabang;
use App\Model\Akses;
use Carbon\Carbon;
use DB;
use Alert;


class UserController extends Controller
{
    protected $folder = 'backend.setting.user';
    protected $rdr = '/admin/user';
    private $titlePage = 'User';
    private $titlePage2 = 'Tambah User';
    private $titlePage3 = 'Update User';
    private $titlePage4 = 'Transfer Langganan';
    private $titlePage5 = 'Edit Menu Harga';
    private $titlePage6 = 'List Menu Harga Perbulan';

    public function menuharga()
    {
        $params = [
            'title' => $this->titlePage5,
            'title2' => $this->titlePage6
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $listharga = DB::table('role_pay')
            ->orderBy('bulan')
            ->get();
        return view('backend.setting.user.menuharga', $params, compact('role', 'bayar', 'listharga'));
    }

    public function menuharga_store(Request $request)
    {
        $count = count($request->bulan);
        $user = DB::table('role_pay')
            ->where('bulan', $request->bulan)
            ->first();
        if ($user === null) {
            for ($i = 0; $i < $count; $i++) {
                DB::table('role_pay')
                    ->insert([
                        'bulan' => $request->bulan[$i],
                        'harga' => $request->harga[$i],
                        'created_at' => now(),
                    ]);
            }
            return redirect('/admin/menu/harga')->with('success', 'Harga Berhasil Dibuat');
        } else {
            for ($i = 0; $i < $count; $i++) {
                DB::table('role_pay')
                    ->where('bulan', $request->bulan[$i])
                    ->update([
                        'bulan' => $request->bulan[$i],
                        'harga' => $request->harga[$i],
                        'created_at' => now(),
                    ]);
            }
            return redirect('/admin/menu/harga')->with('warning', 'Harga Berhasil Diupdate');
        }
    }

    public function menuharga_delete($id)
    {
        DB::table('role_pay')
            ->where('id', '=', $id)
            ->delete();
        return redirect('/admin/menu/harga')->with('success', 'Harga Berhasil Dihapus');

    }

    public function index()
    {
        $params = [
            'title' => $this->titlePage
        ];
        $data = DB::table('users')
            ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.notelp', 'users.email',
                'users.level', 'role_payment.image', 'users.lokasi', 'role_payment.dibayar',
                'role_payment.pay', 'role_payment.harga', 'role_payment.created_at',
                'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.is_sales')
            ->get();

        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $link = DB::table('users')
            ->groupBy('id_team')
            ->get();
        return view($this->folder . '.index', $params, compact('data', 'role', 'bayar', 'link'));
    }

    public function is_sales(Request $request)
    {
        if ($request->is_sales == 1){
            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'is_sales' => NULL,
                ]);
        }else{
            DB::table('users')
                ->where('id', $request->id)
                ->update([
                    'is_sales' => 1,
                ]);
        }

        return redirect('admin/user')->with('success', 'Sudah Menjadi Saless, Woww');
    }

    public function filter(Request $request)
    {
        $params = [
            'title' => $this->titlePage
        ];
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }
        $data = DB::table('users')->whereBetween('role_payment.tgl_bayar', [$start, $end])
            ->join('role_payment', 'role_payment.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.notelp',
                'users.email', 'users.level', 'role_payment.image', 'users.lokasi',
                'role_payment.dibayar', 'role_payment.pay', 'role_payment.harga', 'role_payment.created_at',
                'role_payment.updated_at', 'role_payment.bank', 'users.id_team', 'role_payment.tgl_bayar', 'users.is_sales')
            ->where('role_payment.pay', $request->bayar)
            ->get();

        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $link = DB::table('users')
            ->groupBy('id_team')
            ->get();
        return view($this->folder . '.index', $params, compact('data', 'role', 'bayar', 'link'));
    }

    public function create()
    {
        $params = [
            'title' => $this->titlePage2
        ];
        $data = DB::table('cabang')->where('id_team', auth()->user()->id_team)->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.create', $params, compact('data', 'role', 'bayar'));
    }

    public function show(Request $request)
    {
        $params = [
            'title' => $this->titlePage4
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        return view($this->folder . '.payment', $params, compact('role'));
    }

    public function store(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();
        if ($user === NULL) {
            $data = new User;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->email_verified_at = now();
            $data->level = $request->level;
            $data->lokasi = $request->lokasi;
            $data->notelp = $request->notelp;
            $data->id_team = $request->id_team;
            $data->password = bcrypt($request->password);
            $data->save();

            // role payment
            DB::table('role_payment')
                ->insert([
                    'user_id' => $data->id,
                    'pay' => 2,
                    'dibayar' => date('Y-m-d', strtotime('+30 days', strtotime(now())))

                ]);
            DB::table('role_cabang')->insert([
                'user_id' => $data->id,
            ]);

            // role akses
            $data2 = new Akses;
            $data2->user_id = $data->id;
            $data2->save();
            return redirect('admin/user')->with('success', 'Data Berhasil Ditambah');
        } else {
            return redirect('admin/user/create')->with('warning', 'User Email Sudah Ada');
        }
    }

    public function edit($id)
    {
        $params = [
            'title' => $this->titlePage3
        ];
        $data = User::find($id);
        $cabang = Cabang::all();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view($this->folder . '.edit', $params, compact('data', 'cabang', 'role', 'bayar'));
    }

    public function update(Request $request, $id)
    {
        User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'lokasi' => $request->lokasi,
            'level' => $request->level,
            'notelp' => $request->notelp,

        ]);
        return redirect($this->rdr)->with('success', 'Data berhasil di rubah');
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();

        DB::table('role')
            ->where('user_id', '=', $id)
            ->delete();
        DB::table('role_payment')
            ->where('user_id', '=', $id)
            ->delete();
        DB::table('role_cabang')
            ->where('user_id', '=', $id)
            ->delete();

        return redirect($this->rdr)->with('success', 'Data berhasil di hapus');
    }

    public function payment_store(Request $request)
    {
        $params = [
            'title' => $this->titlePage4
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        return view($this->folder . '.payment', $params, compact('role'));
    }
}
