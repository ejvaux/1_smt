/* ---------- AJAX SETUP ---------- */
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

$('#pcb-search-textbox').focus();

/* ---------- E V E N T S ---------- */
$('#pcb-search-textbox').on('keypress', function(e){
    if(e.keyCode == 13){
        if($(this).val() != ''){
            $.ajax({
                url: 'tracking',
                type:'get',
                data: {
                    'sn':  $(this).val()
                },
                success: function (data) {
                    $('#pcbtablediv').html(data);
                }
            });
            $(this).val('');
        }        
    }
});