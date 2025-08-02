<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use App\Models\suppliers;

class DashboardService
{
    public function getDashboardData($role)
    {
        $productsWithPrice = Product::select('name', 'purchase_price', 'selling_price')->latest()->take(5)->get();
        $lap2 = StockTransaction::with('product')->latest()->take(10)->get();

        $totalStockIn = StockTransaction::where('type', 'masuk')
            ->where('status', 'diterima')
            ->sum('quantity');

        $totalStockOut = StockTransaction::where('type', 'keluar')
            ->where('status', 'dikeluarkan')
            ->sum('quantity');

        $activityLogs = ActivityLog::with('user')->latest('logged_at')->take(10)->get();

        $charts = [
            [
                'id' => 'chart-products',
                'label' => 'Total Products',
                'count' => Product::count(),
                'percentage' => '14.5%',
                'color' => '#10b981',
                'data' => [10, 15, 20, 18, 24, 30, 28],
            ],
            [
                'id' => 'chart-categories',
                'label' => 'Total Categories',
                'count' => Category::count(),
                'percentage' => '2.1%',
                'color' => '#3b82f6',
                'data' => [5, 7, 9, 8, 11, 13, 15],
            ],
            [
                'id' => 'chart-suppliers',
                'label' => 'Total Suppliers',
                'count' => suppliers::count(),
                'percentage' => '1.4%',
                'color' => '#f59e0b',
                'data' => [3, 5, 6, 6, 8, 10, 9],
            ],
        ];

        // Status stok dari real_quantity vs minimum_stock
        $products = Product::with('latestOpname')->get();
        foreach ($products as $product) {
            $realQty = $product->latestOpname->real_quantity ?? 0;
            $minStock = $product->minimum_stock ?? 0;
            $product->status_stok = $realQty <>  $minStock ? 'Kurang' : 'Aman';
            $product->real_quantity = $realQty;
        }

        return compact(
            'productsWithPrice',
            'lap2',
            'totalStockIn',
            'totalStockOut',
            'activityLogs',
            'charts',
            'products'
        );
    }
}
