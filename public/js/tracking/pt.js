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
            if(data.bi){
                $('#bi').html(check);
                p += 1;
            }
            else{
                $('#bi').html(times);
            }
            if(data.bo){
                $('#bo').html(check);
                p += 1;
            }
            else{
                $('#bo').html(times);
            }
            if(data.ti){
                $('#ti').html(check);
                p += 1;
            }
            else{
                $('#ti').html(times);
            }
            if(data.to){
                $('#to').html(check);
                p += 1;
            }
            else{
                $('#to').html(times);
            }            
            if(p == 4)
            {
                $('#cardlabel').html(data.sn);
                $('#cardlabel').removeClass('text-danger blinking');
                $('#cardlabel').addClass('text-success');
                a[0].pause();
                a[0].currentTime = 0;
            }
            else{
                $('#cardlabel').html('*** ' + data.sn + ' ***');
                $('#cardlabel').removeClass('text-success');
                $('#cardlabel').addClass('text-danger blinking');
                a[0].pause();
                a[0].currentTime = 0;
                a[0].play();
            }            
            $('#sn').val('');
        }
    });
}
/* EVENTS */
$('#sn').on('keypress', function(e){
    if(e.keyCode == 13)
    {
        checkproc($(this).val());
    }
})
