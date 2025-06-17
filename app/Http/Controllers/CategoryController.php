<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        //
        return view('categories.create');
    }


    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Buat kategori
        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
        //
    }

    public function update(Request $request, Category $category)
    {
        // Validasi input (unique, tapi kecualikan record yg sedang diupdate)
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Update kategori
        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
        //
    }

    public function destroy(Category $category)
    {
        
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
        //
    }
}
