<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllWithRelations()
    {
        return $this->productRepo->allWithRelations();
    }

    public function create(array $data)
    {
        return $this->productRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepo->delete($id);
    }

    public function find($id)
    {
        return $this->productRepo->find($id);
    }
    
    public function allWithRelations()
    {
        return $this->productRepo->allWithRelations();
    }
}
