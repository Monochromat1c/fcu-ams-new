<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string',
        ]);

        $category = new Category();
        $category->category = $validatedData['category'];
        $category->save();

        $request->session()->put('input', $request->all());

        return response()->json(['reload' => true]);
    }
}
