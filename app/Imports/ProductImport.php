<?php

namespace App\Imports;

use App\Model\Product;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'category_id'     => NULL,
            'name'    => $row['2'], 
            'merk'    => $row['3'],
            'price'    => $row['4'], 
            'purchase_price'    => $row['5'], 
            'status'    => $row['6'], 
            'stock'    => $row['7'], 
            'stock_minim'    => $row['8'], 
            'satuan'    => $row['9'], 
            'lokasi'    => $row['10'], 
            'id_team'    => auth()->user()->id_team, 
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),

        ]);
    }
}
