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
    public function getStates($countryId)
{
    $states = State::where('country_id', $countryId)
                    ->orderBy('state_name')
                    ->get();

    return response()->json($states);
}
public function list(Request $request)
{
    if ($request->ajax()) {

        $cities = City::with(['state.country'])
                        ->latest()
                        ->get();

        return DataTables::of($cities)

            ->addIndexColumn()

            ->addColumn('country_name', function ($city) {

                return $city->state->country->country_name;

            })

            ->addColumn('state_name', function ($city) {

                return $city->state->state_name;

            })

            ->addColumn('action', function ($city) {

                return '
                    <button
                        class="bg-yellow-500 text-white px-3 py-1 rounded editBtn"
                        data-id="'.$city->id.'">
                        Edit
                    </button>

                    <button
                        class="bg-red-600 text-white px-3 py-1 rounded deleteBtn"
                        data-id="'.$city->id.'">
                        Delete
                    </button>
                ';

            })

            ->rawColumns(['action'])

            ->make(true);
    }
}
public function store(Request $request)
{
    $request->validate([
        'state_id' => 'required|exists:states,id',
        'city_name' => 'required|max:255'
    ]);

    City::create([
        'state_id' => $request->state_id,
        'city_name' => $request->city_name
    ]);

    return response()->json([
        'status' => true,
        'message' => 'City Added Successfully'
    ]);
}
public function edit($id)
{
    $city = City::with('state.country')->find($id);

    if (!$city) {

        return response()->json([
            'status' => false,
            'message' => 'City Not Found'
        ],404);

    }

    return response()->json([

        'status' => true,

        'data' => [

            'id' => $city->id,

            'country_id' => $city->state->country->id,

            'state_id' => $city->state->id,

            'city_name' => $city->city_name

        ]

    ]);
}
public function update(Request $request,$id)
{
    $request->validate([

        'state_id' => 'required|exists:states,id',

        'city_name' => 'required|max:255'

    ]);

    $city = City::find($id);

    if(!$city){

        return response()->json([

            'status'=>false,

            'message'=>'City Not Found'

        ],404);

    }

    $city->update([

        'state_id'=>$request->state_id,

        'city_name'=>$request->city_name

    ]);

    return response()->json([

        'status'=>true,

        'message'=>'City Updated Successfully'

    ]);
}
public function destroy($id)
{
    $city = City::find($id);

    if (!$city) {

        return response()->json([
            'status' => false,
            'message' => 'City Not Found'
        ],404);

    }

    $city->delete();

    return response()->json([
        'status' => true,
        'message' => 'City Deleted Successfully'
    ]);
}
}
