<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($type)
    {
        if (!in_array($type, ['dinein', 'takeaway'])) {
            return redirect()->route('before.order');
        }

        $categories = Category::all();
        $foods = Food::where('is_active', true)
                    ->with('category')
                    ->get();

        return view('menu.index', [
            'orderType' => $type,
            'categories' => $categories,
            'foods' => $foods
        ]);
    }
}
