<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    protected $table    = 'databasepembeli';
    protected $fillable = ['name', 'number', 'text'];
}
