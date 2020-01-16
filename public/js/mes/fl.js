/* Ajax */
$.ajaxSetup({
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        var msg = '';
        var file = '';
        var line = '';
        if(XMLHttpRequest.responseText != null){
            msg = XMLHttpRequest.responseJSON.message;
            file = XMLHttpRequest.responseJSON.file ;
            line = XMLHttpRequest.responseJSON.line ;
            console.log(XMLHttpRequest.responseText);
            console.log(XMLHttpRequest);
        }
        if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            iziToast.warning({
                title: 'ERROR '+ XMLHttpRequest.status,
                message: XMLHttpRequest.statusText + '<br>' + msg + '<br>' + file + '<br>Line: ' + line,
                position: 'topCenter',
                close: false,
            });
            x[0].pause();
            x[0].currentTime = 0;
            x[0].play();
        }
        else if (XMLHttpRequest.readyState == 0) {                
            // Network error (i.e. connection refused, access denied due to CORS, etc.)
            iziToast.warning({
                title: 'ERROR '+ XMLHttpRequest.status,
                message: 'Network Error',
                position: 'topCenter',
                close: false,
            });
            x[0].pause();
            x[0].currentTime = 0;
            x[0].play();
        }
        else {
            iziToast.warning({
                title: 'ERROR',
                message: 'Unknown Error',
                position: 'topCenter',
                close: false,
            });
            x[0].pause();
            x[0].currentTime = 0;
            x[0].play();
            // something weird is happening
        }
    }
});

/* Variable */
var userID = $('meta[name="user_num"]').attr('content');
/* Auto */
$(document).ready(function(){    
    $('.select2').select2({width: '100%'});
    $('#tabA'+$('#active-table').val()).tab('show');
    /* $('#tabA'+$('#active-table').val()).trigger('click');  */  
});
/* FUNCTIONS */
function viewfeederlist($m_id,$mt_id){
    $.ajax({
        type		: "GET",
        url		    : "/1_smt/public/fldmach/"+ $m_id +"/" + $mt_id,
        success		: function(html) {					
                        $("#fltable").html(html).show('slow');
                    }
    });
}
function loadlinemach(){
    $.get("api/"+uri+"/"+ id, 
        function(data) {
            var model = $('#'+dd);
            model.empty();
            model.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            }
            else{
                model.attr('disabled',true);
                model.append("<option value=''>No Data Found.</option>");
            }            
        });
}

