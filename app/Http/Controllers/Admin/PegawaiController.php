<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class PegawaiController extends Controller
{
    // BASE HARI KERJA
    private $jam = 'Buat Jam Absensi';
    private $hari_kerja = 'Hari Kerja Pegawai';
    private $hari_kerja_create = 'Buat Hari Kerja Pegawai';
    private $absensi = 'Absensi Pegawai';
    private $gaji = 'Gaji Pegawai';
    private $gaji_create = 'Tambah Gaji Pegawai';
    private $gaji_update = 'Edit Gaji Pegawai';
    private $rekap = 'Rekap Gaji Pegawai';
    private $rekap_view = 'Lihat Gaji Pegawai';
    private $user_pegawai = 'Pegawai';
    private $user_pegawai_view = 'Detail Pegawai';


    public function jam()
    {
//        WOKE
        $params = [
            'title' => $this->jam
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view('backend.admin.jam.index', $params, compact('bayar', 'role'));

    }

    public function jam_edit($id)
    {
        $params = [
            'title' => $this->jam
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $jam = DB::table('jam_kerja')
            ->where('id_team', $id)
            ->first();
        return view('backend.admin.jam.edit', $params, compact('bayar', 'role', 'jam'));

    }

    public function jam_store(Request $request)
    {
//        WOKE
        $user = DB::table('jam_kerja')
            ->where('id_team', auth()->user()->id_team)
            ->first();
        if ($user === null) {
            DB::table('jam_kerja')
                ->insert([
                    'jam_masuk' => $request->jam_masuk,
                    'jam_keluar' => $request->jam_keluar,
                    'telat' => $request->telat,
                    'jam_keluar2' => $request->jam_keluar2,
                    'id_team' => auth()->user()->id_team,
                    'created_at' => now(),
                ]);
            return redirect('/admin/pegawai/hari')->with('success', 'Data Jam Absensi Berhasil Disimpan!');
        } else {
            DB::table('jam_kerja')
                ->where('id_team', auth()->user()->id_team)
                ->update([
                    'jam_masuk' => $request->jam_masuk,
                    'jam_keluar' => $request->jam_keluar,
                    'telat' => $request->telat,
                    'jam_keluar2' => $request->jam_keluar2,
                    'id_team' => auth()->user()->id_team,
                    'created_at' => now(),
                ]);
            return redirect('/admin/pegawai/hari')->with('warning', 'Data Jam Absensi Sudah Diupdate !');
        }
    }

    public function jam_update(Request $request, $id)
    {
        //        WOKE

        DB::table('jam_kerja')
            ->where('id_team', $id)
            ->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
                'telat' => $request->telat,
                'created_at' => now(),
            ]);
        return redirect('/admin/pegawai/hari')->with('success', 'Data Jam Absensi Berhasil Diupdate!');

    }

    public function jam_lembur(Request $request)
    {
        //        WOKE

        $user = DB::table('gaji_lembur')
            ->where('id_team', auth()->user()->id_team)
            ->first();
        if ($user === null) {
            DB::table('gaji_lembur')
                ->insert([
                    'jam_masuk_lembur' => $request->jam_masuk_lembur,
                    'jam_keluar_lembur' => $request->jam_keluar_lembur,
                    'nama' => $request->nama,
                    'gaji' => $request->gaji,
                    'id_team' => auth()->user()->id_team,
                    'created_at' => now(),
                ]);
            return redirect('/admin/pegawai/hari')->with('success', 'Data Jam Absensi Lembur Berhasil Disimpan!');
        } else {
            return redirect('/admin/pegawai/hari')->with('warning', 'Data Jam Absensi Lembur Sudah Ada !');
        }
    }

    public function hari_filter(Request $request)
    {
//        WOKE
        $params = [
            'title' => $this->hari_kerja
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $absensi =
            DB::table('absensi')
                ->join('jam_kerja', 'absensi.id_team', 'jam_kerja.id_team')
                ->select(
                    'absensi.*',
                    'jam_kerja.jam_masuk',
                    'jam_kerja.jam_keluar',
                    'jam_kerja.jam_keluar2'
                )
                ->where('absensi.id_team', auth()->user()->id_team)
                ->where('absensi.bulan', $request->filter)
                ->get();
        return view('backend.admin.pegawai.index', $params, compact('bayar', 'role', 'absensi'));
    }

    public function hari()
    {
//        WOKE
        $params = [
            'title' => $this->hari_kerja
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $absensi = DB::table('absensi')
            ->join('jam_kerja', 'absensi.id_team', 'jam_kerja.id_team')
            ->select(
                'absensi.*',
                'jam_kerja.jam_masuk',
                'jam_kerja.jam_keluar',
                'jam_kerja.jam_keluar2'
            )
            ->where('absensi.id_team', auth()->user()->id_team)
            ->get();
        return view('backend.admin.pegawai.index', $params, compact('bayar', 'role', 'absensi'));
    }

    public function hari_create()
    {
//        WOKE
        $params = [
            'title' => $this->hari_kerja_create
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();

        $workdays = array();
        $type = CAL_GREGORIAN;
        $month = date('n');
        $year = date('Y');
        $day_count = cal_days_in_month($type, $month, $year);
        for ($i = 1; $i <= $day_count; $i++) {

            $date = $year . '/' . $month . '/' . $i;
            $get_name = date('l', strtotime($date));
            $day_name = substr($get_name, 0, 3);
            if ($day_name != 'Sun') {
                $workdays[] = date("l, d F Y", strtotime($i . "-" . $month . "-" . $year));
            }

        }

        switch ($month) {
            case '1':
                $bulan = 'Januari';
                break;
            case '2':
                $bulan = 'Februari';
                break;
            case '3':
                $bulan = 'Maret';
                break;
            case '4':
                $bulan = 'April';
                break;
            case '5':
                $bulan = 'Mei';
                break;
            case '6':
                $bulan = 'Juni';
                break;
            case '7':
                $bulan = 'Juli';
                break;
            case '8':
                $bulan = 'Agustus';
                break;
            case '9':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'Bulan Tidak Ada';
                break;
        }
        $tahun = $year;

        return view('backend.admin.pegawai.create', $params, compact('bayar', 'role', 'workdays', 'bulan', 'tahun', 'month'));
    }

    public function hari_store(Request $request)
    {
        $user = DB::table('absensi')
            ->where('date', $request->dateval)
            ->where('id_team', auth()->user()->id_team)
            ->first();
        if ($user === null) {
            $count = count($request->dateval);
            for ($i = 0; $i < $count; $i++) {
                DB::table('absensi')
                    ->insert([
                        'date' => $request->dateval[$i],
                        'bulan' => $request->bulan,
                        'id_team' => auth()->user()->id_team,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }
            return redirect('/admin/pegawai/hari')->with('success', 'Data Berhasil Disimpan!');
        } else {
            return redirect('/admin/pegawai/hari')->with('warning', 'Data Sudah Ada!');
        }
    }

    public function hari_destroy($id)
    {
//        WOKE
        DB::table('absensi')
            ->where('id', $id)
            ->delete();
        return redirect('/admin/pegawai/hari')->with('success', 'Data berhasil di Hapus');

    }

    public function hari_destroyAll()
    {
        //        WOKE

        DB::table('absensi')
            ->where('id_team', auth()->user()->id_team)
            ->delete();
        return redirect('/admin/pegawai/hari')->with('success', 'Data Semua Hari di Hapus');
    }

    public function absensi()
    {
        $params = [
            'title' => $this->absensi
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $time = Carbon::now();
        $jam = $time->toTimeString();

        $absensi = DB::table('absensi')
            ->join('jam_kerja', 'jam_kerja.id_team', 'absensi.id_team')
            ->where('absensi.id_team', auth()->user()->id_team)
            ->select(
                'absensi.*',
                'jam_kerja.id_team',
                'jam_kerja.jam_masuk',
                'jam_kerja.jam_keluar',
                'jam_kerja.telat',
        )
            ->get();

        $absensi_lembur = DB::table('absensi')
            ->join('gaji_lembur', 'gaji_lembur.id_team', 'absensi.id_team')
            ->where('absensi.id_team', auth()->user()->id_team)
            ->get();

        $batas = DB::table('jam_kerja')
            ->get();

        $lembur = DB::table('gaji_lembur')
            ->get();

        $pegawai = DB::table('users')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $kerja = DB::table('kerja')
            ->get();

        $cuti = DB::table('gaji_cuti')->where('status', '1')->get();
        $ambil_cuti = DB::table('kerja')->where('cuti', '!=', '0')->count();
        return view('backend.admin.absensi.index', $params, compact('absensi_lembur', 'lembur', 'batas', 'role', 'bayar', 'absensi', 'pegawai', 'kerja', 'cuti', 'ambil_cuti'));
    }

    public function absensi_filter(Request $request)
    {
        $params = [
            'title' => $this->absensi
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $absensi = DB::table('absensi')
            ->join('jam_kerja', 'jam_kerja.id_team', 'absensi.id_team')
            ->where('bulan', $request->filter)
            ->where('id_team', auth()->user()->id_team)
            ->select(
                'absensi.*',
                'jam_kerja.id_team',
                'jam_kerja.jam_masuk',
                'jam_kerja.jam_keluar',
                'jam_kerja.telat',
        )
            ->get();
        $pegawai = DB::table('users')
            ->where('id_team', auth()->user()->id_team)
            ->get();
        $kerja = DB::table('kerja')
            ->get();

        $time = Carbon::now();
        $jam = $time->toTimeString();
        $absensi_lembur = DB::table('absensi')
            ->join('gaji_lembur', 'gaji_lembur.id_team', 'absensi.id_team')
            ->where('absensi.id_team', auth()->user()->id_team)
            ->where('bulan', $request->filter)
            ->get();

        $batas = DB::table('jam_kerja')
            ->get();

        $lembur = DB::table('gaji_lembur')
            ->get();
        $cuti = DB::table('gaji_cuti')->where('user_id', auth()->user()->id)->where('status', '1')->get();
        $ambil_cuti = DB::table('kerja')->where('user_id', auth()->user()->id)->where('cuti', '!=', '0')->count();
        return view('backend.admin.absensi.index', $params, compact('absensi_lembur', 'batas', 'lembur', 'role', 'bayar', 'absensi', 'pegawai', 'kerja', 'cuti', 'ambil_cuti'));
    }

    public function cuti_status(Request $request, $id)
    {
        $time = Carbon::now()->toTimeString();
        $user = DB::table('kerja')
            ->where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->first();
        if ($user === null) {
            DB::table('kerja')
                ->insert([
                    'date' => $request->date,
                    'bulan' => $request->bulan,
                    'user_id' => $request->user_id,
                    'cuti' => 1,
                    'absen' => $time,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            return redirect('/absensi')->with('success', 'Absen Cuti Berhasil!');

        } else {
            DB::table('kerja')
                ->where('date', $request->date)
                ->update([
                    'date' => $request->date,
                    'bulan' => $request->bulan,
                    'user_id' => $request->user_id,
                    'cuti' => 1,
                    'updated_at' => now(),
                ]);
            return redirect('/absensi')->with('success', 'Absen Cuti Berhasil!');
        }
    }

    public function absensi_status(Request $request, $id)
    {
        $time = Carbon::now()->toTimeString();
        $user = DB::table('kerja')
            ->where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->first();

        $telat = DB::table('users')
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->where('users.id', $request->user_id)
            ->first();

        if ($time >= $telat->jam_masuk) {
            if ($user === null) {
                DB::table('kerja')
                    ->insert([
                        'date' => $request->date,
                        'bulan' => $request->bulan,
                        'user_id' => $request->user_id,
                        'status' => 1,
                        'created_at' => now(),
                        'absen' => $time,
                        'absen_telat' => 1,
                    ]);
                return redirect('/admin/pegawai/absensi')->with('warning', 'Absen Masuk Berhasil!, tapi anda telat');
            } else {
                DB::table('kerja')
                    ->where('date', $request->date)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'date' => $request->date,
                        'bulan' => $request->bulan,
                        'user_id' => $request->user_id,
                        'status' => 2,
                        'updated_at' => now(),
                    ]);
                return redirect('/admin/pegawai/absensi')->with('success', 'Absen Keluar Berhasil!');
            }
        } elseif ($time <= $telat->jam_masuk) {
            if ($user === null) {
                DB::table('kerja')
                    ->insert([
                        'date' => $request->date,
                        'bulan' => $request->bulan,
                        'user_id' => $request->user_id,
                        'status' => 1,
                        'created_at' => now(),
                        'absen' => $time,
                    ]);
                return redirect('/admin/pegawai/absensi')->with('success', 'Absen Masuk Berhasil!');
            } else {
                DB::table('kerja')
                    ->where('date', $request->date)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'date' => $request->date,
                        'bulan' => $request->bulan,
                        'user_id' => $request->user_id,
                        'status' => 2,
                        'updated_at' => now(),
                    ]);
                return redirect('/admin/pegawai/absensi')->with('success', 'Absen Keluar Berhasil!');
            }
        }

    }

    public function absensi_lembur(Request $request, $id)
    {
        $jam_lembur = DB::table('gaji_lembur')
            ->leftJoin('users', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->where('users.id', $request->user_id)
            ->first();

        $time = Carbon::parse($jam_lembur->jam_masuk_lembur)->format('H');
        $ami = now()->format('H');
        $lembur = $ami - $time;

        $user = DB::table('kerja')
            ->where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->first();
        if ($user === null) {
            return redirect('/admin/pegawai/absensi')->with('warning', 'Anda Belum Absen Masuk Wajib!');
        } else {
            if ($lembur <= 1) {
                return redirect('/absensi')->with('warning', 'Diluar Jam Absen Lembur!');
            }else{
                DB::table('kerja')
                    ->where('user_id', $request->user_id)
                    ->where('date', $request->date)
                    ->update([
                        'lembur' => $lembur,
                        'lembur_at' => now()->toTimeString(),
                    ]);
                return redirect('/admin/pegawai/absensi')->with('success', 'Absen Lembur Berhasil!');
            }

        }
    }

    public function gaji()
    {
        $params = [
            'title' => $this->gaji
        ];
        $data = DB::table("users")
            ->select(DB::raw("total, users.name, gaji.created_at,
            gaji.id, users.id AS id_gaji, gaji_lembur.nama, gaji_lembur.gaji AS gaji_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy("users.id")
            ->get();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->get();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, SUM(kerja.lembur) as total_lembur,
             COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur, jam_kerja.telat"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->where('kerja.status', 2)
            ->where('kerja.bulan', now()->month)
            ->groupBy("users.id")
            ->get();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('absensi.bulan', now()->month)
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy('users.id')
            ->get();

        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        foreach ($data4 as $key) {
            $hari = $key->total;
        }
        function division($dividend, $divisor){
            if($divisor == 0){
                throw new Exception('Division by zero.');
            } else{
                $quotient = $dividend / $divisor;
                echo "<p>$dividend / $divisor = $quotient</p>";
            }
        }
        try {
            if ($hari == 0) {
                return back()->with('warning', 'Setting Absen belum ditentukan!!!');

            }else{
                return view('backend.admin.gaji.index', $params, compact('data', 'data2', 'data3', 'hari', 'role', 'bayar'));

            }
        } catch (\Exception $exception) {
            return back()->with('warning', 'Setting Absen belum ditentukan!!!');
        }

    }

    public function gaji_filter(Request $request)
    {
        $params = [
            'title' => $this->gaji
        ];
        $data = DB::table("users")
            ->select(DB::raw("SUM(gaji.total) as total, users.name, gaji.created_at,
             gaji.id, users.id AS id_gaji, gaji_lembur.nama, gaji_lembur.gaji AS gaji_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->where('users.id_team', auth()->user()->id_team)
            ->where('kerja.bulan', $request->filter)
            ->groupBy("kerja.id")
            ->limit(1)
            ->get();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->get();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, jam_kerja.telat, COUNT(kerja.lembur) as total_lembur, COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->where('kerja.status', 2)
            ->groupBy("users.id")
            ->get();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('absensi.bulan', now()->month)
            ->where('users.id_team', auth()->user()->id_team)
            ->get();

        foreach ($data4 as $key) {
            $hari = $key->total;
        }
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view('backend.admin.gaji.index', $params, compact('data', 'data2', 'data3', 'hari', 'role', 'bayar'));
    }

    public function gaji_create()
    {
        $params = [
            'title' => $this->gaji_create
        ];
        $pegawai = DB::table('users')
            ->where('users.id_team', auth()->user()->id_team)
            ->get();
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        return view('backend.admin.gaji.create', $params, compact('pegawai', 'role', 'bayar'));
    }

    public function gaji_store(Request $request)
    {
        $count = count($request->qty);
        for ($i = 0; $i < $count; $i++) {
            DB::table('gaji')
                ->insert([
                    'ket' => 'gaji',
                    'user_id' => $request->user_id,
                    'komponen' => $request->harga[$i],
                    'total' => $request->qty[$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }
        $count2 = count($request->jumlah);

        for ($i = 0; $i < $count2; $i++) {
            DB::table('potongan')
                ->insert([
                    'ket' => 'potongan',
                    'user_id' => $request->user_id,
                    'komponen' => $request->potongan[$i],
                    'total' => $request->jumlah[$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }
        return redirect('/admin/pegawai/gaji')->with('success', 'Data Berhasil Disimpan!');
    }

    public function gaji_edit($id)
    {
        $params = [
            'title' => $this->gaji_update
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();

        $gaji = DB::table('gaji')
            ->where('user_id', $id)
            ->first();
        $old_gaji = DB::table('gaji')
            ->where('user_id', $id)
            ->get();

        $potongan = DB::table('potongan')
            ->where('user_id', $id)
            ->first();
        $old_potongan = DB::table('potongan')
            ->where('user_id', $id)
            ->get();

        return view('backend.admin.gaji.edit', $params, compact('bayar', 'role', 'gaji', 'potongan', 'old_gaji', 'old_potongan', 'id'));
    }

    public function gaji_destroy($id)
    {
        DB::table('gaji')
            ->where('id', $id)
            ->delete();
        return redirect('admin/pegawai/gaji')->with('success', 'Data berhasil di Hapus');
    }

    public function gaji_destroy2($id)
    {
        DB::table('potongan')
            ->where('id', $id)
            ->delete();
        return redirect('admin/pegawai/gaji')->with('success', 'Data berhasil di Hapus');
    }

    public function rekap()
    {
        $params = [
            'title' => $this->rekap
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();

        $data = DB::table("users")
            ->select(DB::raw("total, users.name, gaji.created_at, gaji.id, users.id AS id_pegawai,
             gaji_lembur.nama, gaji_lembur.gaji AS gaji_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy("users.id")
            ->get();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->get();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, SUM(kerja.lembur) as total_lembur,
             COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur,
              jam_kerja.telat, gaji_cuti.hari, gaji_cuti.gaji, COUNT(kerja.cuti) as cuti"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_cuti', function ($join) {
                $join->on('gaji_cuti.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->where('kerja.status', 2)
            ->groupBy("users.id")
            ->get();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('absensi.bulan', now()->month)
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy('users.id')
            ->get();

        foreach ($data4 as $key) {
            $hari = $key->total;
        }
        function division($dividend, $divisor){
            if($divisor == 0){
                throw new Exception('Division by zero.');
            } else{
                $quotient = $dividend / $divisor;
                echo "<p>$dividend / $divisor = $quotient</p>";
            }
        }
        try {
            if ($hari == 0) {
                return back()->with('warning', 'Setting Absen belum ditentukan!!!');

            }else{
                return view('backend.admin.rekap.index', $params, compact('role', 'bayar', 'data', 'data2', 'data3', 'hari'));

            }
        } catch (\Exception $exception) {
            return back()->with('warning', 'Setting Absen belum ditentukan!!!');
        }
    }

    public function rekap_filter(Request $request)
    {
        $params = [
            'title' => $this->rekap
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();

        $data = DB::table("users")
            ->select(DB::raw("SUM(gaji.total) as total, users.name, gaji.created_at, gaji.id, users.id AS id_pegawai, gaji_lembur.nama, gaji_lembur.gaji AS gaji_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->where('users.id_team', auth()->user()->id_team)
            ->where('kerja.bulan', $request->filter)
            ->groupBy("kerja.id")
            ->limit(1)
            ->get();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->get();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, SUM(kerja.lembur) as total_lembur, COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur, jam_kerja.telat , gaji_cuti.hari, gaji_cuti.gaji, COUNT(kerja.cuti) as cuti"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_cuti', function ($join) {
                $join->on('gaji_cuti.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->where('kerja.status', 2)
            ->groupBy("users.id")
            ->get();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('absensi.bulan', now()->month)
            ->where('users.id_team', auth()->user()->id_team)
            ->get();

        foreach ($data4 as $key) {
            $hari = $key->total;
        }

        return view('backend.admin.rekap.index', $params, compact('role', 'bayar', 'data', 'data2', 'data3', 'hari'));
    }

    public function rekap_view($id)
    {
        $params = [
            'title' => $this->rekap_view
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $pegawai = DB::table('users')
            ->where('id', $id)
            ->first();

        $data = DB::table("users")
            ->select(DB::raw("total, users.name, gaji.created_at, gaji.id, gaji_lembur.gaji AS total_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->where('users.id', $id)
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy("users.id")
            ->first();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->where('users.id', $id)
            ->first();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, SUM(kerja.lembur) as total_lembur,
            COUNT(kerja.lembur) as jumlah_lembur, COUNT(kerja.absen_telat) as total_telat, users.name, kerja.bulan, kerja.lembur, jam_kerja.telat"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->leftJoin('jam_kerja', function ($join) {
                $join->on('jam_kerja.id_team', '=', 'users.id_team');
            })
            ->groupBy("users.id")
            ->where('kerja.bulan', now()->month)
            ->where('kerja.status', 2)
            ->where('users.id', $id)
            ->first();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('users.id_team', auth()->user()->id_team)
            ->where('absensi.bulan', now()->month)
            ->groupBy('users.id')
            ->first();

        $data5 = DB::table("users")
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->where('users.id', $id)
            ->get();

        $data6 = DB::table("users")
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->where('users.id', $id)
            ->get();


        $hasil2 = $data->total / $data4->total;
        $hasil3 = $data3->total_lembur * $data->total_lembur;
        $hasil4 = $data3->total_telat * $data3->telat;
        $cuti = DB::table('gaji_cuti')->where('user_id', auth()->user()->id)->where('status', '1')->get();
        $ambil_cuti = DB::table('kerja')->where('user_id', auth()->user()->id)->where('cuti', '!=', '0')->count();
        $a = 0;
        $b = 0;
        foreach ($cuti as $key) {
            $a = $key->hari;
            $b = $key->gaji;
        }
        $hasil5 = $a;
        $hasil6 = $ambil_cuti;
        $hasil7 = ($a - $ambil_cuti) * $b;
        $hasil = (((($data->total - $data2->total) / $data4->total) * $data3->total) + ($data3->total_lembur * $data->total_lembur) -
            ($data3->total_telat * $data3->telat) + $hasil7);
        return view('backend.admin.rekap.view', $params, compact('hasil4', 'bayar', 'role', 'pegawai', 'data', 'data2', 'data3', 'data4', 'hasil', 'hasil2', 'data5', 'data6', 'id', 'hasil3', 'hasil5', 'hasil6', 'hasil7'));
    }

    public function rekap_print($id)
    {
        $params = [
            'title' => $this->rekap_view
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $pegawai = DB::table('users')
            ->where('id', $id)
            ->first();

        $data = DB::table("users")
            ->select(DB::raw("SUM(gaji.total) as total, users.name, gaji.created_at, gaji.id, gaji_lembur.gaji AS total_lembur"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->leftJoin('gaji_lembur', function ($join) {
                $join->on('gaji_lembur.id_team', '=', 'users.id_team');
            })
            ->where('users.id', $id)
            ->where('users.id_team', auth()->user()->id_team)
            ->groupBy("users.id")
            ->first();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->where('users.id', $id)
            ->first();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, COUNT(kerja.lembur) as total_lembur, users.name"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->where('kerja.status', 2)
            ->where('users.id', $id)
            ->first();

        $data4 = DB::table("absensi")
            ->join('users', 'users.id_team', 'absensi.id_team')
            ->select(DB::raw("COUNT(absensi.id) as total"))
            ->where('users.id_team', auth()->user()->id_team)
            ->where('absensi.bulan', now()->month)
            ->first();

        $data5 = DB::table("users")
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->where('users.id', $id)
            ->get();

        $data6 = DB::table("users")
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->where('users.id', $id)
            ->get();

        $hasil = (((($data->total - $data2->total) / $data4->total) * $data3->total) + ($data3->total_lembur * $data->total_lembur));
        $hasil2 = $data->total / $data4->total;
        $hasil3 = $data3->total_lembur * $data->total_lembur;
        return view('backend.admin.rekap.print', $params, compact('bayar', 'role', 'pegawai', 'data', 'data2', 'data3', 'data4', 'hasil', 'hasil2', 'data5', 'data6', 'id', 'hasil3'));
    }

    public function user()
    {
        $params = [
            'title' => $this->user_pegawai
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $pegawai = DB::table('users')
            ->where('users.id_team', auth()->user()->id_team)
            ->get();
        return view('backend.admin.user_pegawai.index', $params, compact('pegawai', 'bayar', 'role'));
    }

    public function user_view($id)
    {
        $params = [
            'title' => $this->user_pegawai_view
        ];
        $role = DB::table('role')
            ->join('users', 'role.user_id', '=', 'users.id')
            ->get();
        $bayar = DB::table('users')
            ->join('role_payment', 'users.id', '=', 'role_payment.user_id')
            ->get();
        $pegawai = DB::table('users')
            ->where('id', $id)
            ->first();

        $data = DB::table("users")
            ->select(DB::raw("SUM(gaji.total) as total, users.name, gaji.created_at, gaji.id"))
            ->leftJoin('gaji', function ($join) {
                $join->on('gaji.user_id', '=', 'users.id');
            })
            ->where('users.id', $id)
            ->groupBy("users.id")
            ->first();

        $data2 = DB::table("users")
            ->select(DB::raw("SUM(potongan.total) as total, users.name"))
            ->leftJoin('potongan', function ($join) {
                $join->on('potongan.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->where('users.id', $id)
            ->first();

        $data3 = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, users.name"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->groupBy("users.id")
            ->where('users.id', $id)
            ->first();

        $data4 = DB::table("absensi")
            ->select(DB::raw("COUNT(id) as total"))
            ->first();

        $bulan = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, users.name, kerja.bulan"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->groupBy("kerja.bulan")
            ->where('users.id', $id)
            ->where('kerja.status', 2)
            ->get();

        $gajian = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, users.name, kerja.bulan, users.id as id_pegawai"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->groupBy("kerja.bulan")
            ->where('users.id', $id)
            ->get();

        $gaji = DB::table("users")
            ->select(DB::raw("COUNT(kerja.user_id) as total, users.name, kerja.bulan"))
            ->leftJoin('kerja', function ($join) {
                $join->on('kerja.user_id', '=', 'users.id');
            })
            ->groupBy("kerja.bulan")
            ->where('users.id', $id)
            ->first();

        $hasil = ((($data->total - $data2->total) / $data4->total) * $data3->total);
        $hasil2 = ((($data->total - $data2->total) / $data4->total) * $gaji->total);
        return view('backend.admin.user_pegawai.view', $params, compact('role', 'bayar', 'pegawai', 'data', 'data2', 'data3', 'data4', 'hasil', 'bulan', 'hasil2', 'gajian'));
    }

}
