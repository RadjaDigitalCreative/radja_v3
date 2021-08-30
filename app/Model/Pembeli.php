<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembeli extends Model
{
	protected $table = 'pembeli';
	protected $fillable = [
		'name', 
		'notelp', 
		'cabang', 
	];
}
