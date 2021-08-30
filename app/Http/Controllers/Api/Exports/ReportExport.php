<?php

namespace App\Http\Controllers\Api\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use DB;

class ReportExport implements FromCollection
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
    	return DB::table('orders')
		->join('users', function($join){
			$join->on('users.id', '=', 'orders.created_by')
			->where('orders.keperluan', 'Penjualan');
		})
		->join('order_details', function($join){
			$join->on('order_details.order_id', '=', 'orders.id');
		})
		->join('payments', function($join){
			$join->on('payments.id', '=', 'orders.payment_id');
		})
		->select('orders.id' , 'orders.table_number', 'orders.discount','order_details.product_price', 'order_details.quantity', 'orders.total', 'orders.keperluan'
			,'payments.name AS payment name', 'orders.name', 'orders.lokasi', 'orders.notelp','users.name', 'orders.created_at AS created_at')
		->addSelect('order_details.product_name')
		->where('orders.id_team', $this->id)
		->groupBy('order_details.order_id')
		->get();
    }
}