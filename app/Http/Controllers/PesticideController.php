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

        $query = Pesticide::select('Pesticide ID', 'Pesticide')
            ->orderBy('Pesticide');

        if ($letter && $letter !== 'ALL') {
            $query->whereRaw('UPPER(LEFT(Pesticide, 1)) = ?', [strtoupper($letter)]);
        }

        if ($search !== '') {
            $query->where('Pesticide', 'LIKE', "%{$search}%");
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


}