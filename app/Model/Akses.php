<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
	protected $table    = 'role';
    protected $fillable = ['is_admin','is_akses','is_supplier', 'is_kategori', 'is_produk', 'is_order', 'is_pay', 'is_report', 'is_kas', 
	'is_stok', 'is_cabang', 'is_user'];

}
