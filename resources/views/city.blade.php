@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-6">
        Create City
    </h2>

    <div class="grid grid-cols-4 gap-4">

        <div>

            <label class="font-semibold">
                Country
            </label>

            <select
                id="country_id"
                class="w-full border rounded p-2">

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
                State
            </label>

            <select
                id="state_id"
                class="w-full border rounded p-2">

                <option value="">
                    Select State
                </option>

            </select>

        </div>

        <div>

            <label class="font-semibold">
                City Name
            </label>

            <input
                type="text"
                id="city_name"
                class="w-full border rounded p-2">

        </div>

        <div class="flex items-end">

            <button
                id="addCity"
                class="bg-blue-600 text-white px-6 py-2 rounded">

                Add City

            </button>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/city.js') }}"></script>
@endpush