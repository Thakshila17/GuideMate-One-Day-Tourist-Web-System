<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    // DASHBOARD  
    public function index()
    {
        return view('admin.dashboard', [
            'totalAttractions' => Attraction::count(),
            'totalCategories' => Category::count(),
            'activeAttractions' => Attraction::where('status', 'active')->count(),
            'activeCategories' => Category::where('status', 'active')->count(),
            'latestAttractions' => Attraction::with('category')->latest()->take(5)->get()
        ]);
    }
}
