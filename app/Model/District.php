<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
	protected $table    = 'districts';
	protected $fillable = ['regency_id', 'name'];
}
