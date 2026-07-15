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

        $pincodes = Pincode::with('city.state.country')
            ->select('pincodes.*');

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

            ->addColumn('area', function ($row) {
                return $row->area_name;
            })

            // Country Search
            ->filterColumn('country', function ($query, $keyword) {
                $query->whereHas('city.state.country', function ($q) use ($keyword) {
                    $q->where('country_name', 'like', "%{$keyword}%");
                });
            })

            // State Search
            ->filterColumn('state', function ($query, $keyword) {
                $query->whereHas('city.state', function ($q) use ($keyword) {
                    $q->where('state_name', 'like', "%{$keyword}%");
                });
            })

            // City Search
            ->filterColumn('city', function ($query, $keyword) {
                $query->whereHas('city', function ($q) use ($keyword) {
                    $q->where('city_name', 'like', "%{$keyword}%");
                });
            })

            // Area Search
            ->filterColumn('area', function ($query, $keyword) {
                $query->where('area_name', 'like', "%{$keyword}%");
            })

            ->addColumn('action', function ($row) {

                return '
                <div class="flex justify-center gap-2">
                    <button class="editBtn bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded" data-id="'.$row->id.'">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button class="deleteBtn bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded" data-id="'.$row->id.'">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}


    //     public function datatable(Request $request)
// {
//     return DataTables::of(Pincode::query())
//         ->addIndexColumn()
//         ->make(true);
// }

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
            'state_id' => 'required',
            'city_id' => 'required',
            'area_name' => 'required|max:100',
            'pincode' => 'required|digits:6|unique:pincodes,pincode',
        ]);

        Pincode::create([
            'city_id' => $request->city_id,
            'area_name' => $request->area_name,
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

            'state_id' => 'required',

            'city_id' => 'required',

            'area_name' => 'required|max:100',

            'pincode' => 'required|digits:6|unique:pincodes,pincode,' . $id,

        ]);

        $pincode = Pincode::findOrFail($id);

        $pincode->update([

            'city_id' => $request->city_id,

            'area_name' => $request->area_name,

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