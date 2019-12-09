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

/* E V E N T */
$('#line_mscan_button').on('click', function(e){
    loadlineconfig();
    $('#lineconfig_mscan_modal').modal('show');
});
$('#lineconfig_mscan_submit').on('click',function(e){
    lineconfigUpdate();
})