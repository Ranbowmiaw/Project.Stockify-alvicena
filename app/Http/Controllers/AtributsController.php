<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\product_attributes;
use App\Repositories\ProductAttributeRepository;
use App\Services\ProductAttributeService;
use Illuminate\Support\Facades\Auth;

class AtributsController extends Controller
{
    protected $atributService;

    public function __construct(ProductAttributeService $atributService)
    {
        $this->atributService = $atributService;
    }

    public function atribut ()
    {        
        $atributs = $this->atributService->getAllWithProduct();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.product_atribut.atribut', compact('atributs'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.product_atribut.atribut', compact('atributs'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function tambah()
    {
        $products = Product::all();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.product_atribut.atributadd', compact('products'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function simpan(Request $request)
    {
        $this->atributService->create($request->only(['product_id', 'name', 'value']));

        return redirect()->route('tribute');
    }

    public function edit($id)
    {
        $atributs = $this->atributService->find($id);
        $products = Product::all();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.product_atribut.atributadd', compact('atributs','products'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function update($id, Request $request)
    {
        $this->atributService->update($id, $request->only(['product_id', 'name', 'value']));

        return redirect()->route('tribute');
    }

    public function hapus($id)
    {
        $this->atributService->delete($id);

        return redirect()->route('tribute');
    }
}
