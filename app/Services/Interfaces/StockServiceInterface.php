<?php

namespace App\Services\Interfaces;

interface StockServiceInterface
{
    public function getAllWithRelations();
    public function create(array $data);
    public function delete($id);
}
