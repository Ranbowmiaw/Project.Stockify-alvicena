<?php

namespace App\Repositories;

use App\Models\suppliers;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all()
    {
        return suppliers::all();
    }

    public function find($id)
    {
        return suppliers::find($id);
    }

    public function create(array $data)
    {
        return suppliers::create($data);
    }

    public function update($id, array $data)
    {
        return suppliers::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return suppliers::find($id)->delete();
    }
}
