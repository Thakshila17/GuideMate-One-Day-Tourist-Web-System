<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\Category;

class AttractionController extends Controller
{
    /**
     * SHOW ALL ATTRACTIONS
     */
    public function index(Request $request)
    {
        $query = Attraction::with('category')->latest();

        // FILTER BY CATEGORY
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $attractions = $query->get();
        $categories = Category::all();

        return view('admin.attractions.index', compact('attractions', 'categories'));
    }

    /**
     * STORE NEW ATTRACTION
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // IMAGE UPLOAD
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('attractions', 'public');
        }

        Attraction::create([
            'name' => $request->name,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'location' => $request->location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'opening_hours' => $request->opening_hours,
            'closing_hours' => $request->closing_hours,
            'entry_fee' => $request->entry_fee ? $request->entry_fee : null,
            'contact_info' => $request->contact_info,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.attractions.index')
            ->with('success', 'added');
    }

    /**
     * UPDATE ATTRACTION
     */
    public function update(Request $request, Attraction $attraction)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // KEEP OLD IMAGE
        $imagePath = $attraction->image;

        // NEW IMAGE UPLOAD (IF EXISTS)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('attractions', 'public');
        }

        $attraction->update([
            'name' => $request->name,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'location' => $request->location,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'opening_hours' => $request->opening_hours,
            'closing_hours' => $request->closing_hours,
            'entry_fee' => $request->entry_fee ? $request->entry_fee : null,
            'contact_info' => $request->contact_info,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.attractions.index')
            ->with('success', 'updated');
    }

    /**
     * DELETE ATTRACTION
     */
    public function destroy(Attraction $attraction)
    {
        $attraction->delete();

        return redirect()->route('admin.attractions.index')
            ->with('success', 'deleted');
    }
}
