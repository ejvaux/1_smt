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
/* VARIABLES */
var check = '<i class="fas fa-check text-success"></i>';
var times = '<i class="fas fa-times text-danger"></i>';
var x = $('#e_sound');
var y = $('#s_sound');
var a = $('#a_sound');
/* FUNCTIONS */
function checkproc(sn){
    var p = 0;
    $.ajax({
        url: 'ptcheck',
        type:'get',
        data: {
            'sn':  sn
        },
        success: function (data) {
            /* alert(JSON.stringify(data)); */
            if(data.bi){
                $('#bi').html(check);
                p += 1;
                if(data.bi.defect == 0){
                    $('#dbi').html('<span class="text-success font-weight-bold">GOOD</span>');
                }
                else{
                    $('#dbi').html('<span class="text-danger font-weight-bold">NG</span>');
                }
            }
            else{
                $('#bi').html(times);
                $('#dbi').html('-');
            }
            if(data.bo){
                $('#bo').html(check);
                p += 1;
                if(data.bi.defect == 0){
                    $('#dbo').html('<span class="text-success font-weight-bold">GOOD</span>');
                }
                else{
                    $('#dbo').html('<span class="text-danger font-weight-bold">NG</span>');
                }
            }
            else{
                $('#bo').html(times);
                $('#dbo').html('-');
            }
            if(data.ti){
                $('#ti').html(check);
                p += 1;
                if(data.bi.defect == 0){
                    $('#dti').html('<span class="text-success font-weight-bold">GOOD</span>');
                }
                else{
                    $('#dti').html('<span class="text-danger font-weight-bold">NG</span>');
                }
            }
            else{
                $('#ti').html(times);
                $('#dti').html('-');
            }
            if(data.to){
                $('#to').html(check);
                p += 1;
                if(data.bi.defect == 0){
                    $('#dto').html('<span class="text-success font-weight-bold">GOOD</span>');
                }
                else{
                    $('#dto').html('<span class="text-danger font-weight-bold">NG</span>');
                }
            }
            else{
                $('#to').html(times);
                $('#dto').html('-');
            }            
            if(p == 4)
            {
                $('#cardlabel').html(data.sn);
                $('#cardlabel').removeClass('text-danger blinking');
                $('#cardlabel').addClass('text-success');
            }
            else{
                swal.fire({
                    type: 'warning',
                    title: 'PROCESS INCOMPLETE',
                    allowOutsideClick: false
                });

                $('#cardlabel').html('*** ' + data.sn + ' ***');
                $('#cardlabel').removeClass('text-success');
                $('#cardlabel').addClass('text-danger blinking');
                /* $('#sn').focus(); */
                $('.swal2-confirm').blur();
                x[0].pause();
                x[0].currentTime = 0;
                x[0].play();
            }            
            $('#sn').val('');
        }
    });
}
/* EVENTS */
$('#sn').on('keypress', function(e){
    if(e.keyCode == 13)
    {
        if($(this).val()){
            checkproc($(this).val());
        }        
    }
})
