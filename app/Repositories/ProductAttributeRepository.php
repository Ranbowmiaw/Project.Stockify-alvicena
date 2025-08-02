<?php

namespace App\Repositories;

use App\Models\product_attributes;

class ProductAttributeRepository
{
    public function allWithProduct()
    {
        return product_attributes::with('product')->oldest()->get();
    }

    public function create(array $data)
    {
        return product_attributes::create($data);
    }

    public function find($id)
    {
        return product_attributes::findOrFail($id);
    }

    public function update($id, array $data)
    {
        return product_attributes::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return product_attributes::findOrFail($id)->delete();
    }
}
