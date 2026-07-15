$(document).ready(function () {

    
let table = $('#stateTable').DataTable({

    processing: true,

    serverSide: true,

    ajax: '/state/list',

    columns: [

        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            searchable: false,
            orderable: false
        },

        {
            data: 'country_name',
            name: 'country.country_name'
        },

        {
            data: 'state_name',
            name: 'state_name'
        },

        {
            data: 'action',
            name: 'action',
            searchable: false,
            orderable: false
        }

    ]

});
$('#addState').click(function(){

    let id=$('#state_id').val();

    if(id==""){

        addState();

    }

    else{
            
        updateState(id);

    }

});
function addState(){

    $.ajax({

        url:'/state',

        type:'POST',

        data:{

            country_id:$('#country_id').val(),

            state_name:$('#state_name').val(),

            _token:$('meta[name="csrf-token"]').attr('content')

        },

        success:function(response){

            alert(response.message);

            clearForm();

            table.ajax.reload();

        }

    });

}
$(document).on('click','#reset',function(){
    clearForm();
});
function updateState(id){

    $.ajax({

        url:'/state/'+id,

        type:'PUT',

        data:{

            country_id:$('#country_id').val(),

            state_name:$('#state_name').val(),

            _token:$('meta[name="csrf-token"]').attr('content')

        },

        success:function(response){

            alert(response.message);

            clearForm();

            table.ajax.reload();

        }

    });

}
function clearForm(){

    $('#state_id').val('');

    $('#country_id').val('');

    $('#state_name').val('');

    $('#addState').text('Add State');

}
$(document).on('click','.editBtn',function(){

    let id=$(this).data('id');

    $.ajax({

        url:'/state/'+id+'/edit',

        type:'GET',

        success:function(response){

            $('#state_id').val(response.data.id);

            $('#country_id').val(response.data.country_id);

            $('#state_name').val(response.data.state_name);

            $('#addState').text('Update State');

        }

    });

});
$(document).on('click', '.deleteBtn', function () {

    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this state?')) {

        $.ajax({

            url: '/state/' + id,

            type: 'DELETE',

            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {

                alert(response.message);

                table.ajax.reload();

            },

            error: function (xhr) {

                alert(xhr.responseJSON.message);

            }

        });

    }

});
});