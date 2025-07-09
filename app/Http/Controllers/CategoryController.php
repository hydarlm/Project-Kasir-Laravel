<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

public function destroy(Category $category)
{
    try {
        // Cek apakah kategori memiliki produk terkait
        if ($category->products()->exists()) {
            throw new \Exception('Kategori tidak dapat dihapus karena masih terkait dengan produk.');
        }

        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->route('categories.index')
            ->with('error', $e->getMessage());
    }
}
}
