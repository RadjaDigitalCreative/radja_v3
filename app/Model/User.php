<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{

    protected $fillable = [
        'name', 'email', 'password', 'poto', 'avatar', 'level', 'lokasi', 'notelp', 'pay', 'harga', 'bank','dibayar', 'user', 'agen'
    ];
    public function order()
    {
        return $this->hasMany(Order::class, 'created_by');
    }
    public function social()
    {
    	return $this->hasMany(Social::class);
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
