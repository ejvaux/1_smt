$.ajaxSetup({
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        var msg = '';
        var file = '';
        if(XMLHttpRequest.responseText != null){
            msg = XMLHttpRequest.responseJSON.message;
            file = XMLHttpRequest.responseJSON.file ;
        }
        if (XMLHttpRequest.readyState == 4) {
            // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            iziToast.warning({
                title: 'ERROR '+ XMLHttpRequest.status,
                message: XMLHttpRequest.statusText + '<br>' + msg + '<br>' + file,
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

/* FUNCTIONS */

function loadlrt(date,line)
{
    $.ajax({
        url: 'rt',
        type:'get',
        data: {
            'date':  date,
            'line':  line
        },
        success: function (data) {            
            $('#lr_div').html(data);
        }
    });
}

/* EVENTS */

$('#line1').on('change', function(e){
    loadlrt( $('#date').val(),$('#line').val());
});

$('#date-btn1').on('click', function(e){
    /* if($('#line').val() != ''){
        loadlrt( $('#date').val(),$('#line').val());
    }
    else{
        iziToast.warning({
            message: 'Select Line first',
            position: 'topCenter',
            close: false,
        });
    } */
    loadlrt( $('#date').val(),$('#line').val());
});

$('#export-lr-btn').on('click', function(e){
    $('#export-lr-modal').modal('show');
});