<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            try {
                // Mengubah nama file sesuai nama kategori
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/categories dengan nama baru
                $imagePath = $request->file('image')->storeAs('categories', $imageName, 'public');
                
                if (!$imagePath) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Gagal menyimpan gambar. Silakan coba lagi.']);
                }
                
                $data['image'] = $imagePath;
            } catch (\Exception $e) {
                // Log error untuk debugging
                \Log::error('Upload image error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Terjadi kesalahan saat upload: ' . $e->getMessage()]);
            }
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            try {
                // Delete old image if exists
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                // Mengubah nama file sesuai nama kategori
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/categories dengan nama baru
                $imagePath = $request->file('image')->storeAs('categories', $imageName, 'public');
                
                if (!$imagePath) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Gagal menyimpan gambar. Silakan coba lagi.']);
                }
                
                $data['image'] = $imagePath;
            } catch (\Exception $e) {
                // Log error untuk debugging
                \Log::error('Upload image error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Terjadi kesalahan saat upload: ' . $e->getMessage()]);
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Check if category has related foods
        if ($category->foods()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki makanan terkait.');
        }

        // Delete image if exists
        if ($category->image && Storage::exists('public/' . $category->image)) {
            Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
