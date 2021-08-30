<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
	protected $table    = 'cabang';
	protected $fillable = ['nama_cabang', 'id_team', 'langitude', 'longitude'];
}
