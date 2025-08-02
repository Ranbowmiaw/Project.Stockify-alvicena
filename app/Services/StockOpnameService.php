<?php

namespace App\Services;

use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Repositories\StockOpnameRepository;
use Illuminate\Support\Facades\DB;

class StockOpnameService
{
    protected $opnameRepo;

    public function __construct(StockOpnameRepository $opnameRepo)
    {
        $this->opnameRepo = $opnameRepo;
    }

    public function getAllWithRelations()
    {
        return StockTransaction::with(['product', 'user', 'opname'])
            ->whereIn('status', ['pending', 'Diterima', 'Ditolak', 'Dikeluarkan'])
            ->get();
    }

    public function findWithRelations($id)
    {
        return StockTransaction::with(['product', 'opname'])->findOrFail($id);
    }

    public function updateOrCreateOpname($transactionId, $data)
    {
        return StockOpname::updateOrCreate(
            ['stock_transaction_id' => $transactionId],
            [
                'stock_transaction_id' => $transactionId,
                'product_id' => $data['product_id'],
                'user_id' => $data['user_id'],
                'note' => $data['note'] ?? null,
                'real_in_quantity' => $data['real_in_quantity'] ?? null,
                'real_out_quantity' => $data['real_out_quantity'] ?? null,
                'date' => $data['date'] ?? now(),
            ]
        );
    }

    public function updateOpname($transactionId, array $data)
    {
        return DB::transaction(function () use ($transactionId, $data) {
            $transaction = StockTransaction::with('product')->findOrFail($transactionId);

            // Update status dan catatan transaksi
            $transaction->status = $data['status'];
            $transaction->note = $data['note'] ?? null;
            $transaction->save();

            // Siapkan data opname
            $opnameData = [
                'product_id' => $transaction->product_id,
                'user_id' => $data['user_id'],
                'note' => $data['note'] ?? null,
                'date' => $data['date'] ?? now(),
                'status' => $data['status'],
                'real_quantity' => $data['real_quantity'],
                'real_in_quantity' => null,
                'real_out_quantity' => null,
            ];

            if (strtolower($data['status']) === 'diterima') {
                $opnameData['real_in_quantity'] = $data['real_quantity'];
            } elseif (strtolower($data['status']) === 'dikeluarkan') {
                $opnameData['real_out_quantity'] = $data['real_quantity'];
            }

            // Simpan atau update opname
            $opname = $this->opnameRepo->createOrUpdate($transaction, $opnameData);

            // Update stok sesuai status
            $product = $transaction->product;

            if (strtolower($data['status']) === 'diterima') {
                $product->stock += $data['real_quantity'];
            } elseif (strtolower($data['status']) === 'dikeluarkan') {
                $product->stock = max(0, $product->stock - $data['real_quantity']);
            }

            $product->save();

            return $opname;
        });
    }
}
