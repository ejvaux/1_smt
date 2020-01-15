// Ajax Setup
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

// Variable
var activeTab = '';

// Functions
function acttab(){
    if(activeTab){
        $('#mll_tab a[href="' + activeTab + '"]').tab('show');
    }
}
function loadlist(line){
    $.ajax({
        url: 'mload',
        type:'get',
        data: {
            'line':  line
        },
        success: function (data) {            
            $('#ml_div').html(data);
            acttab();
        }
    });
}

function matcompdel(line, model, key){
    $.ajax({
        url: 'matcompdel',
        type:'get',
        data: {
            'line':  line,
            'model':  model,
            'key': key
        },
        global: false,
        success: function (data) {    
            if(data.type == 'success'){
                /* loadlist(line);
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                }); */
                $.ajax({
                    url: 'mload',
                    type:'get',
                    data: {
                        'line':  line
                    },
                    success: function (data) {            
                        $('#ml_div').html(data);
                        acttab();
                        iziToast.success({
                            message: 'Meterial Successfully deleted.',
                            position: 'topCenter'
                        });
                    }
                });
            }
            else{
                iziToast.error({
                    message: data.message,
                    position: 'topCenter'
                });
                /* alert(JSON.stringify(data.message)); */
            }    
            
        }
    });
}

// Events

$('#ml_div').on('show.bs.tab','a[data-toggle="tab"]', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    activeTab = localStorage.getItem('activeTab');
});

$('#ml-btn-submit').on('click', function(){
    if ($('#line').val()) {
        loadlist($('#line').val());
    }
    else{
        iziToast.error({
            title: 'ERROR',
            position: 'topCenter',
            message: 'Select Line First.',
        });
    }    
});
$('#ml_div').on('click', '.delMat', function(e){
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
            /* alert(JSON.stringify($(this).data('id'))); */
            matcompdel($("#ml_line").val(),$("#ml_model").val(),$(this).data('id'));
            /* iziToast.success({
                message: 'Material successfully deleted.',
                position: 'topCenter'
            }); */
          /* swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
          alert($(this).data('id'));
          alert($("#ml_line").val());
          alert($("#ml_model").val()); */
        }
      })
});