<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select(
            'kode_product',
            'category_id',
            'supplier_id',
            'name',
            'sku',
            'description',
            'purchase_price',
            'selling_price',
            'minimum_stock'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Product',
            'Category ID',
            'Supplier ID',
            'Name',
            'SKU',
            'Description',
            'Purchase Price',
            'Selling Price',
            'Minimum Stock',
        ];
    }
}
