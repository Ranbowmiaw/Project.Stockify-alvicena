<?php

namespace App\Repositories;

use App\Models\StockTransaction;

class StockTransactionRepository
{
    public function allWithRelations()
    {
        return StockTransaction::with('product', 'user', 'opname')->oldest()->get();
    }

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    public function delete($id)
    {
        return StockTransaction::findOrFail($id)->delete();
    }
}
