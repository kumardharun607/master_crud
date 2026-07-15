@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow-md p-6">

    <h2 class="text-2xl font-bold mb-6">
        Country Master
    </h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ isset($country) ? url('/country/update/'.$country->id) : url('/country/store') }}" method="POST">

        @csrf

        <div class="mb-4">

            <label class="block font-semibold mb-2">
                Country Name
            </label>

            <input
                type="text"
                name="country_name"
                value="{{ isset($country) ? $country->country_name : old('country_name') }}"
                placeholder="Enter Country Name"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            @error('country_name')
                <p class="text-red-500 mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

            {{ isset($country) ? 'Update' : 'Save' }}

        </button>

        @if(isset($country))

            <a href="/country"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded ml-2">

                Cancel

            </a>

        @endif

    </form>

</div>

<div class="bg-white rounded-lg shadow-md p-6 mt-8">

    <table class="w-full border border-gray-300">

        <thead>

            <tr class="bg-gray-200">

                <th class="border p-3">ID</th>

                <th class="border p-3">Country Name</th>

                <th class="border p-3 text-center">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($countries as $country)

                <tr>

                    <td class="border p-3">
                        {{ $country->id }}
                    </td>

                    <td class="border p-3">
                        {{ $country->country_name }}
                    </td>

                    <td class="border p-3 text-center">

                        <a href="/country/edit/{{ $country->id }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                            Edit

                        </a>

                        <a href="/country/delete/{{ $country->id }}"
                           onclick="return confirm('Are you sure you want to delete this country?')"
                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded ml-2">

                            Delete

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3" class="text-center p-4 text-gray-500">

                        No Countries Found

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection