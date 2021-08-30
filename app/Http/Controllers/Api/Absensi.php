<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use app\Exceptions\Handler;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Api\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class Absensi extends Controller
{
    public function rekap(Request $request){
        return Excel::download(new AbsenExport($request->id, $request->bulan), 'report_absen.xlsx');
    }
    public function absensi_lembur(Request $request){  
        $jam_lembur = DB::table('gaji_lembur')
        ->leftJoin('users', function($join){
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
            return response()->json([
                'absen lembur' => 'Absen lembur tidak berhasil',
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
        }else{
            $data = DB::table('kerja')
            ->where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->update([
                'lembur' => $lembur,
                'lembur_at' => now()->toTimeString(),
            ]);
            return response()->json([
                'absen lembur' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200); 
        }
    }
    public function index(Request $request)
    {
        $data = DB::table('absensi')
        ->select([
            'absensi.id',
            'absensi.date',
            'absensi.bulan',
            'absensi.id_team',
            'absensi.created_at AS absen_masuk',
            'absensi.updated_at AS absen_keluar',
        ])
        ->where('absensi.id_team', $request->id_team)
        ->get();
        return response()->json([
            'hari absen' => $data,
            'status_code'   => 200,
            'msg'           => 'success',
        ], 200);
    }

    public function kirim(Request $request)
    {
        $time = Carbon::now()->toTimeString();
        $user = DB::table('kerja')
        ->where('user_id', $request->user_id)
        ->where('date', $request->date)
        ->first();

        $telat = DB::table('users')
        ->leftJoin('kerja', function($join){
            $join->on('kerja.user_id', '=', 'users.id');
        })
        ->leftJoin('jam_kerja', function($join){
            $join->on('jam_kerja.id_team', '=', 'users.id_team');
        })
        ->where('users.id', $request->user_id)
        ->first();

        if ($time >= $telat->jam_masuk) {
            if ($user === null) {
                $data = DB::table('kerja')
                ->insert([
                    'date' => $request->date,
                    'bulan' => $request->bulan,
                    'user_id' => $request->user_id,
                    'longitude' => $request->longitude,
                    'langitude' => $request->langitude,
                    'note' => $request->note,
                    'note_radius_masuk' => $request->note_radius_masuk,
                    'status' => 1,
                    'created_at' =>now(),
                    'absen' => $time,
                    'absen_telat' => 1,
                ]);
                return response()->json([
                    'absen masuk' => $data,
                    'status_code'   => 200,
                    'msg'           => 'success',
                ], 200);
            }else{
                $data = DB::table('kerja')
                ->where('date', $request->date)
                ->update([
                    'date' => $request->date,
                    'bulan' => $request->bulan,
                    'user_id' => $request->user_id,
                    'status' => 2,
                    'note2' => $request->note2,
                    'note_radius_keluar' => $request->note_radius_keluar,
                    'longitude' => $request->longitude,
                    'langitude' => $request->langitude,
                    'updated_at' =>now(),
                ]);
                return response()->json([
                    'absen keluar' => $data,
                    'status_code'   => 200,
                    'msg'           => 'success',
                ], 200);
            }        
        }elseif($time <= $telat->jam_masuk){
            if ($user === null) {
               $data = DB::table('kerja')
               ->insert([
                'date' => $request->date,
                'bulan' => $request->bulan,
                'user_id' => $request->user_id,
                'status' => 1,
                'note_radius_masuk' => $request->note_radius_masuk,
                'note' => $request->note,
                'longitude' => $request->longitude,
                    'langitude' => $request->langitude,
                'created_at' =>now(),
                'absen' => $time,
            ]);
               return response()->json([
                'absen masuk' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
           }else{
               $data = DB::table('kerja')
               ->where('date', $request->date)
               ->update([
                'date' => $request->date,
                'bulan' => $request->bulan,
                'note2' => $request->note2,
                'note_radius_keluar' => $request->note_radius_keluar,
                'longitude' => $request->longitude,
                'langitude' => $request->langitude,
                'user_id' => $request->user_id,
                'status' => 2,
                'updated_at' =>now(),
            ]);
               return response()->json([
                'absen keluar' => $data,
                'status_code'   => 200,
                'msg'           => 'success',
            ], 200);
           }      
       }
   }
   public function sudah_absen(Request $request)
   {
    $data = DB::table('absensi')
    ->join('users', function($join){
        $join->on('users.id_team', '=', 'absensi.id_team');
    })
    ->join('kerja', function($join){
        $join->on('kerja.date', '=', 'absensi.date');
    })
    ->select([
        'absensi.id',
        'absensi.date',
        'absensi.bulan',
        'absensi.id_team',
        'kerja.status',
        'kerja.user_id',
        'kerja.lembur',
        'kerja.absen',
        'kerja.note AS note_masuk',
        'kerja.note2 AS note_keluar',
        'kerja.note_radius_masuk',
        'kerja.note_radius_keluar',
        'kerja.created_at AS absen_masuk',
        'kerja.updated_at AS absen_keluar',
        'kerja.lembur_at',
        'kerja.absen_telat',
        'kerja.longitude',
        'kerja.langitude',
    ])
    ->where('users.id_team', $request->id_team)
    ->where('kerja.user_id', $request->user_id)
    ->orderBy('kerja.id', 'DESC')
    ->groupBy('kerja.id')
    ->get();
    return response()->json([
        'sudah absen' => $data,
        'status_code'   => 200,
        'msg'           => 'success',
    ], 200);
}
 public function absen_all(Request $request)
   {
    $data = DB::table('users')
    ->join('kerja', function($join){
        $join->on('users.id', '=', 'kerja.user_id');
    })
    ->select([
        'kerja.status', 
        'users.name',
        'users.id',
        'kerja.longitude',
        'kerja.note AS note_masuk',
        'kerja.note2 AS note_keluar',
         'kerja.note_radius_masuk',
        'kerja.note_radius_keluar',
        'kerja.langitude',
    ])
    ->where('users.id_team', $request->id_team)
    ->orderBy('kerja.id', 'DESC')
    ->get();
    return response()->json([
        'sudah absen' => $data,
        'status_code'   => 200,
        'msg'           => 'success',
    ], 200);
   }
   public function sudah_absen_hari(Request $request)
   {
    $data = DB::table('absensi')
    ->join('users', function($join){
        $join->on('users.id_team', '=', 'absensi.id_team');
    })
    ->join('kerja', function($join){
        $join->on('kerja.date', '=', 'absensi.date');
    })
    ->select([
        'absensi.id',
        'absensi.date',
        'absensi.bulan',
        'absensi.id_team',
        'kerja.status',
        'kerja.user_id',
        'kerja.lembur',
        'kerja.absen',
        'kerja.created_at AS absen_masuk',
        'kerja.updated_at AS absen_keluar',
        'kerja.lembur_at',
        'kerja.note AS note_masuk',
        'kerja.note2 AS note_keluar',
         'kerja.note_radius_masuk',
        'kerja.note_radius_keluar',
        'kerja.absen_telat',
        'kerja.longitude',
        'kerja.langitude',
    ])
    ->where('users.id_team', $request->id_team)
    ->where('kerja.user_id', $request->user_id)
    ->where('kerja.created_at', 'like', '%' . now()->format('Y-m-d') . '%')
    ->orderBy('kerja.id', 'DESC')
    ->groupBy('kerja.id')
    ->get();
    return response()->json([
        'sudah absen' => $data,
        'status_code'   => 200,
        'msg'           => 'success',
    ], 200);
}

}