/* EVENTS */
$('#flviewmachine').on('change', function(){
    window.location = "/1_smt/public/fld/" + $('#mdl_id').val() + "/" + $(this).val() + "/" + $('#flviewline').val();
});
$('#flviewline').on('change', function(){
    window.location = "/1_smt/public/fld/" + $('#mdl_id').val() + "/0/" + $(this).val() ;
});
$("#fltable").on('click','.addCmp', function(){
    $('#amodel_id').val($(this).data('model'));
    $('#amachine_type_id').val($(this).data('mach'));
    $('#aline_id').val($(this).data('line'));
    $('#atable_id').val($(this).data('table'));
    $('#add_comp_form').trigger("reset");
    $('#atable_number').text($(this).data('table'));
    $('#auser_id').val($('meta[name="user_num"]').attr('content'));
    $('#add_comp').modal('show');
    $('.sel').select2({width: '100%'});
});
$("#fltable").on('click', '.cmp_edit', function(){
    $('#ecmodel_id').val($(this).data('model'));
    $('#ecmachine_type_id').val($(this).data('mach'));
    $('#ectable_id').val($(this).data('table'));
    $('#ecmounter_id').val($(this).data('mount'));
    $('#ecpos_id').val($(this).data('pos'));
    $('#ecorder_id').val($(this).data('pref'));
    $('#eccomponent_id').val($(this).data('cmp'));
    /* $('#feeder_id').val($(this).data('id')); */
    $('#edit_comp_form').attr('action', '/1_smt/public/feeders/'+$(this).data('id'));
    /* $('#user_id').val($('meta[name="user_num"]').attr('content')); */
    $('#ecuser_id').val(userID);

    $('#table_number').text($(this).data('table'));
    $('#edit_comp').modal('show');
    $('.sel').select2({width: '100%'});
});
$("#fltable").on('click', '.cmp_delete', function(){    
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
            $('#del_com_user_id').val($("meta[name='user_num']").attr('content').replace(/\s+/g, ''));           
            /* alert("||"+$('#del_com_user_id').val()+"||"); */
            $('#del_cmpt').attr('action', '/1_smt/public/feeders/'+$(this).data('id'));
            $('#del_cmpt').trigger('submit');
        }
    })    
});
$("#fdrmodl").on('click','#dd_comp_submit', function(){
    var err = 0;
    var err_msg = '';
    if($('#amounter_id').val() == ''){
        err_msg += 'Mounter is required.<br>';
        err = 1;
    }
    if($('#apos_id').val() == ''){
        err_msg += 'Position is required.<br>';
        err = 1;
    }
    if($('#aorder_id').val() == ''){
        err_msg += 'Preference is required.<br>';
        err = 1;
    }
    if($('#acomponent_id').val() == ''){
        err_msg += 'Component is required.<br>';
        err = 1;
    }
    if( err != 1 ){
        $.ajax(
            {
            method:'POST',
            url:"/1_smt/public/feeders",
            data: 
            {
                /* "_token":           $('meta[name="csrf-token"]').attr('content'), */
                'model_id':         $('#amodel_id').val(),
                'machine_type_id':  $('#amachine_type_id').val(),
                'table_id':         $('#atable_id').val(),
                'mounter_id':       $('#amounter_id').val(),
                'pos_id':           $('#apos_id').val(),
                'order_id':         $('#aorder_id').val(),
                'component_id':     $('#acomponent_id').val(),
                'user_id':          $('meta[name="user_num"]').attr('content')
            },
            success: function(data) {          
                iziToast.success({
                    message: data,
                    position: 'topCenter',
                    timeout: 5000,
                    displayMode: 'replace'
                });
                $('#add_comp').modal('hide');
                location.reload(true);
                /* viewfeederlist($('#mdl_id').val(),$('#flviewmachine').val()); */                
            }
        });
    }
    else{
        iziToast.warning({
            message: err_msg,
            position: 'topCenter',
            timeout: 5000,
            displayMode: 'replace'
        });
    }
});
$("#fdrmodl").on('click','#dit_comp_submit', function(){
    $.ajax(
        {
        method:'PUT',
        url:"/1_smt/public/feeders/"+ $('#feeder_id').val(),
        data: 
        {
            'model_id':         $('#model_id').val(),
            'mounter_id':       $('#mounter_id').val(),
            'pos_id':           $('#pos_id').val(),
            'order_id':         $('#order_id').val(),
            'component_id':     $('#component_id').val(),
            'user_id':          $('meta[name="user_num"]').attr('content')
        },
        success: function(data) {          
            iziToast.success({
                message: data,
                position: 'topCenter',
                timeout: 5000,
                displayMode: 'replace'
            });
            $('#edit_comp').modal('hide');
            location.reload(true);
            /* viewfeederlist($('#mdl_id').val(),$('#flviewmachine').val()); */
        }
    });
});
$('#insert_mach1').on('click', function(){
    if($('#addmachlist').val() != ''){
        $.ajax(
            {
            method:'POST',
            url:"/1_smt/public/feeders",
            global: false,
            data: 
            {
                /* "_token":           $('meta[name="csrf-token"]').attr('content'), */
                'model_id':         $('#mdl_id').val(),
                'machine_type_id':  $('#addmachlist').val(),
                'table_id':         0,
                'mounter_id':       0,
                'pos_id':           0,
                'order_id':         0,
                'component_id':     0,
                'user_id':          $('meta[name="user_num"]').attr('content')
            },
            success: function(data) {          
                /* iziToast.success({
                    message: data,
                    position: 'topCenter',
                    timeout: 5000,
                    displayMode: 'replace'
                }); */
                location.reload(true);
            }
        });
    }
    else{
        iziToast.warning({
            message: 'Please select machine.',
            position: 'topCenter',
            timeout: 5000,
            displayMode: 'replace'
        });
    }
});

