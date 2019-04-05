$('#addlinemach').on('click', function(){
    $('#amachine_id').select2({width: '100%'});    
    $('#add_line_modal').modal('show');
});

$('.editLine').on('click', function(){
    $('#code').val($(this).data('code'));
    $('#machine_id').val($(this).data('machine'));
    $('#edit_line_form').attr('action', '/1_smt/public/lines/'+$(this).data('id'));
    $('#edit_line_modal').modal('show');
});

$('.deleteLine').on('click', function(){
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {            
            $('#del_line_form_'+$(this).data('id')).trigger('submit');
        }
    })
});