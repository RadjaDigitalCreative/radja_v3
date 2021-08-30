<?php

namespace App\Http\Controllers\Api\Models;

use App\Http\Controllers\Api\Models\Products;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImports implements ToModel
{
     protected $id;
    
     function __construct($id) {
            $this->id = $id;
     }
    public function model(array $row)
    {
        return new Products([
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
            'id_team'    => $this->id,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),

        ]);
    }
}
