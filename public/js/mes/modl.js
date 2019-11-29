/* variable */
var userID = $('meta[name="user_num"]').attr('content');

/* Function */
function loadlineconfig(){
    $.ajax({
        url: 'lcl',
        type:'get',
        success: function (data) {
            $('#lctable-div').html(data);
            $('.sel').select2({width: '100%'});
        }
    });
}
function lineconfigUpdate(){
    var formdata = $('#line_config_form').serialize();
    $.ajax({
        url: 'lcu',
        type:'post',
        data: formdata,
        success: function (data) {            
            /* alert(JSON.stringify(data)); */
            /* alert(data); */
            if(data.type == 'success'){
                $('#line_config_modal').modal('hide');              
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            else if(data.type == 'error'){
                iziToast.warning({
                    message: data.message,
                    position: 'topCenter'
                });
            }
        }
    });
    /* alert(formdata); */
}

/* Event */
$('#add_model_button').on('click', function() {
    $('#user_id').val($('meta[name="user_num"]').attr('content'));
    $('#add_model_mod').modal('show');
});
$('#line_button').on('click',function(e){
    loadlineconfig();
    $('#ub_lc').val(userID);
    $('#line_config_modal').modal('show');
});
$('#line_config_submit').on('click',function(e){
    lineconfigUpdate();
})