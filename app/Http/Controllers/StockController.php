<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\StockOpname;
use App\Repositories\StockTransactionRepository;
use App\Services\Interfaces\StockServiceInterface;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockServiceInterface $stockService)
    {
        $this->stockService = $stockService;
    }
    
    public function stock()
    {
        $stocks = $this->stockService->getAllWithRelations();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.stock.transactions', compact('stocks'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.stock.transactions', compact('stocks'));
        } elseif ($role === 'Staff Gudang') {
            return view('example.content.staff.stock.transactions', compact('stocks'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function tambah()
    {
        $products = Product::all();
        $role = Auth::user()->role;

        if ($role === 'Manager Gudang') {
            return view('example.content.manager.stock.transactions-add', compact('products'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function stockSettingsIndex()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.stock.settings');
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.stock.settings');
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function simpan(Request $request)
    {
        $data = [
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'status' => $request->status,
            'note' => $request->note,
        ];

        $this->stockService->create($data);

        return redirect()->route('stok');
    }

    public function hapus($id)
    {
        $this->stockService->delete($id);

        return redirect()->route('stok');
    }
}
