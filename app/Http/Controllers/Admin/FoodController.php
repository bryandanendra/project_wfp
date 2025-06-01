<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->get();
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'nutrition_facts' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_active' => 'boolean'
        ]);

        $data = $request->only([
            'name', 'description', 'nutrition_facts', 
            'price', 'category_id', 'is_active'
        ]);

        // Set is_active default value
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                // Mengubah nama file sesuai nama menu
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/foods dengan nama baru
                $imagePath = $request->file('image')->storeAs('foods', $imageName, 'public');
                
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

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Makanan berhasil dibuat.');
    }

    public function show(Food $food)
    {
        $food->load('category');
        return view('admin.foods.show', compact('food'));
    }

    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('admin.foods.edit', compact('food', 'categories'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'nutrition_facts' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_active' => 'boolean'
        ]);

        $data = $request->only([
            'name', 'description', 'nutrition_facts', 
            'price', 'category_id'
        ]);

        // Set is_active value
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                // Delete old image if exists
                if ($food->image && Storage::disk('public')->exists($food->image)) {
                    Storage::disk('public')->delete($food->image);
                }

                // Mengubah nama file sesuai nama menu
                $imageName = Str::slug($request->name) . '-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                
                // Simpan file ke storage/app/public/foods dengan nama baru
                $imagePath = $request->file('image')->storeAs('foods', $imageName, 'public');
                
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

        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Makanan berhasil diperbarui.');
    }

    public function destroy(Food $food)
    {
        // Check if food has related orderDetails
        if ($food->orderDetails()->count() > 0) {
            return redirect()->route('admin.foods.index')
                ->with('error', 'Makanan tidak dapat dihapus karena sudah digunakan dalam pesanan.');
        }

        // Delete image if exists
        if ($food->image && Storage::exists('public/' . $food->image)) {
            Storage::delete('public/' . $food->image);
        }

        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Makanan berhasil dihapus.');
    }
}
