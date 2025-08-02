<?php

namespace App\Services;

use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepo;

    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function getAll()
    {
        return $this->supplierRepo->all();
    }

    public function find($id)
    {
        return $this->supplierRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->supplierRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->supplierRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->supplierRepo->delete($id);
    }
}
