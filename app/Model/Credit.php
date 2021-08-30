<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
	protected $table    = 'orders';
	protected $fillable = ['name', 'table_number', 'keperluan', 'discount', 'total', 'payment_id', 'email','created_by', 'image','lokasi', 'note', 'id_team'];
}
