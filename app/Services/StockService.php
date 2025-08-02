<?php

namespace App\Services;

use App\Services\Interfaces\StockServiceInterface;
use App\Repositories\StockTransactionRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockService implements StockServiceInterface
{
    protected $stockRepo;

    public function __construct(StockTransactionRepository $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function getAllWithRelations()
    {
        return $this->stockRepo->allWithRelations();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $transaction = $this->stockRepo->create($data);

            // Ambil status dan tipe
            $status = $data['status'];
            $type = $data['type'];
            $product = Product::findOrFail($data['product_id']);
            

            // Jika status pending atau ditolak, stok tidak berubah
            if (in_array($status, ['pending', 'ditolak'])) {
                return $transaction;
            }

            if ($status === 'Diterima' && $type === 'masuk') {
                $product->stock += $data['quantity'];
                $product->save();
            }

            if ($status === 'Dikeluarkan' && $type === 'keluar') {
                $product->stock -= $data['quantity'];
                $product->save();
            }
            
            if ($status === 'Dikeluarkan' && $type === 'keluar') {
            if ($product->stock >= $data['quantity']) {
                $product->stock -= $data['quantity'];
            } else {
             throw new \Exception('Stok tidak mencukupi untuk pengeluaran.');
            }
                $product->save();
            }

            return $transaction;
        });
    }

    public function delete($id)
    {
        return $this->stockRepo->delete($id);
    }
}

