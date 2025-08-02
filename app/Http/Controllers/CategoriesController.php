<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function categori()
    {
        $categori = $this->categoryService->all();
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.categori.category', compact('categori'));
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function tambah()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.categori.categoryadd');
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function simpan(Request $request)
    {
        $data = [
            'name'=> $request->name,
            'description'=> $request->description,
        ];

        $this->categoryService->create($data);

        return redirect()->route('category');
    }

    public function edit($id)
    {
        $categori = $this->categoryService->find($id);
        $role = Auth::user()->role;
        
        if ($role === 'Admin') {
            return view('example.content.admin.categori.categoryadd', ['category'=>$categori]);
        } else {
            abort(403, 'Unauthorized role');
        }
    }

    public function update($id, Request $request)
    {
        $data = [
            'name'=> $request->name,
            'description'=> $request->description,
        ];

        $this->categoryService->update($id, $data);

        return redirect()->route('category');
    }

    public function hapus($id)
    {
        $this->categoryService->delete($id);

        return redirect()->route('category');
    }
}
