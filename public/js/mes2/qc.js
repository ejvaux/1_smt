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

/* Good Function */
$('.gbtn').on('click',function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Mark as Good!'
        }).then((result) => {            
            if (result.value) {
                $('#userg'+$(this).data('idqc')).val($('meta[name="user_num"]').attr('content'));
                $('#qcGood'+$(this).data('idqc')).trigger('submit');
            }
        })
});


/* No Good Function */
$('.ngbtn').on('click',function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Mark as No Good!'
        }).then((result) => {
            if (result.value) {
                $('#userng'+$(this).data('idqc')).val($('meta[name="user_num"]').attr('content'));
                $('#qcnoGood'+$(this).data('idqc')).trigger('submit');
            }
        })
});

/* Getting Lot Number */

$('.showlot').on('click', function(){        
    $.ajax({
        url: 'cld',
        type:'get',
        data: {
            'lot_id':  $(this).data('lot_id')
        },
        global: false,
        success: function (data) {            
            $('#lotmodaldiv').html(data);
            $('#modalqc').modal('show');
        }
    });
    /* $('#idlot').val($(this).data('idqc'));
    $('#lot_number-modal').val($(this).text());    
    $('#modalqc').modal('show'); */
});
$('#lot-sort').on('change', function(e){
    $('#lot-sort-form').trigger('submit');
});