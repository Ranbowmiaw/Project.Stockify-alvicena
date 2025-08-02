<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\suppliers;
use App\Repositories\Interfaces\supplierServicesitoryInterface;
use App\Services\SupplierService;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function suppliyer()
    {
        $suppliyer = $this->supplierService->getAll();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.supplier.suppliers', compact('suppliyer'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.supplier.suppliers', compact('suppliyer'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }
    
    public function tambah()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.supplier.suppliersadd');
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function simpan(Request $request)
    {
        $data = [
            'name'=> $request->name,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'email'=> $request->email,
        ];

        $this->supplierService->create($data);

        return redirect()->route('suppliers');
    }

    public function edit($id)
    {
        $suppliyer = $this->supplierService->find($id);
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.supplier.suppliersadd', ['suppliers'=>$suppliyer]);
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function update($id, Request $request)
    {
        $data = [
            'name'=> $request->name,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'email'=> $request->email,
        ];

        $this->supplierService->update($id, $data);

        return redirect()->route('suppliers');
    }

    public function hapus($id)
    {
        $this->supplierService->delete($id);

        return redirect()->route('suppliers');
    }
}
