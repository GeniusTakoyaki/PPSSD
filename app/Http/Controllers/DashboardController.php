<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\Pesticide;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get search and letter filters from query parameters
        $search = $request->input('search');

        // Commodities query
        $commoditiesQuery = Commodity::query();

        if ($search) {
            $commoditiesQuery->where('Commodity', 'like', "%{$search}%");
        }


        $commodities = $commoditiesQuery->orderBy('Commodity')->get();

        // Pesticides query
        $pesticidesQuery = Pesticide::query();

        if ($search) {
            $pesticidesQuery->where('Pesticide', 'like', "%{$search}%");
        }

        $pesticides = $pesticidesQuery->orderBy('Pesticide')->get();




        return Inertia::render('Dashboard', [
            'commodities' => $commodities,
            'pesticides' => $pesticides,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }
}