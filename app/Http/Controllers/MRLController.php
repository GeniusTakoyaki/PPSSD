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

    public function byCommodity($id)
    {
        $pesticides = DB::table('pesticides as p')
            ->leftJoin('mrl as m', function ($join) use ($id) {
                $join->on('m.pesticide_id', '=', 'p.id')
                    ->where('m.commodity_id', '=', $id);
            })
            ->select(
                'p.id',
                'p.name as name',
                'm.id as mrl_id',
                'm.value as mrl_value'
            )
            ->orderBy('p.name')
            ->get();

        return inertia('Mrl/Index', [
            'items' => $pesticides,
            'mode' => 'commodity',
            'commodityId' => (int) $id
        ]);
    }


    public function byPesticide($id)
    {
        $items = DB::table('commodities as c')
            ->leftJoin('mrl as m', function ($join) use ($id) {
                $join->on('m.commodity_id', '=', 'c.id')
                    ->where('m.pesticide_id', '=', $id);
            })
            ->select('c.id', 'c.name as name', 'm.value as mrl_value', 'm.id as mrl_id')
            ->get();

        return inertia('Mrl/Index', [
            'items' => $items,
            'mode' => 'pesticide',
            'selectedId' => $id
        ]);
    }


   public function allCommodity($id)
    {
        $pesticides = DB::table('pesticides as p')
            ->leftJoin('pns as m', function ($join) use ($id) {
                $join->on('m.Pesticide ID', '=', 'p.Pesticide ID')
                    ->where('m.Commodity ID', '=', $id);
            })
            ->select(
                'p.Pesticide ID as id',
                'p.name as name',
                'm.MRL as mrl_value'
            )
            ->orderBy('p.name')
            ->get();

        return response()->json($pesticides);
    }

    public function allPesticide($id)
    {
        $items = DB::table('commodities as c')
            ->leftJoin('pns as m', function ($join) use ($id) {
                $join->on('m.Commodity ID', '=', 'c.Commodity ID')
                    ->where('m.Pesticide ID', '=', $id);
            })
            ->select(
                'c.Commodity ID as id',
                'c.name as name',
                'm.MRL as mrl_value'
            )
            ->get();

        return response()->json($items);
    }



}
