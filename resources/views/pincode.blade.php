@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Heading -->
    <div class="bg-blue-600 text-white rounded-lg shadow mb-6">
        <div class="px-6 py-4">
            <h2 class="text-xl font-bold">
                <i class="fa fa-map-pin mr-2"></i>
                Pincode Management
            </h2>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">

        <form id="pincodeForm">

            @csrf

            <input type="hidden" id="id" name="id">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <!-- Country -->

                <div>

                    <label class="block mb-2 font-semibold">
                        Country
                    </label>

                    <select
                        id="country_id"
                        name="country_id"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

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


                <!-- State -->

                <div>

                    <label class="block mb-2 font-semibold">
                        State
                    </label>

                    <select
                        id="state_id"
                        name="state_id"
                        class="w-full border rounded-lg p-3">

                        <option value="">
                            Select State
                        </option>

                    </select>

                </div>


                <!-- City -->

                <div>

                    <label class="block mb-2 font-semibold">
                        City
                    </label>

                    <select
                        id="city_id"
                        name="city_id"
                        class="w-full border rounded-lg p-3">

                        <option value="">
                            Select City
                        </option>

                    </select>

                </div>


                <!-- Pincode -->

                <div>

                    <label class="block mb-2 font-semibold">
                        Pincode
                    </label>

                    <input
                        type="text"
                        id="pincode"
                        name="pincode"
                        maxlength="6"
                        placeholder="Enter Pincode"
                        class="w-full border rounded-lg p-3">

                </div>

            </div>


            <div class="mt-6 flex gap-3">

                <button
                    id="saveBtn"
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                    <i class="fa fa-save mr-2"></i>

                    Save

                </button>


                <button
                    type="reset"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">

                    Reset

                </button>

            </div>

        </form>

    </div>


    <!-- DataTable -->

    <div class="bg-white rounded-lg shadow">

        <div class="bg-gray-800 text-white px-5 py-3 rounded-t-lg">

            <h3 class="font-bold">

                <i class="fa fa-list mr-2"></i>

                Pincode List

            </h3>

        </div>

        <div class="p-5 overflow-x-auto">

            <table
                id="pincodeTable"
                class="display stripe hover w-full">

                <thead>

                <tr>

                    <th>SI No</th>

                    <th>Country</th>

                    <th>State</th>

                    <th>City</th>

                    <th>Pincode</th>

                    <th>Action</th>

                </tr>

                </thead>

            </table>

        </div>

    </div>

</div>
@endsection

@push('scripts')

<script>

$(document).ready(function () {

    // ==========================
    // Initialize DataTable
    // ==========================

    if ($.fn.DataTable.isDataTable('#pincodeTable')) {
        $('#pincodeTable').DataTable().destroy();
    }

    let table = $('#pincodeTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: {
            url: "{{ route('pincodes.datatable') }}",
            type: "GET"
        },

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },

            {
                data: 'country',
                name: 'country'
            },

            {
                data: 'state',
                name: 'state'
            },

            {
                data: 'city',
                name: 'city'
            },

            {
                data: 'pincode',
                name: 'pincode'
            },

            {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }

        ]

    });




    // ==========================
    // Country -> State
    // ==========================

    $('#country_id').on('change', function () {

        let countryId = $(this).val();

        $('#state_id').html('<option value="">Loading...</option>');
        $('#city_id').html('<option value="">Select City</option>');

        if(countryId==""){

            $('#state_id').html('<option value="">Select State</option>');
            return;

        }

        $.ajax({

            url:'/states/'+countryId,

            type:'GET',

            success:function(response){

                $('#state_id').html('<option value="">Select State</option>');

                $.each(response,function(index,row){

                    $('#state_id').append(

                        '<option value="'+row.id+'">'+row.state_name+'</option>'

                    );

                });

            }

        });

    });





    // ==========================
    // State -> City
    // ==========================

    $('#state_id').on('change', function () {

        let stateId=$(this).val();

        $('#city_id').html('<option value="">Loading...</option>');

        if(stateId==""){

            $('#city_id').html('<option value="">Select City</option>');
            return;

        }

        $.ajax({

            url:'/cities/'+stateId,

            type:'GET',

            success:function(response){

                $('#city_id').html('<option value="">Select City</option>');

                $.each(response,function(index,row){

                    $('#city_id').append(

                        '<option value="'+row.id+'">'+row.city_name+'</option>'

                    );

                });

            }

        });

    });






    // ==========================
    // Save / Update
    // ==========================

    $('#pincodeForm').submit(function(e){

        e.preventDefault();

        let id=$("#id").val();

        let url=id==''

            ? "{{ route('pincodes.store') }}"

            : "/pincodes/update/"+id;

        $.ajax({

            url:url,

            type:'POST',

            data:$(this).serialize(),

            success:function(res){

                alert(res.message);

                $('#pincodeForm')[0].reset();

                $('#id').val('');

                $('#saveBtn').html('<i class="fa fa-save"></i> Save');

                $('#state_id').html('<option>Select State</option>');

                $('#city_id').html('<option>Select City</option>');

                table.ajax.reload(null,false);

            },

            error:function(xhr){

                let errors=xhr.responseJSON.errors;

                let msg='';

                $.each(errors,function(k,v){

                    msg+=v[0]+"\n";

                });

                alert(msg);

            }

        });

    });






    // ==========================
    // Edit
    // ==========================

    $(document).on('click','.editBtn',function(){

        let id=$(this).data('id');

        $.get('/pincodes/edit/'+id,function(res){

            $('#id').val(res.id);

            $('#pincode').val(res.pincode);

            $('#country_id').val(res.city.state.country.id).trigger('change');

            setTimeout(function(){

                $('#state_id').val(res.city.state.id).trigger('change');

            },500);

            setTimeout(function(){

                $('#city_id').val(res.city.id);

            },900);

            $('#saveBtn').html('<i class="fa fa-edit"></i> Update');

        });

    });







    // ==========================
    // Delete
    // ==========================

    $(document).on('click','.deleteBtn',function(){

        if(confirm('Are you sure?')){

            let id=$(this).data('id');

            $.ajax({

                url:'/pincodes/delete/'+id,

                type:'POST',

                data:{

                    _token:'{{ csrf_token() }}',

                    _method:'DELETE'

                },

                success:function(res){

                    alert(res.message);

                    table.ajax.reload(null,false);

                }

            });

        }

    });

});

</script>

@endpush