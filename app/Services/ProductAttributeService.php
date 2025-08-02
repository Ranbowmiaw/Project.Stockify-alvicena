<?php

namespace App\Services;

use App\Repositories\ProductAttributeRepository;

class ProductAttributeService
{
    protected $attributeRepo;

    public function __construct(ProductAttributeRepository $attributeRepo)
    {
        $this->attributeRepo = $attributeRepo;
    }

    public function getAllWithProduct()
    {
        return $this->attributeRepo->allWithProduct();
    }

    public function find($id)
    {
        return $this->attributeRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->attributeRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->attributeRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->attributeRepo->delete($id);
    }
}
