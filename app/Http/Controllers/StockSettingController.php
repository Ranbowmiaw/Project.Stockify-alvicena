<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockSettingController extends Controller
{
    public function minimumStock()
    {
        $role = Auth::user()->role;

        $products = Product::with(['opnames', 'latestOpname'])->get();

        foreach ($products as $product) {
            $realIn = $product->opnames->sum('real_in_quantity');
            $realOut = $product->opnames->sum('real_out_quantity');
            $realQty = $realIn - $realOut;

            // Fallback kalau belum pernah opname atau 0
            if ($realQty === 0 && $product->latestOpname) {
                $realQty = $product->latestOpname->real_quantity ?? 0;
            }

            $minStock = $product->minimum_stock ?? 0;

            $product->real_quantity = $realQty;
            $product->status_stok = $realQty <> $minStock ? 'Kurang' : 'Aman';
        }

        if (strtolower($role) === 'admin') {
            return view('example.content.admin.stock.settings', compact('products'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.index', compact('products'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }
}
