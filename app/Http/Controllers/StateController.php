<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    //
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();
        /*return view('state', [
    'countries' => $countries
]);*/

        return view('state', compact('countries'));
    }

    public function list() {}

    public function store(Request $request) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
    
}
