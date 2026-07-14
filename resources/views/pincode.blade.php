@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4>Pincode Management</h4>
        </div>

        <div class="card-body">

            <form id="pincodeForm">

                @csrf

                <input type="hidden" id="id" name="id">

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label>Country</label>

                        <select class="form-control" id="country_id" name="country_id">

                            <option value="">Select Country</option>

                            @foreach($countries as $country)

                                <option value="{{ $country->id }}">
                                    {{ $country->country_name }}
                                </option>

                            @endforeach

                        </select>
                    </div>


                    <div class="col-md-3 mb-3">

                        <label>State</label>

                        <select class="form-control" id="state_id" name="state_id">

                            <option value="">Select State</option>

                        </select>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label>City</label>

                        <select class="form-control" id="city_id" name="city_id">

                            <option value="">Select City</option>

                        </select>

                    </div>


                    <div class="col-md-3 mb-3">

                        <label>Pincode</label>

                        <input type="text"
                               class="form-control"
                               id="pincode"
                               name="pincode"
                               maxlength="6">

                    </div>

                </div>


                <button class="btn btn-success" id="saveBtn">

                    Save

                </button>

                <button type="reset" class="btn btn-secondary">

                    Reset

                </button>

            </form>

        </div>

    </div>

    <br>


    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            Pincode List

        </div>

        <div class="card-body">

            <table class="table table-bordered" id="pincodeTable">

                <thead>

                <tr>

                    <th>S.No</th>

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
<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

@endsection
@push('scripts')

<script>

$(document).ready(function () {

    //=============================
    // Yajra DataTable
    //=============================

    var table = $('#pincodeTable').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('pincodes.datatable') }}",

        columns: [

            {data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false},

            {data:'country', name:'country'},

            {data:'state', name:'state'},

            {data:'city', name:'city'},

            {data:'pincode', name:'pincode'},

            {data:'action', name:'action', orderable:false, searchable:false}

        ]

    });


    //=============================
    // Country -> State
    //=============================

    $('#country_id').change(function(){

        let country_id = $(this).val();

        $('#state_id').html('<option value="">Loading...</option>');

        $('#city_id').html('<option value="">Select City</option>');

        $.ajax({

            url:'/states/'+country_id,

            type:'GET',

            success:function(response){

                $('#state_id').html('<option value="">Select State</option>');

                $.each(response,function(key,value){

                    $('#state_id').append(

                        '<option value="'+value.id+'">'+value.state_name+'</option>'

                    );

                });

            }

        });

    });



    //=============================
    // State -> City
    //=============================

    $('#state_id').change(function(){
        let state_id=$(this).val();
        $('#city_id').html('<option value="">Loading...</option>');
        $.ajax({
            url:'/cities/'+state_id,
            type:'GET',
            success:function(response){
                $('#city_id').html('<option value="">Select City</option>');
                $.each(response,function(key,value){
                    $('#city_id').append(
                        '<option value="'+value.id+'">'+value.city_name+'</option>'
                    );
                });
            }
        });
    });
    //=============================
// Save Pincode
//=============================

$('#pincodeForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: "{{ route('pincodes.store') }}",

        type: "POST",

        data: $(this).serialize(),

        success:function(response){

            alert(response.message);

            $('#pincodeForm')[0].reset();

            $('#state_id').html('<option value="">Select State</option>');

            $('#city_id').html('<option value="">Select City</option>');

            $('#pincodeTable').DataTable().ajax.reload(null,false);

        },

        error:function(xhr){

            let errors = xhr.responseJSON.errors;

            let message = "";

            $.each(errors,function(key,value){

                message += value[0]+"\n";

            });

            alert(message);

        }

    });

});
});

</script>

@endpush