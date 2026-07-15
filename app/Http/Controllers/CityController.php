<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Country;
use App\Models\State;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CityController extends Controller
{
    //
        public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('city', compact('countries'));
    }
}
