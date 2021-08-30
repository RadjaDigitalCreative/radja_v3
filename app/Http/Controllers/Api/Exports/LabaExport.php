<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class LabaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return DB::table('products')
    	->join('order_details', function($join){
    		$join->on('products.name', '=', 'order_details.product_name');
    	})
    	->join('orders', function($join){
    		$join->on('orders.id', '=', 'order_details.order_id');
    	})
    	->get();    
    }
}