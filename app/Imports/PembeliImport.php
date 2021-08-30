<?php

namespace App\Imports;

use App\Model\Pembeli;
use Maatwebsite\Excel\Concerns\ToModel;

class PembeliImport implements ToModel
{
    public function model(array $row)
    {
        return new Pembeli([
            'name'    => $row['1'], 
            'notelp'    => $row['2'],
            'cabang'    => $row['3'],
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
