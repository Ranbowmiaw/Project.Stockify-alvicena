<?php

namespace App\Repositories;

use App\Models\category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return category::all();
    }

    public function find($id)
    {
        return category::find($id);
    }

    public function create(array $data)
    {
        return category::create($data);
    }

    public function update($id, array $data)
    {
        return category::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return category::find($id)->delete();
    }
}