/* ADDING MACHINE AND LINE */
/* HIDE/SHOW */
    /* Add Machine and Line */
        $('#insert_ml').on('click', function(){
            $('#amlupdated_by').val($('meta[name="user_num"]').attr('content'));
            $('#add_ml_form').trigger('submit');
        });
/* ADDING BLANK LINE */
$('#insert_line').on('click',function(){
    $('#alupdated_by').val($('meta[name="user_num"]').attr('content'));
    /* alert($('#amupdated_by').val()); */
    $('#add_line_form').trigger('submit');
});
/* HIDE/SHOW */
    /* Add Machine */    
        $('#add_line').on('click', function(){
            /* $('#add_line_input1').hide(); */
            $('#add_ml_input').hide();
            $('#add_line_input2').show();
        });
        $('#cancel_line').on('click', function(){
            $('#add_line_input2').hide();
            /* $('#add_line_input1').show(); */
            $('#add_ml_input').show();
        });
/* ADDING MACHINE */
$('#insert_mach').on('click',function(){
    $('#amupdated_by').val($('meta[name="user_num"]').attr('content'));
    /* alert($('#amupdated_by').val()); */
    $('#add_machine_form').trigger('submit');
});
/* HIDE/SHOW */
    /* transfer mounter */
        $('.transfer_mounter_button').on('click', function(){
            $('#fl_toolbar_'+$(this).data('id')).hide();
            $('#transfer_mounter_inputs_'+$(this).data('id')).show();
        });
        $('.cancel_transfer_mounter').on('click', function(){
            $('#fl_toolbar_'+$(this).data('id')).show();
            $('#transfer_mounter_inputs_'+$(this).data('id')).hide();
        });

    /* delete mounter */
        $('.label_mounter').on('click', function(){
            $('#fl_toolbar_'+$(this).data('id')).hide();
            $('#list_mounter_inputs_'+$(this).data('id')).show();
        });
        $('.cancel_del_mounter').on('click', function(){
            $('#list_mounter_inputs_'+$(this).data('id')).hide();
            $('#fl_toolbar_'+$(this).data('id')).show();
            $('#delmountform').trigger('reset');
        });
    /* Change mounter */
        $('.change_mounter_button').on('click', function(){
            $('#fl_toolbar_'+$(this).data('id')).hide();
            $('#change_mounter_inputs_'+$(this).data('id')).show();
            $('#change_list_mounterto_'+$(this).data('id')).select2({width: '20%'});
        });
        $('.cancel_change_mounter').on('click', function(){
            $('#change_mounter_inputs_'+$(this).data('id')).hide();
            $('#fl_toolbar_'+$(this).data('id')).show();
            $('#change_list_mounterto_'+$(this).data('id')).select2('destroy');
            $('#chngemountform').trigger('reset');
        });
    /* Add Machine */
        $('#add_mach').on('click', function(){
            /* $(this).hide();
            $('#flviewmachine').hide();
            $('#insert_mach').show();
            $('#cancel_mach').show();
            $('#addmachlist').show(); */
            /* $('#add_machine_input1').hide(); */
            $('#add_ml_input').hide();
            $('#add_machine_input2').show();
        });
        $('#cancel_mach').on('click', function(){
            /* $('#add_mach').show();
            $('#flviewmachine').show();
            $('#insert_mach').hide();
            $(this).hide();
            $('#addmachlist').hide(); */
            $('#add_machine_input2').hide();
            /* $('#add_machine_input1').show(); */
            $('#add_ml_input').show();
        });

/* COPY LIST INTO NEW LINE */
/* HIDE/SHOW */
    /* Copy List into New Line */
    $('#copy_new_line').on('click', function(e){
        $('#copy_list').show();
        $('#add_ml_input').hide();
    })
    $('#cancel_copy_list').on('click', function(){
        $('#copy_list').hide();
        $('#add_ml_input').show();
    });

/* DROPDOWN CHANGE EVENT */
    /* transfer mounter */
        $('.transfer_list_mounter').on('change', function(){
            $('#trns_mounter_id').val($(this).val());
        });
        $('.transfer_list_table').on('change', function(){
            $('#trns_table_id_to').val($(this).val());
        });
    /* delete mounter */
        $('.list_mounter').on('change', function(){
            $('#del_mounter_id').val($(this).val());
        });
    /* Change mounter */
        $('.change_list_mounterfrom').on('change', function(){
            $('#exc_mounter_id_from').val($(this).val());
        });
        $('.change_list_mounterto').on('change', function(){
            $('#exc_mounter_id_to').val($(this).val());
        });

