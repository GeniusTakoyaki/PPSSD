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

        $query = Commodity::select('Commodity ID', 'name')
            ->orderBy('name');

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($letter && $letter !== 'ALL') {
            $query->whereRaw('UPPER(LEFT(name, 1)) = ?', [$letter]);
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


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:commodities,name',
            'type' => 'required|string',
            'subtype' => 'required|string',
        ], ['name.unique' => 'That commodity already exists.']);

        try {
            Commodity::create($validated);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062){
                return back()->withErrors([
                    'name' => 'That commodity already exists'
                ]);
            }
        }
        

        return back()->with('success', 'Added successfully');
    }

    public function destroy($id)
        {
            try {
                Commodity::findOrFail($id)->delete();
                return back()->with('success', 'Deleted successfully.|' . now()->timestamp);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] === 1451) {
                    return back()->with('error', 'Cannot delete — has existing MRL records.|' . now()->timestamp);
                }
                return back()->with('error', 'Something went wrong.|' . now()->timestamp);
            }
        }
}