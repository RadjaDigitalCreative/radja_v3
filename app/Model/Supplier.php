<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
	protected $table    = 'supplier';
	protected $fillable = ['id','nama','perusahaan','produk', 'notelp', 'id_team'];
	// public $timestamps = false;
	
}
