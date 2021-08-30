<?php

namespace App\Imports;

use App\Model\Waweb;
use App\Model\Database;
use Maatwebsite\Excel\Concerns\ToModel;


class DatabaseImport implements ToModel
{
    public function model(array $row)
    {
        // return new Waweb([
        //     'name'    => $row['1'], 
        //     'number'    => $row['2'], 
        //     'text'    => $row['3'], 
        //     'created_at'    => date('Y-m-d H:i:s'),
        //     'updated_at'    => date('Y-m-d H:i:s'),
        // ]);
        return new Database([
            'name'    => $row['1'], 
            'number'    => $row['2'], 
            'text'    => $row['3'], 
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
