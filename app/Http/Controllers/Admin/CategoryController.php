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
                
                // Pastikan direktori categories ada dengan permission terbuka
                $categoriesPath = storage_path('app/public/categories');
                if (!file_exists($categoriesPath)) {
                    if (!mkdir($categoriesPath, 0777, true)) {
                        throw new \Exception('Tidak dapat membuat direktori categories. Cek permission folder storage.');
                    }
                    // Set permission folder agar terbuka di semua OS
                    @chmod($categoriesPath, 0777);
                }
                
                // CARA ALTERNATIF: Simpan file langsung menggunakan file_put_contents
                $uploadedFile = $request->file('image');
                $imagePath = 'categories/' . $imageName;
                $fullPath = storage_path('app/public/' . $imagePath);
                
                // Baca konten file yang diupload
                $fileContent = file_get_contents($uploadedFile->getRealPath());
                
                // Tulis konten ke lokasi tujuan
                if (file_put_contents($fullPath, $fileContent) === false) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Gagal menyimpan gambar. Silakan coba lagi.']);
                }
                
                // Set permission file agar dapat diakses di semua OS
                @chmod($fullPath, 0666);
                
                // Pastikan path yang disimpan adalah relatif
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
                    try {
                        Storage::disk('public')->delete($category->image);
                    } catch (\Exception $e) {
                        \Log::warning('Gagal menghapus gambar lama: ' . $e->getMessage());
                        // Lanjutkan proses meskipun gagal menghapus
                    }
                }

                // Mengubah nama file sesuai nama kategori
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                
                // Pastikan direktori categories ada dengan permission terbuka
                $categoriesPath = storage_path('app/public/categories');
                if (!file_exists($categoriesPath)) {
                    if (!mkdir($categoriesPath, 0777, true)) {
                        throw new \Exception('Tidak dapat membuat direktori categories. Cek permission folder storage.');
                    }
                    // Set permission folder agar terbuka di semua OS
                    @chmod($categoriesPath, 0777);
                }
                
                // CARA ALTERNATIF: Simpan file langsung menggunakan file_put_contents
                $uploadedFile = $request->file('image');
                $imagePath = 'categories/' . $imageName;
                $fullPath = storage_path('app/public/' . $imagePath);
                
                // Baca konten file yang diupload
                $fileContent = file_get_contents($uploadedFile->getRealPath());
                
                // Tulis konten ke lokasi tujuan
                if (file_put_contents($fullPath, $fileContent) === false) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => 'Gagal menyimpan gambar. Silakan coba lagi.']);
                }
                
                // Set permission file agar dapat diakses di semua OS
                @chmod($fullPath, 0666);
                
                // Pastikan path yang disimpan adalah relatif
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
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            try {
                Storage::disk('public')->delete($category->image);
            } catch (\Exception $e) {
                \Log::warning('Gagal menghapus gambar kategori: ' . $e->getMessage());
                // Lanjutkan proses meskipun gagal menghapus
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
