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
    loadprtable();
    $('input[name="user_id"]').val($('meta[name="user_num"]').attr('content'));    
});

/* FUNCTIONS */

function loadprtable(text,url = 'processes')
{
    $.ajax({
        type		: "get",
        url		    : url,
        data: {
            'text': text
        },
        /* global: false, */
        success		: function(data) {
            $("html, body").animate({ scrollTop: 0 }, "smooth");				
            $('#process-table-div').html(data);
        }
    });
}
function deleteproc(id)
{
    $.ajax({
        type		: "POST",
        url		    : 'processes/'+id,
        data: {
            '_method': 'DELETE'
        },
        success		: function(data) {					
            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            else{
                iziToast.error({
                    message: data,
                    position: 'topCenter'
                });
            }
            loadprtable($('#search-tb').val());
        }
    });
}
function addprocess(){
    var data = $('#add_process_form').serialize();
    $.ajax({
        type		: "POST",
        url		    : 'processes',
        data: data,
        success		: function(data) {					
            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            else{
                iziToast.error({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            loadprtable($('#search-tb').val());
            $('#add_process_form').trigger('reset');
            $('#add_process_modal').modal('hide');
        }
    });
}
function showEditModal(id){
    $.ajax({
        type		: "get",
        url		    : 'processes/'+id+'/edit',
        /* data: {
            'id': id
        }, */
        global: false,
        success		: function(data) {
            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#division_id').val(data.division_id);
            $('#process_id').val(data.id);
            $('#edit_process_modal').modal('show')
        }
    });
}
function updateprocess(id){
    var data = $('#edit_process_form').serialize();
    $.ajax({
        type		: "POST",
        url		    : 'processes/'+id,
        data: data,
        success		: function(data) {					
            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            else{
                iziToast.error({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            loadprtable($('#search-tb').val());
            $('#edit_process_form').trigger('reset');
            $('#edit_process_modal').modal('hide');
        }
    });
}
/* EVENT */

$('#process-add-btn').on('click', function(e){
    $('#add_process_modal').modal('show');
});
$('#add_process_form').on('submit', function(e){
    e.preventDefault();
    addprocess();
});
$('#edit_process_form').on('submit', function(e){
    e.preventDefault();
    updateprocess($('#process_id').val());
});
$('#process-table-div').on('click', '.process-delete-btn', function(e){
    var id = $(this).data('id');
    iziToast.question({
        timeout: false,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        title: 'Are you sure?',
        message: "You won't be able to revert this!",
        position: 'center',
        buttons: [
            ['<button><b>YES</b></button>', function (instance, toast) {
                
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                deleteproc(id);
     
            }, true],
            ['<button>NO</button>', function (instance, toast) {
     
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
     
            }],
        ]
    });
});
$('#process-table-div').on('click', '.pagination a', function(e) {
    e.preventDefault();
    loadprtable('',$(this).attr('href'));
});
$('#search-tb').on('keypress', function(e){
    if(e.keyCode == 13 && $(this).val() != '')
    {
        loadprtable($(this).val());
    }
});
$('#process-table-div').on('click','.process-edit-btn', function(e){
    showEditModal($(this).data('id'));
})