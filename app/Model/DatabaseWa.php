<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DatabaseWa extends Model
{
    protected $table    = 'database';
    protected $fillable = ['name', 'number', 'text'];
}
