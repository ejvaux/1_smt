$('#addmach').on('click', function() {
    /* alert('test'); */
    $('#add_mach_modal').modal('show');
});
$('.deleteMach').on('click', function() {
    
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
            /* alert($(this).data('id')); */
            $('#del_mach_form_'+$(this).data('id')).trigger('submit');
        }
    })    
});