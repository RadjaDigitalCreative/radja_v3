<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Waweb extends Model
{
	protected $table    = 'waweb';
	protected $fillable = ['name', 'number', 'text', 'id_team'];
}
