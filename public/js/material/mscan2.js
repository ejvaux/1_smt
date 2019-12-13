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
        }
        else if (XMLHttpRequest.readyState == 0) {                
            // Network error (i.e. connection refused, access denied due to CORS, etc.)
            iziToast.warning({
                title: 'ERROR '+ XMLHttpRequest.status,
                message: 'Network Error',
                position: 'topCenter',
                close: false,
            });
        }
        else {
            iziToast.warning({
                title: 'ERROR',
                message: 'Unknown Error',
                position: 'topCenter',
                close: false,
            });
            // something weird is happening
        }
    }
});
/* F U N C T I O N S */
function loadlineconfig(){
    $.ajax({
        url: 'lcl',
        type:'get',
        global: false,
        success: function (data) {
            $('#lctable-div').html(data);
            $('.sel').select2({width: '100%'});
        }
    });
}
function lineconfigUpdate(){
    var formdata = $('#lineconfig_mscan_form').serialize();
    $.ajax({
        url: 'lcu',
        type:'post',
        data: formdata,
        success: function (data) {            
            /* alert(JSON.stringify(data)); */
            /* alert(data); */
            if(data.type == 'success'){
                $('#lineconfig_mscan_modal').modal('hide');              
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
function verifyemployee(pin)
{
    $('#rep_scan_emp').val('Please Wait . . .');
    $('#rep_scan_emp').attr('disabled', true);
    chck = 1;
    $.ajax({
        url: 'api/scanpinemp',
        type:'GET',
        data:{
            'pin': pin,
            'check' : chck
        },
        global: false,
        success: function (data) {
            if(data != 0)
            {
                $('#rep_scan_emp').val(data.fname + ' ' + data.lname);
                $('#employee_id').val(data.id);                
            }
            else
            {
                $('#rep_scan_emp').attr('disabled', false);
                $('#rep_scan_emp').val('');
                $('#rep_scan_emp').focus();
                iziToast.warning({
                    title: 'ERROR',
                    message: 'Employee not found!',
                    position: 'topCenter'
                });                
            }
        }
    });
}
function loadreplenish(line){
    $.ajax({
        url: 'loadreplenish',
        type:'get',
        data:{
            'line_id': line
        },
        /* global: false, */
        success: function (data) {
            $('#replenish-div').html(data);
        }
    });
}
function checkreplenish(qr,id,eid){
    $.ajax({
        url: 'checkreplenish',
        type:'get',
        data:{
            'id' : id,
            'qr' : qr,
            'eid' : eid
        },
        /* global: false, */
        success: function (data) {
            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
                loadreplenish($('#line_id_rep').val());
            }
            else if(data.type == 'error'){
                iziToast.warning({
                    message: data.message,
                    position: 'topCenter'
                });
                $('.qr-scan').val('');
            }            
        }
    });
}

/* E V E N T */
$('#line_mscan_button').on('click', function(e){
    loadlineconfig();
    $('#lineconfig_mscan_modal').modal('show');
});
$('#lineconfig_mscan_submit').on('click',function(e){
    lineconfigUpdate();
})
$('#rep_scan_emp').on('keypress', function(e){
    if(e.keyCode == 13)
    {
        verifyemployee($('#rep_scan_emp').val());
    }
});
$('#emp-reset-btn').on('click', function(){
    $('#rep_scan_emp').attr('disabled', false);
    $('#rep_scan_emp').val('');
    $('#rep_scan_emp').focus();
});
$('#replenish-refresh-btn').on('click', function(e){
    loadreplenish($('#line_id_rep').val());
});
$('#replenish-div').on('keypress','.qr-scan', function(e){
    if(e.keyCode == 13)
    {
        checkreplenish($(this).val(),$(this).data('id'),$('#employee_id').val());
    }
});