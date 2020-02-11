/* AJAX SETUP */

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
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* ONLOAD FUNCTION */

$(document).ready(function() {
    loadlines();
    localStorage.setItem('ov_jo',0);
});

/* FUNCTIONS */

function loadlines(text, url = 'lineov')
{
    $.ajax({
        type		: "get",
        url		    : url,
        data: {
            'text': text
        },
        /* global: false, */
        success		: function(data) {
            $('#line-table-div').html(data);
        }
    });
}
function loadjo(text, url = 'joov')
{
    $.ajax({
        type		: "get",
        url		    : url,
        data: {
            'text': text
        },
        /* global: false, */
        success		: function(data) {            				
            $('#jo-table-div').html(data);
        }
    });
}

/* EVENTS */

$('#line-table-div').on('click', '.load-line-btn', function(e){
    loadlines();
});
$('#jo-table-div').on('click', '.load-jo-btn', function(e){
    loadjo();    
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href");
    if (target == '#jotab') {
        if(localStorage.getItem('ov_jo') == 0){
            loadjo();
            localStorage.setItem('ov_jo',1);
        }
    }
    /* alert(localStorage.getItem('ov_jo')); */
});