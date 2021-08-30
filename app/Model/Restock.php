<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
	protected $table    = 'restock';
	protected $fillable = ['lokasi', 'supplier', 'name','product_name','product_price','quantity', 'subtotal', 'status', 'satuan', 'id_team'];
	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
