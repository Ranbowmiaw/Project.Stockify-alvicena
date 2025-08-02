<?php

namespace App\Repositories;

use App\Models\StockOpname;

class StockOpnameRepository
{
    public function findByTransactionId($transactionId)
    {
        return StockOpname::where('stock_transaction_id', $transactionId)->first();
    }

    public function createOrUpdate($transaction, array $data)
    {
        $opname = $this->findByTransactionId($transaction->id);

        $opnameData = [
            'product_id' => $transaction->product_id,
            'user_id' => $data['user_id'],
            'note' => $data['note'] ?? null,
            'date' => $data['date'] ?? now(),
        ];

        // Gunakan status untuk menentukan jenis transaksi (Masuk / Keluar)
        $status = strtolower($data['status']);

        if ($status === 'diterima') {
            $opnameData['real_in_quantity'] = $data['real_quantity'] ?? 0;
            $opnameData['real_out_quantity'] = null;
        } elseif ($status === 'dikeluarkan') {
            $opnameData['real_out_quantity'] = $data['real_quantity'] ?? 0;
            $opnameData['real_in_quantity'] = null;
        }


        if (!$opname) {
            $opnameData['stock_transaction_id'] = $transaction->id;
            return StockOpname::create($opnameData);
        }

        $opname->update($opnameData);
        return $opname;
    }
}
