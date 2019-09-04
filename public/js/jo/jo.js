$('.remcheck').on('click', function(e){
    $id = $(this).attr('id');
    $('#remcheckcol_'+ $id).html('<img src="http://172.16.1.13:8000/1_smt/public/images/loading2.gif" alt="Loading gif" style="height:1.5rem;width:auto;overflow:hidden;margin-top:-4px;padding-left:-10px"> Processing... Please Wait...');
    $.ajax({
        url: 'joqty',
        type:'get',
        data: {
            'joid':  $(this).attr('id')
        },
        global: false,
        success: function (data) {           
            if(data.type == 'success'){
                $('#remcheckcol_'+ $id).html(data.remaining);
            }
            else if(data.type == 'error'){
                iziToast.warning({
                    message: data.message,
                    position: 'topCenter'
                });
            }
            else{
                iziToast.warning({
                    message: 'Error: joqty',
                    position: 'topCenter'
                });
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#remcheckcol_'+ $id).html('<button id="'+ $id +'" class="btn btn-outline-secondary py-0 remcheck">RETRY</button>');
        }
    });
});