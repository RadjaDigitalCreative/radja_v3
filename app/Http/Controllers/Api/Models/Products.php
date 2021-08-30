<?php

namespace App\Http\Controllers\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
	// use SoftDeletes;
	// protected $dates 	= ['deleted_at'];
	protected $fillable = ['category_id', 'name','merk', 'price', 'purchase_price','status' ,'stock_minim', 'lokasi', 'satuan', 'stock', 'image', 'id_team', 'created_at', 'updated_at'];
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	public function grosir()
	{
		return $this->hasMany('App\Http\Controllers\Api\Models\Grosir', 'products_id');
	}
}
