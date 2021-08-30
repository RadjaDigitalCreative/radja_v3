<?php

namespace App\Http\Controllers\Api\Models;

use App\Http\Controllers\Api\Models\Was;
use Maatwebsite\Excel\Concerns\ToModel;

class WaImports implements ToModel
{
     protected $id;
    
     function __construct($id) {
            $this->id = $id;
     }
    public function model(array $row)
    {
        return new Was([
            'name'    => $row['1'], 
            'number'    => $row['2'], 
            'text'    => $row['3'], 
            'id_team'    => $this->id,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}

