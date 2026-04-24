<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CategoryController extends Controller

{
    use AuthorizesRequests;

    // Show the category creation form
    public function create()
    {
        $this->authorize('create', Category::class);


        $categories = Category::paginate(6);

        
        return view('category.create', compact('categories')); 
    }

    // Store the newly created category
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

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
        $this->authorize('update', $category);

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $this->authorize('update', $category);

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
    $this->authorize('delete', $category);

    // Delete the category
    $category->delete();

    // Redirect with success message
    return redirect()->route('categories.create')->with('success', 'Category deleted successfully!');
}

}