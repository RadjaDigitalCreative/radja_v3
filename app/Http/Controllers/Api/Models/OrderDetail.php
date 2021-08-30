<?php

namespace App\Http\Controllers\Api\Models

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table    = 'order_details';
    protected $fillable = ['order_id','product_name','product_price','quantity','note', 'subtotal'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
