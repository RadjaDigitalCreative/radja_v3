<?php

namespace App\Http\Controllers\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Grosir extends Model
{
	// use SoftDeletes;
	protected $table 	= 'harga_grosir';
	protected $fillable = ['id', 'products_id','qty', 'harga'];
	
}
