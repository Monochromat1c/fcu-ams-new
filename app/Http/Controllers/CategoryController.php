<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|unique:categories,category',
        ], [
            'category.unique' => 'Category already exists.',
        ]);

        $category = new Category();
        $category->category = $validatedData['category'];
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category added successfully!');
    }

    public function index() {
        $categories = Category::orderBy('category', 'asc')->paginate(10);

        return view('fcu-ams/categories/categoriesList', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category' => 'required|string',
        ]);

        $category = Category::findOrFail($id);
        $category->category = $validatedData['category'];
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category = Category::find($id);
        if ($category) {
            try {
                $category->delete();
                return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->route('category.index')->withErrors(['error' => 'Cannot delete category because it is
                associated with other data.']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Category not found']);
        }

        
    }
}
