<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $sort = $request->input('sort', 'category');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = Category::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', '%' . $search . '%');
            });
        }

        if ($sort && $direction) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('category', 'asc');
        }

        $categories = $query->paginate(15);

        return view('fcu-ams/categories/categoriesList', compact('categories', 'sort', 'direction', 'search'));
    }

    public function create()
    {
        return view('fcu-ams/categories/addCategory');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|unique:categories,category',
        ]);

        Category::create($validatedData);

        return redirect()->route('categories.add')->with('success', 'Category added successfully.');
    }
}
