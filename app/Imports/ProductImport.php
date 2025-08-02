<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Product([
            'kode_product'   => $row[0] ?? null,
        'category_id'    => $row[1] ?? null,
        'supplier_id'    => $row[2] ?? null,
        'name'           => $row[3] ?? null,
        'sku'            => $row[4] ?? null,
        'description'    => $row[5] ?? null,
        'purchase_price' => $row[6] ?? 0,
        'selling_price'  => $row[7] ?? 0,
        'minimum_stock'  => $row[8] ?? 0,
        ]);
    }
}
