<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class UserDashboardController extends Controller
{
    // USER DASHBOARD  
    public function dashboard(Request $request)
    {
        $query = Attraction::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $attractions = $query->latest()->get();
        $categories = Category::where('status', 'active')->get();

        return view('auth.user.dashboard', compact('attractions', 'categories'));
    }

    // VIEW SINGLE PLACE  
    public function show($id)
    {
        $place = Attraction::findOrFail($id);
        return view('auth.user.attraction-details', compact('place'));
    }

    // PLACE CARD  
    public function index()
    {
        $attractions = Attraction::with('category')
            ->where('status', 'active')
            ->get();

        return view('user.attractions.index', compact('attractions'));
    }

    // SAVE PLAN  
    public function savePlan(Request $request)
    {
        try {
            $placeId = $request->input('place_id');

            if (!$placeId || !Auth::check()) {
                return response()->json(['status' => 'error']);
            }

            $exists = Plan::where('user_id', Auth::id())
                ->where('attraction_id', $placeId)
                ->exists();

            if ($exists) {
                return response()->json(['status' => 'exists']);
            }

            Plan::create([
                'user_id' => Auth::id(),
                'attraction_id' => $placeId,
                'is_one_day' => 0,
                'visit_order' => null
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // VIEW PLANS  
    public function plans()
    {
        $plans = Plan::where('user_id', Auth::id())
            ->with('attraction')
            ->get();

        return view('auth.user.savePlace', compact('plans'));
    }

    // DELETE PLAN 
    public function deletePlan($id)
    {
        $plan = Plan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $wasOneDay = $plan->is_one_day;

        $plan->delete();

        // Reorder only in One Day Plan
        if ($wasOneDay) {

            $plans = Plan::where('user_id', Auth::id())
                ->where('is_one_day', 1)
                ->orderBy('visit_order')
                ->get();

            $order = 1;

            foreach ($plans as $p) {
                $p->visit_order = $order++;
                $p->save();
            }
        }

        return redirect()->back()->with([
            'status' => 'Place Deleted Successfully!',
            'type' => 'error'
        ]);
    }

    // ADD TO ONE DAY PLAN   
    public function addToOneDayPlan(Request $request)
    {
        $placeId = $request->input('place_id');

        $plan = Plan::where('user_id', Auth::id())
            ->where('attraction_id', $placeId)
            ->firstOrFail();

        $exists = Plan::where('user_id', Auth::id())
            ->where('attraction_id', $placeId)
            ->where('is_one_day', 1)
            ->exists();

        if ($exists) {
            return redirect()->back()->with([
                'status' => 'Place Already Added!',
                'type' => 'done'
            ]);
        }

        $lastOrder = Plan::where('user_id', Auth::id())
            ->where('is_one_day', 1)
            ->max('visit_order');

        $plan->is_one_day = 1;
        $plan->visit_order = $lastOrder ? $lastOrder + 1 : 1;
        $plan->save();

        return redirect()->back()->with([
            'status' => 'Place Added successfully!',
            'type' => 'success'
        ]);
    }

    // SHOW ONE DAY PLAN 
    public function showOneDayPlan()
    {
        $plans = Plan::where('user_id', Auth::id())
            ->where('is_one_day', 1)
            ->orderBy('visit_order')
            ->with('attraction')
            ->get();

        //  AUTO-FIX ORDER  
        $order = 1;
        foreach ($plans as $p) {
            if ($p->visit_order != $order) {
                $p->visit_order = $order;
                $p->save();
            }
            $order++;
        }

        return view('plan.oneDayPlan', compact('plans'));
    }

    // UPDATE DRAG & DROP ORDER 
    public function updateOrder(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $item) {
            Plan::where('id', $item['id'])
                ->where('user_id', Auth::id())
                ->update([
                    'visit_order' => $item['visit_order']
                ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    // SAVE ROUTE SESSION 
    public function saveRouteSession(Request $request)
    {
        $items = $request->input('items', []);

        $attractionIds = collect($items)
            ->map(function ($item) {
                return is_array($item) ? ($item['attraction_id'] ?? null) : null;
            })
            ->filter()
            ->values()
            ->toArray();

        session(['route_order' => $attractionIds]);

        return response()->json([
            'status' => 'ok',
            'saved' => $attractionIds
        ]);
    }

    // SHOW GENERATED ROUTE PAGE 
    public function showRoutePage()
    {
        $attractionIds = session('route_order', []);

        $attractionIds = collect($attractionIds)
            ->flatten()
            ->filter()
            ->values()
            ->toArray();

        if (empty($attractionIds)) {
            return redirect()->route('plan.show-one-day-plan')
                ->with([
                    'status' => 'Please save your route order first.',
                    'type' => 'error'
                ]);
        }

        $plans = Plan::where('user_id', Auth::id())
            ->where('is_one_day', 1)
            ->whereIn('attraction_id', $attractionIds)
            ->with('attraction')
            ->get();

        $sorted = collect($attractionIds)
            ->map(fn($aid) => $plans->firstWhere('attraction_id', $aid))
            ->filter()
            ->values();

        return view('plan.route', ['plans' => $sorted]);
    }


    // USER LOGOUT 
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
