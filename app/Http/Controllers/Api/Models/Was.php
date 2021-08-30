<?php

namespace App\Http\Controllers\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Was extends Model
{
	protected $table    = 'waweb';
	protected $fillable = ['name', 'number', 'text', 'id_team'];
}