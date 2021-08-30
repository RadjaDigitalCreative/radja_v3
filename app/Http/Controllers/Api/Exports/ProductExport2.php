<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class ProductExport2 implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
     protected $id;
     
     function __construct($id) {
            $this->id = $id;
     }
    public function collection()
    {
    	return DB::table('products')
    	->where('name', '!=', 'NAMA PRODUK')
    	->where('id_team', $this->id)
    	->get();
    }
}