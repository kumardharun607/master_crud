<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
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

    public function list(Request $request) 
{
        if ($request->ajax()) {

        $states = State::with('country')
                        ->latest()
                        ->get();

        return DataTables::of($states)

            ->addIndexColumn()

            ->addColumn('country_name', function ($state) {

                return $state->country->country_name;

            })

            ->addColumn('action', function ($state) {

                return '
                    <button
                        class="bg-yellow-500 text-white px-3 py-1 rounded editBtn"
                        data-id="'.$state->id.'">

                        Edit

                    </button>

                    <button
                        class="bg-red-600 text-white px-3 py-1 rounded deleteBtn"
                        data-id="'.$state->id.'">

                        Delete

                    </button>
                ';

            })

            ->rawColumns(['action'])

            ->make(true);

    }
}
    

    public function store(Request $request) {
         $request->validate([
        'country_id' => 'required|exists:countries,id',
        'state_name' => 'required|max:255'
    ]);

    State::create([
        'country_id' => $request->country_id,
        'state_name' => $request->state_name
    ]);

    return response()->json([
        'status' => true,
        'message' => 'State Added Successfully'
    ]);
    }

    public function edit($id) {
            $state = State::find($id);

    if (!$state) {

        return response()->json([
            'status' => false,
            'message' => 'State Not Found'
        ],404);
    }
    return response()->json([
        'status' => true,
        'data' => $state
    ]);
    }

    public function update(Request $request, $id) {
        $request->validate([

        'country_id'=>'required|exists:countries,id',

        'state_name'=>'required|max:255'

    ]);

    $state=State::find($id);

    if(!$state){

        return response()->json([

            'status'=>false,

            'message'=>'State Not Found'

        ],404);

    }

    $state->update([

        'country_id'=>$request->country_id,

        'state_name'=>$request->state_name

    ]);

    return response()->json([

        'status'=>true,

        'message'=>'State Updated Successfully'

    ]);
    }

    public function destroy($id) {
            $state = State::find($id);

    if (!$state) {

        return response()->json([
            'status' => false,
            'message' => 'State Not Found'
        ], 404);

    }

    $state->delete();

    return response()->json([
        'status' => true,
        'message' => 'State Deleted Successfully'
    ]);
    }
    
}
