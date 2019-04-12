$('#addlinename').on('click', function(){
    $('#add_linename_modal').modal('show');
});

$('.editLinename').on('click', function(){
    $('#ename').val($(this).data('name'));
    $('#edit_linename_form').attr('action', '/1_smt/public/linenames/'+$(this).data('id'));
    $('#edit_linename_modal').modal('show');
});

$('.deleteLinename').on('click', function(){
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
            $('#del_linename_form_'+$(this).data('id')).trigger('submit');
        }
    })
});