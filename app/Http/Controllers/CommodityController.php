<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommodityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $letter = $request->input('letter');

        $query = Commodity::select('Commodity ID', 'Commodity')
            ->orderBy('Commodity');

        if ($search !== '') {
            $query->where('Commodity', 'like', "%{$search}%");
        }

        if ($letter && $letter !== 'ALL') {
            $query->whereRaw('UPPER(LEFT(Commodity, 1)) = ?', [$letter]);
        }

        $commodities = $query->get();

        return Inertia::render('CommoditiesView', [
            'commodities' => $commodities,
            'filters' => [
                'search' => $search,
                'letter' => $letter ?: 'ALL',
            ],
        ]);
    }
}