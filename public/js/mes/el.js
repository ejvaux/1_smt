$('.editEmployee').on('click', function(){
    /* alert('Test'); */
    $('#fname').val($(this).data('fn'));
    $('#lname').val($(this).data('ln'));
    $('#edit_emp_details').modal('show');
});
$('.deleteEmployee').on('click', function(){    
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
            alert('delete');
            /* $('#del_comp_form_'+$(this).data('id')).trigger('submit'); */
        }
    })
});