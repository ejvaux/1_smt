$('#addComponent').on('click', function(){
    $('#user_id').val($('meta[name="user_num"]').attr('content'));
    $('#add_new_comp_modal').modal('show');
});
$('.deleteComponent').on('click', function(){    
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
            $('#del_comp_form_'+$(this).data('id')).trigger('submit');
        }
    })
});
$('.editComponent').on('click', function(){
    $('#eproduct_number').val($(this).data('pn'));
    $('#eauthorized_vendor').val($(this).data('av'));
    $('#evendor_pn').val($(this).data('vpn'));
    $('#user_id').val($('meta[name="user_num"]').attr('content'));
    $('#edit_comp_form').attr('action', '/1_smt/public/components/'+$(this).data('id'));
    $('#edit_comp_details').modal('show');
});
