<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller

{
    // Show the category creation form
    public function create()
    {
        $categories = Category::all();
        return view('categories.CategoriesCreate', compact('categories')); 
    }

    // Store the newly created category
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Create the category
        Category::create([
            'name' => $request->name,
        ]);

        // Redirect to a page 
        return redirect()->route('categories.create')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('categories.CategoriesEdit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    // Validate the updated category name
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
    ]);

    // Update the category
    $category->update([
        'name' => $request->name,
    ]);

    // Redirect with success message
    return redirect()->route('categories.create')->with('success', 'Category updated successfully!');
}

public function destroy(Category $category)
{
    // Delete the category
    $category->delete();

    // Redirect with success message
    return redirect()->route('categories.create')->with('success', 'Category deleted successfully!');
}

}