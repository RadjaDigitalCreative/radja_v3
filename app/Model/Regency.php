<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
	protected $table    = 'regencies';
	protected $fillable = ['province_id', 'name'];
}
