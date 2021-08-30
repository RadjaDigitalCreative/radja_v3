<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['table_number','name','notelp',
        'discount', 'total', 'payment_id', 'email','lokasi' ,'jenis_penjualan',
        'keperluan',  'created_by', 'created_at', 'updated_at', 'id_team', 'disc'];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function restock()
    {
        return $this->hasMany(Restock::class);
    }
}
