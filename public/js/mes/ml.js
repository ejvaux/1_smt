$('#add_model_button').on('click', function() {
    $('#user_id').val($('meta[name="user_num"]').attr('content'));
    $('#add_model_mod').modal('show');
});