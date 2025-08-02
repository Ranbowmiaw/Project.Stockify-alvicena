<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function all()
    {
        return $this->categoryRepo->all();
    }

    public function create(array $data)
    {
        return $this->categoryRepo->create($data);
    }

    public function find($id)
    {
        return $this->categoryRepo->find($id);
    }

    public function update($id, array $data)
    {
        return $this->categoryRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->categoryRepo->delete($id);
    }
}
