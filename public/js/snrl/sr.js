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

function loadpn($pn){
    $.ajax({
        url: 'loadpn',
        type:'get',
        data: {
            'pn':  $pn
        },
        success: function (data) {           
            $('#pnTableDiv').html(data);
            if ($('#pnhead').val() != '') {
                $('#pnExport').val($('#pnhead').html());
                $('#pnhead1').html($('#pnTB').val());
                $('#pnexportBtn').show();
            }
            else{
                $('#pnexportBtn').hide();
                $('#pnhead1').html('');
            }
            $('#pnTB').val('');
        }
    });    
}

function loadsnpn($sn,$cid){
    $.ajax({
        url: 'loadsnpn',
        type:'get',
        data: {
            'sn':  $sn,
            'cid': $cid
        },
        success: function (data) {           
            $('#snpnTableDiv').html(data);
            if ($('#snpnhead').val() != '') {
                $('#snpnExport').val($('#snpnhead').html());
                $('#snpnhead1').html($('#snpnhead').val());
                $('#snpnexportBtn').show();
            }
            else{
                $('#snpnexportBtn').hide();
                $('#snpnhead1').html('');
            }
            $('#snpnTB').val('');
        }
    });    
}

/* EVENTS */
$('#snTB').on('keypress', function(e){
    if (e.keyCode == 13){
        if(this.value != ''){
            loadreel(this.value);
        }        
    }
});
$('#reelTB').on('keypress', function(e){
    if (e.keyCode == 13){
        if(this.value != ''){
            loadsn(this.value);
        }        
    }
});
$('#pnTB').on('keypress', function(e){
    if (e.keyCode == 13){
        if(this.value != ''){
            loadpn(this.value);
        }        
    }
});
$('#snpnTB').on('keypress', function(e){
    if (e.keyCode == 13){
        if($('#snpnDD').val() == ''){
            iziToast.warning({
                message: 'Please select P/N',
                position: 'topCenter'
            });
        }
        else{
            if(this.value != ''){
                loadsnpn(this.value,$('#snpnDD').val());
            }            
        }        
    }
});