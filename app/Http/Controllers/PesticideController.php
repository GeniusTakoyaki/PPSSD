<?php

namespace App\Http\Controllers;

use App\Models\Pesticide;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PesticideController extends Controller{

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $letter = $request->input('letter');

        $query = Pesticide::select('Pesticide ID', 'name')
            ->orderBy('name');

        if ($letter && $letter !== 'ALL') {
            $query->whereRaw('UPPER(LEFT(name, 1)) = ?', [strtoupper($letter)]);
        }

        if ($search !== '') {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $pesticides = $query->get();

        return Inertia::render('PesticidesView', [
            'pesticides' => $pesticides,
            'filters' => [
                'search' => $search,
                'letter' => $letter ?: 'ALL',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pesticides,name',
        ], [
            'name.unique' => 'That pesticide already exists.',
        ]);

        try {
            Pesticide::create($validated);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return back()->withErrors([
                    'name' => 'That pesticide already exists.'
                ]);
            }

            throw $e;
        }

        return back()->with('success', 'Added successfully');
    }

    public function destroy($id)
        {
            try {
                Pesticide::findOrFail($id)->delete();
                return back()->with('success', 'Deleted successfully.|' . now()->timestamp);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->errorInfo[1] === 1451) {
                    return back()->with('error', 'Cannot delete — has existing MRL records.|' . now()->timestamp);
                }
                return back()->with('error', 'Something went wrong.|' . now()->timestamp);
            }
        }
}