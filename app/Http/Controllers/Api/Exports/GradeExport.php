<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use DB;

class GradeExport implements FromCollection
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
    	return  DB::table('terjual')
		->join('products', 'terjual.id_team', '=', 'products.id_team') 
		->where('terjual.keperluan', '=', 'Penjualan') 
		->where('terjual.id_team', '=',$this->id) 
		->select(
			'terjual.id',
			'terjual.name AS nama_barang',
			'terjual.cabang',
			'terjual.terjual',
			'terjual.created_at'
		)
		->groupBy('terjual.id')
		->get();
    }
}