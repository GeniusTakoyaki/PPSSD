<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class MRLController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $name = $request->input('search');

        //dd($category, $name);

        $results = collect([]);

        if ($category && $name) {
            $query = DB::table('pns')
                ->join('pesticides', 'pns.Pesticide ID', '=', 'pesticides.Pesticide ID')
                ->join('commodities', 'pns.Commodity ID', '=', 'commodities.Commodity ID');

            if ($category === 'Commodities') {
                $query->whereRaw('LOWER(commodities.name) = ?', [strtolower($name)]);
            }

            if ($category === 'Pesticides') {
                $query->whereRaw('LOWER(pesticides.name) = ?', [strtolower($name)]);
            }

            $results = $query->select(
                'commodities.name as commodity',
                'pesticides.name as pesticide',
                'pns.MRL as mrl'
            )->get();
        }

        return Inertia::render('TablePage', [
            'name' => $name,
            'category' => $category,
            'results' => $results
        ]);


    }
}
