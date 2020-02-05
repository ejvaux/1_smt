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

/* ON-LOAD FUNCTION */

$(document).ready(function() {
    loaddtTable(); 
});

/* FUNCTIONS */

function loaddtTable(text,url = 'defecttypes')
{
    $.ajax({
        type		: "get",
        url		    : url,
        data: {
            'search': text
        },
        /* global: false, */
        success		: function(data) {
            $("html, body").animate({ scrollTop: 0 }, "smooth");				
            $('#defecttype-table-div').html(data);
        }
    });
}
function geteditdata(id)
{
    $.ajax({
        type		: "get",
        url		    : 'defecttypes/'+id,
        global: false,
        success		: function(data) {
            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#edit_id').val(data.id);
            $('#edit_defecttype_modal').modal('show');
        }
    });
}
function adddefecttype(form)
{
    $formdata = form.serialize();
    $.ajax({
        type		: "post",
        url		    : 'defecttypes',
        /* global: false, */
        data: $formdata,
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
            loaddtTable($('#search-tb').val());
            $('#add_defecttype_form').trigger('reset');
            $('#add_defecttype_modal').modal('hide');
        }
    });
}
function updatedefecttype(form,id)
{
    $formdata = form.serialize();
    $.ajax({
        type		: "post",
        url		    : 'defecttypes/'+id,
        /* global: false, */
        data: $formdata,
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
            loaddtTable($('#search-tb').val());
            $('#edit_defecttype_form').trigger('reset');
            $('#edit_defecttype_modal').modal('hide');
        }
    });
}
function deletedefecttype(id){

    $.ajax({
        type		: "POST",
        url		    : 'defecttypes/'+id,
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
            loaddtTable($('#search-tb').val());
        }
    });
}

/* EVENTS */

$('#search-tb').on('keypress', function(e){
    if(e.keyCode == 13){
        $(this).blur();
        loaddtTable($(this).val());
    }
});
$('#defecttype-add-btn').on('click', function(){
    $('#add_defecttype_modal').modal('show');
});
$('#defecttype-table-div').on('click','.defecttype-edit-btn', function(){
    geteditdata($(this).data('id'))
});
$('#add_defecttype_form').on('submit', function(e){
    e.preventDefault();
    adddefecttype($(this));
});
$('#edit_defecttype_form').on('submit', function(e){
    e.preventDefault();
    updatedefecttype($(this),$('#edit_id').val());
});
$('#defecttype-table-div').on('click','.defecttype-delete-btn', function(){
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
            deletedefecttype($(this).data('id'));
        }
    })
});