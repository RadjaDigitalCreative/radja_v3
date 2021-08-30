<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
	protected $table = 'agen';
	protected $fillable = ['user_id', 'kode', 'level', 'status', 'created_at'];
}
