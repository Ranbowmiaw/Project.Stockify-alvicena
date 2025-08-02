<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Models\product;
use App\Models\category;
use App\Models\suppliers;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function products()
    {
        $products = $this->productService->allWithRelations();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.crud.products', compact('products'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.crud.products', compact('products'));
        } else {
            abort(403, 'Unauthorized role');
        }
    
    }

    public function tambah()
    {
        $categories = category::all();
        $suppliers = suppliers::all();
        $role = auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.crud.add', compact('categories', 'suppliers'));
        } else {
            abort(403, 'Unauthorized role');
        }    
    }

    public function simpan(Request $request)
    {
        
        $data = [
            'kode_product' => $request->kode_product ?? $this->generateKodeProduct(),
            'category_id'=> $request->category_id,
            'supplier_id'=> $request->supplier_id,
            'name'=> $request->name,
            'sku'=> $request->sku,
            'description'=> $request->description,
            'purchase_price'=> $request->purchase_price,
            'selling_price'=> $request->selling_price,
            // 'image'=> $request->image,
            'minimum_stock'=> $request->minimum_stock,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $this->productService->create($data);

        return redirect()->route('product');
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);
        $categories = category::all();
        $suppliers = suppliers::all();
        $role = auth::user()->role;

        if ($role === 'Admin') {
            return view('example.content.admin.crud.add', compact('product', 'categories', 'suppliers'));
            } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function update($id, Request $request)
    {
        $data = [
            'kode_product' => $request->kode_product ?? $this->generateKodeProduct(),
            'category_id'=> $request->category_id,
            'supplier_id'=> $request->supplier_id,
            'name'=> $request->name,
            'sku'=> $request->sku,
            'description'=> $request->description,
            'purchase_price'=> $request->purchase_price,
            'selling_price'=> $request->selling_price,
            // 'image'=> $request->image,
            'minimum_stock'=> $request->minimum_stock,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $this->productService->update($id, $data);

        return redirect()->route('product');
    }

    public function hapus($id)
    {
        $this->productService->delete($id);

        return redirect()->route('product');
    }

    private function generateKodeProduct()
    {
        $prefix = 'RBW';
        $random = strtoupper(substr(md5(uniqid()), 0, 7)); 
        return $prefix . $random;
    }

    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->file('file'));
        return back()->with('success', 'Produk berhasil diimport!');
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
}
