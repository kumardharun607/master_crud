@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow-md p-6">

    <h2 class="text-2xl font-bold mb-6">
        Create State
    </h2>

    <div class="grid grid-cols-3 gap-4">

        <div>

            <label class="font-semibold">
                Country
            </label>

            <select
                id="country_id"
                class="w-full border rounded px-3 py-2">

                <option value="">
                    Select Country
                </option>

                @foreach($countries as $country)

                    <option value="{{ $country->id }}">
                        {{ $country->country_name }}
                    </option>

                @endforeach

            </select>

        </div>

        <div>

            <label class="font-semibold">
                State Name
            </label>

            <input
                type="text"
                id="state_name"
                class="w-full border rounded px-3 py-2">

        </div>
        <input type="hidden" id="state_id">

        <div class="flex items-end">

            <button
                id="addState"
                class="bg-blue-600 text-white px-6 py-2 rounded">

                Add State

            </button>
                            <button id="reset"
                    type="reset"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg ml-3">

                    Reset

                </button>

        </div>

    </div>

</div>
<div class="bg-white rounded-lg shadow mt-8 p-6">

    <h2 class="text-2xl font-bold mb-5">
        State List
    </h2>

    {{-- <table class="w-full border border-collapse">

        <thead>

            <tr class="bg-gray-200">

                <th class="border p-2">SI.NO</th>

                <th class="border p-2">Country</th>

                <th class="border p-2">State</th>

                <th class="border p-2">Action</th>

            </tr>

        </thead>

        <tbody id="stateTableBody">

        </tbody>

    </table> --}}
    <table
    id="stateTable"
    class="display w-full border">

    <thead>

        <tr>

            <th>S.I No</th>

            <th>Country</th>

            <th>State</th>

            <th>Action</th>

        </tr>

    </thead>

</table>

</div>

@endsection
@push('scripts')
<script src="{{ asset('js/state.js') }}"></script>
@endpush