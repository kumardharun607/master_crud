<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PincodeController extends Controller
{
    // Pincode Page
    public function index()
    {
        $countries = Country::orderBy('country_name')->get();

        return view('pincode', compact('countries'));
    }

    // Yajra DataTable
    public function datatable(Request $request)
    {
        if ($request->ajax()) {

            $pincodes = Pincode::with([
                'city.state.country'
            ])->whereNull('deleted_at');

            return DataTables::of($pincodes)

                ->addIndexColumn()

                ->addColumn('country', function ($row) {
                    return optional($row->city->state->country)->country_name;
                })

                ->addColumn('state', function ($row) {
                    return optional($row->city->state)->state_name;
                })

                ->addColumn('city', function ($row) {
                    return optional($row->city)->city_name;
                })

                ->addColumn('action', function ($row) {

                    return '
                        <button class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['action'])

                ->make(true);
        }
    }

    // Fetch States by Country
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)
                        ->orderBy('state_name')
                        ->get();

        return response()->json($states);
    }

    // Fetch Cities by State
    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)
                      ->orderBy('city_name')
                      ->get();

        return response()->json($cities);
    }

    // Store Pincode
    public function store(Request $request)
{
    $request->validate([
        'country_id' => 'required',
        'state_id'   => 'required',
        'city_id'    => 'required',
        'pincode'    => 'required|digits:6|unique:pincodes,pincode',
    ]);

    Pincode::create([
        'city_id' => $request->city_id,
        'pincode' => $request->pincode,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Pincode Added Successfully.'
    ]);
}

    // Edit
    public function edit($id)
    {
        $pincode = Pincode::with('city.state.country')->findOrFail($id);

        return response()->json($pincode);
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required',
            'state_id'   => 'required',
            'city_id'    => 'required',
            'pincode'    => 'required|digits:6|unique:pincodes,pincode,'.$id,
        ]);

        $pincode = Pincode::findOrFail($id);

        $pincode->update([
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Pincode Updated Successfully'
        ]);
    }

    // Soft Delete
    public function destroy($id)
    {
        $pincode = Pincode::findOrFail($id);

        $pincode->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pincode Deleted Successfully'
        ]);
    }
}