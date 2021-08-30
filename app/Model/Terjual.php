<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Terjual extends Model
{
	protected $table    = 'terjual';
	protected $fillable = ['order_id', 'name', 'cabang', 'terjual', 'satuan', 'keperluan' ,'product_id', 'id_team'];
}
