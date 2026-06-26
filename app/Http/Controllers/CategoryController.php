<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;


class CategoryController extends Controller

{
    use AuthorizesRequests;

    public function index()
    {
        $categories = Category::paginate(6);
        
        return view('category.index', compact('categories')); 
    }
    // Show the category creation form
    public function create()
    {
        $this->authorize('create', Category::class);

        return view('category.create'); 
    }

    // Store the newly created category
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();

        // Create the new category using the validated data
        Category::create($validatedData);

        // Redirect to a page 
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();

        // Update the category
        $category->update($validatedData);

        // Redirect with success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        // Delete the category
        $category->delete();

        // Redirect with success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}