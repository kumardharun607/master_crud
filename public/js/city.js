let table;
$(document).ready(function(){
  table = $('#cityTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: '/city/list',

    columns: [

        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            searchable: false,
            orderable: false
        },

        {
            data: 'country_name',
            name: 'country_name'
        },

        {
            data: 'state_name',
            name: 'state_name'
        },

        {
            data: 'city_name',
            name: 'city_name'
        },

        {
            data: 'action',
            name: 'action',
            searchable: false,
            orderable: false
        }

    ]

});
$('#country_id').change(function(){

    let countryId = $(this).val();

    if(countryId == ''){

        $('#state_id').html('<option value="">Select State</option>');

        return;

    }

    loadStates(countryId);

});
function loadStates(countryId,selectedStateId=null)
{
    $.ajax({

        url:'/states-by-country/'+countryId,

        type:'GET',

        success:function(response){

            let options='<option value="">Select State</option>';

            $.each(response,function(index,state){

                let selected='';

                if(state.id==selectedStateId){

                    selected='selected';

                }

                options += '<option value="'+state.id+'" '+selected+'>'+state.state_name+'</option>';

            });

            $('#state_id').html(options);

        }

    });

}
$('#addCity').click(function(){

    let id = $('#city_id').val();

    if(id == ''){

        addCity();

    }else{

        updateCity(id);

    }

});
function addCity()
{
    $.ajax({

        url:'/city',

        type:'POST',

        data:{

            state_id:$('#state_id').val(),

            city_name:$('#city_name').val(),

            _token:$('meta[name="csrf-token"]').attr('content')

        },

        success:function(response){

            alert(response.message);

            clearForm();

            table.ajax.reload();

        },

        error:function(xhr){

            console.log(xhr.responseJSON);

        }

    });
}
function updateCity(id)
{
    $.ajax({

        url:'/city/'+id,

        type:'PUT',

        data:{

            state_id:$('#state_id').val(),

            city_name:$('#city_name').val(),

            _token:$('meta[name="csrf-token"]').attr('content')

        },

        success:function(response){

            alert(response.message);

            clearForm();

            table.ajax.reload();

        }

    });
}
function clearForm()
{
    $('#city_id').val('');

    $('#country_id').val('');

    $('#state_id').html('<option value="">Select State</option>');

    $('#city_name').val('');

    $('#addCity').text('Add City');
}
$(document).on('click','.editBtn',function(){

    let id = $(this).data('id');

    $.ajax({

        url:'/city/'+id+'/edit',

        type:'GET',

        success:function(response){

            $('#city_id').val(response.data.id);

            $('#country_id').val(response.data.country_id);

            loadStates(response.data.country_id,response.data.state_id);

            $('#city_name').val(response.data.city_name);

            $('#addCity').text('Update City');

        }

    });

});
$(document).on('click','#reset',function(){
    clearForm();
});
$(document).on('click','.deleteBtn',function(){

    let id = $(this).data('id');

    if(confirm('Are you sure you want to delete this city?')){

        $.ajax({

            url:'/city/'+id,

            type:'DELETE',

            data:{
                _token:$('meta[name="csrf-token"]').attr('content')
            },

            success:function(response){

                alert(response.message);

                table.ajax.reload();

            },

            error:function(xhr){

                alert(xhr.responseJSON.message);

            }

        });

    }

});

});