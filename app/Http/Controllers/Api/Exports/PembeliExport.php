<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class PembeliExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return DB::table('pembeli')->get();
    }
}