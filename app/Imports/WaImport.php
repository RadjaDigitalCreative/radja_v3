<?php

namespace App\Imports;

use App\Model\Waweb;
use App\Model\Database;
use Maatwebsite\Excel\Concerns\ToModel;


class WaImport implements ToModel
{
    public function model(array $row)
    {
        return new Waweb([
            'name'    => $row['1'], 
            'number'    => $row['2'], 
            'text'    => $row['3'], 
            'id_team'    => auth()->user()->id_team, 
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
