/* FUNCTIONS */
function loadreel($sn){
    $.ajax({
        url: 'loadreel',
        type:'get',
        data: {
            'sn':  $sn
        },
        success: function (data) {           
            $('#sntTableDiv').html(data);
            /* $('#snhead').html($('#snTB').val());
            $('#snTB').val(''); */
            /* if ($('#snhead').html() != '') { */
            if ($('#snhead').val() != '') {
                $('#serialExport').val($('#snhead').html());
                $('#snhead1').html($('#snTB').val());
                /* $('#exportBtn').attr('disabled',false); */
                $('#exportBtn').show();
            }
            else{
                $('#exportBtn').hide();
                $('#snhead1').html('');
            }
            $('#snTB').val('');
        }
    });    
}

function loadsn($reel){
    $.ajax({
        url: 'loadsn',
        type:'get',
        data: {
            'rid':  $reel
        },
        success: function (data) {           
            $('#reelTableDiv').html(data);
            if ($('#reelhead').val() != '') {
                $('#reelExport').val($('#reelhead').html());
                $('#reelhead1').html($('#reelTB').val());
                $('#reelexportBtn').show();
            }
            else{
                $('#reelexportBtn').hide();
                $('#reelhead1').html('');
            }
            $('#reelTB').val('');
        }
    });    
}

/* EVENTS */
$('#snTB').on('keypress', function(e){
    if (e.keyCode == 13){
        loadreel(this.value);
    }
});
$('#reelTB').on('keypress', function(e){
    if (e.keyCode == 13){
        loadsn(this.value);
    }
});