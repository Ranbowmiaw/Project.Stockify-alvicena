<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;
use App\Models\StockTransaction;
use App\Repositories\StockOpnameRepository;
use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    protected $opnameService;

    public function __construct(StockOpnameService $opnameService)
    {
        $this->opnameService = $opnameService;
    }

    public function opname()
    {
        $opnameee = $this->opnameService->getAllWithRelations();
        $role = Auth::user()->role;

        if ($role === 'Admin') {
            return view('example.content.admin.stock.opname', compact('opnameee'));
        } elseif ($role === 'Manager Gudang') {
            return view('example.content.manager.stock.opname', compact('opnameee'));
        } elseif ($role === 'Staff Gudang') {
            return view('example.content.staff.stock.opname', compact('opnameee'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function edit($id)
    {
        $opname = $this->opnameService->findWithRelations($id);
        if (Auth::user()->role === 'Staff Gudang') {
            return view('example.content.staff.stock.opnameedit', compact('opname'));
        }
        abort(403, 'Unauthorized role');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'real_quantity' => 'required|integer|min:0',
            'note' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $transaction = StockTransaction::findOrFail($id);

        $this->opnameService->updateOpname($id, [
            'real_quantity' => $request->real_quantity,
            'note' => $request->note,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        $transaction->status = $request->status;
        $transaction->note = $request->note;
        $transaction->save();

        return redirect()->route('opnamee')->with('success', 'Stock opname berhasil diperbarui.');
    }

    
}