/* SENDING FORMS */
    /* transfer mounter */
        $('.transfer_mounter').on('click', function(){
            if($('#trns_mounter_id').val() != '' && $('#trns_table_id_to').val() != ''){
                $('#trns_model_id').val($(this).data('model'));
                $('#trns_line_id').val($(this).data('line'));
                $('#trns_machine_type_id').val($(this).data('mach'));
                $('#trns_table_id').val($(this).data('table'));
                $('#trns_user_id').val($('meta[name="user_num"]').attr('content'));
                $('#transfermountform').trigger('submit');
            }
            else{
                iziToast.warning({
                    message: 'Please complete the empty fields.',
                    position: 'topCenter',
                    timeout: 5000,
                    displayMode: 'replace'
                });
            }
        });        
    /* delete mounter */
        $('.del_mounter').on('click', function(){
            if($('#del_mounter_id').val()){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $('#del_model_id').val($(this).data('model'));
                        $('#del_line_id').val($(this).data('line'));
                        $('#del_machine_type_id').val($(this).data('mach'));
                        $('#del_table_id').val($(this).data('table'));
                        $('#del_user_id').val($('meta[name="user_num"]').attr('content'));
                        $('#delmountform').trigger('submit');
                    }
                })
            }
            else{
                iziToast.warning({
                    message: 'Please select mounter.',
                    position: 'topCenter',
                    timeout: 5000,
                    displayMode: 'replace'
                });
            }
        });
    /* Change mounter */
        $('.change_mounter').on('click', function(){
            if($('#exc_mounter_id_from').val() != '' && $('#exc_mounter_id_to').val() != ''){
                if($('#exc_mounter_id_from').val() != $('#exc_mounter_id_to').val()){
                    $('#exc_model_id').val($(this).data('model'));
                    $('#exc_line_id').val($(this).data('line'));
                    $('#exc_machine_type_id').val($(this).data('mach'));
                    $('#exc_table_id').val($(this).data('table'));
                    $('#exc_mounter_id_from').val($('#exc_mounter_id_from').val());
                    $('#exc_mounter_id_to').val($('#exc_mounter_id_to').val());
                    $('#exc_user_id').val($('meta[name="user_num"]').attr('content'));
                    $('#chngemountform').trigger('submit');
                }
                else{
                    iziToast.warning({
                        message: 'Mounters are identical.',
                        position: 'topCenter',
                        timeout: 5000,
                        displayMode: 'replace'
                    });
                }
            }
            else{
                iziToast.warning({
                    message: 'Please complete the empty fields.',
                    position: 'topCenter',
                    timeout: 5000,
                    displayMode: 'replace'
                });
            }
        });

/* Hide show event */
$('#aorder_id').on('change', function(){
    if($(this).val() == 1){
        $('#usage_div').show();
    }
    else{
        $('#usage_div').hide();
    }
});

/* EDIT USAGE */
$('.cmp_usage').on('click', function(e){
    $('#u_model_id').val($(this).data('model'));
    $('#u_line_id').val($(this).data('line_id'));
    $('#u_machine_type_id').val($(this).data('mach'));
    $('#u_table_id').val($(this).data('table'));
    $('#u_mounter_id').val($(this).data('mounter_id'));
    $('#u_pos_id').val($(this).data('pos_id'));
    $('#u_user_id').val($('meta[name="user_num"]').attr('content'));
    $('#u_usage').val($(this).data('usage'));
    $('#update_usage_modal').modal('show');
});
/* Delete machine */
$('#del_mach').on('click', function(){
    $('#add_ml_input').hide();
    $('#del_machine_input').show();
});
$('#cancel_del_mach').on('click', function(){
    $('#add_ml_input').show();
    $('#del_machine_input').hide();
});
$('#delete_mach').on('click', function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $('#dlupdated_by').val($('meta[name="user_num"]').attr('content'));
            $('#del_machine_form').trigger('submit');
        }
    })
});