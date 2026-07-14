<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    // Display Country Page
    public function index()
    {
        $countries = Country::latest()->get();

        return view('country', compact('countries'));
    }

    // Store Country
    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|unique:countries,country_name',
        ]);

        Country::create([
            'country_name' => $request->country_name,
        ]);

        return redirect('/country');
    }

    // Edit Country
    public function edit($id)
    {
        $country = Country::findOrFail($id);

        $countries = Country::latest()->get();

        return view('country', compact('country', 'countries'));
    }

    // Update Country
    public function update(Request $request, $id)
    {
        $request->validate([
            'country_name' => 'required|unique:countries,country_name,' . $id,
        ]);

        $country = Country::findOrFail($id);

        $country->update([
            'country_name' => $request->country_name,
        ]);

        return redirect('/country');
    }

    // Soft Delete Country
    public function destroy($id)
    {
        $country = Country::findOrFail($id);

        $country->delete();

        return redirect('/country');
    }
}