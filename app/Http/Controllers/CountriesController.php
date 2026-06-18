<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::select('ID', 'Country', 'Acronym')
            ->orderBy('Country')
            ->get();

        return Inertia::render('PesticidesView', [
            'countries' => $countries,
        ]);
    }
}