<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create($request->only('name', 'color', 'status'));

        return redirect()->route('admin.categories.index')->with('success', 'added');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($request->only('name', 'color', 'status'));

        return redirect()->route('admin.categories.index')->with('success', 'updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'deleted');
    }
}
