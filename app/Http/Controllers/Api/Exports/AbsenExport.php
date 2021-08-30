<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use DB;

class AbsenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $id;
    protected $bulan;
     function __construct($id, $bulan) {
            $this->id = $id;
            $this->bulan = $bulan;
     }
    public function collection()
    {
    	return DB::table('absensi')
        ->join('users', function($join){
            $join->on('users.id_team', '=', 'absensi.id_team');
        })
        ->join('kerja', function($join){
            $join->on('kerja.date', '=', 'absensi.date');
        })
        ->select([
            'users.name',
            'absensi.date',
            'kerja.note AS note_masuk',
            'kerja.note2 AS note_keluar',
            'kerja.note_radius_masuk',
            'kerja.note_radius_keluar',
            'kerja.created_at AS absen_masuk',
            'kerja.updated_at AS absen_keluar',
            'kerja.longitude',
            'kerja.langitude',
        ])
        ->where('users.id', $this->id)
        ->where('kerja.bulan', $this->bulan)
        ->orderBy('kerja.id', 'DESC')
        ->groupBy('kerja.id')
        ->get();
    }
}