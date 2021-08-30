<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
     protected $id;
     protected $lokasi;
    
     function __construct($id, $lokasi) {
            $this->id = $id;
            $this->lokasi = $lokasi;
     }
    public function collection()
    {
    	return DB::table('products')
    	->where('name', '!=', 'NAMA PRODUK')
    	->where('id_team', $this->id)
    	->where('lokasi', $this->lokasi)
    	->get();
    }
}