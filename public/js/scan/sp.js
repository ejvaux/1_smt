/* ---------- AJAX SETUP ---------- */
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
/* ---------- VARIABLES ---------- */
var configlock = 0;
var WOset = 0;
var empset = 0;
var lotset = 0;
var x = $('#e_sound');
var y = $('#s_sound');
/* ---------- LOAD FUNCTIONS ---------- */
if($('#_type').length){
    if ($('#_type').val() == 0) {
        $('#pcb_input').prop('checked',true);
        /* $('#pcb_input').bootstrapToggle('on'); */
        $('#pcb_input').bootstrapToggle('disable')
    } 
    else if ($('#_type').val() == 1) {
        $('#pcb_input').prop('checked',false);
        /* $('#pcb_input').bootstrapToggle('off'); */
        $('#pcb_input').bootstrapToggle('disable')
    }    
}
if($('#_div').length){
    $('#pcb_line_id').attr('disabled',false);
    $('#pcb_process_id').attr('disabled',false);
}
/* if($('#_line').length){
    $('#pcb_line_id').attr('disabled',false);
    $('#pcb_process_id').attr('disabled',false);
} */
/* ---------- FUNCTIONS ---------- */
function scanddload(uri,id,dd,val,dis){
    $.get("api/"+uri+"/"+ id, 
        function(data) {
            var model = $('#'+dd);
            model.empty();
            model.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            }
            else{
                model.attr('disabled',true);
                model.append("<option value=''>NO DATA FOUND</option>");
            }            
        });    
}
function verifyemployee(pin)
{
    $('#scan_employee').val('Please Wait . . .');
    $('#scan_employee').attr('readonly', true);
    chck = 1;

    /* $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); */
    $.ajax({
        url: 'api/scanpinemp',
        type:'GET',
        /* global: false, */
        data:{
            'pin': pin,
            'check' : chck
        },
        success: function (data) {
            if(data != 0)
            {
                $('#scan_employee').hide();
                $('#scan_name').val(data.fname + ' ' + data.lname);
                $('#employee_id').val(data.id);
                $('#scan_name_div').show();
                $('#division_id').focus();
                empset = 1;
                /* form input insert */
                $('#scanform-employee_id').val(data.id);

                /* check scan status */
                checkscan();

                /* iziToast.success({
                    title: 'SUCCESS',
                    message: 'Employee found.',
                    position: 'topCenter'
                }); */
            }
            else
            {
                resetemp();
                iziToast.warning({
                    title: 'ERROR',
                    message: 'Employee not found!',
                    position: 'topCenter'
                });                
            }
        },
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
            resetemp();
        }
    });
}
function serialscan()
{
    var formdata = $('#serial-scan-form').serialize();
    /* alert(JSON.stringify(formdata)); */
    $.ajax({
        url: 'api/scanserial',
        type:'post',
        data: formdata,
        global: false,
        success: function (data) {            
            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
                y[0].pause();
                y[0].currentTime = 0;
                y[0].play();
            }
            else if(data.type == 'error'){
                iziToast.warning({
                    message: data.message,
                    position: 'topCenter'
                });
                x[0].pause();
                x[0].currentTime = 0;
                x[0].play();
            }
            else{
                iziToast.warning({
                    message: data,
                    position: 'topCenter'
                });
                x[0].pause();
                x[0].currentTime = 0;
                x[0].play();
            }
            /* Reload Pcb table */
            /* loadpcbtable('',$('#scanform-type').val(),$('#scanform-div_process_id').val()); */
            /* getscantotal($('#scanform-jo_id').val()); */
        }/* ,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.readyState == 4) {
                // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                iziToast.warning({
                    title: 'ERROR '+ XMLHttpRequest.status,
                    message: XMLHttpRequest.statusText,
                    position: 'topCenter'
                });
            }
            else if (XMLHttpRequest.readyState == 0) {                
                // Network error (i.e. connection refused, access denied due to CORS, etc.)
                iziToast.warning({
                    title: 'ERROR '+ XMLHttpRequest.status,
                    message: XMLHttpRequest.statusText,
                    position: 'topCenter'
                });
            }
            else {
                iziToast.warning({
                    title: 'ERROR',
                    message: 'Unknown Error',
                    position: 'topCenter'
                });
                // something weird is happening
            }
        } */
    });
}
function resetemp()
{
    $('#scan_employee').val('');
    $('#employee_id').val('');
    $('#scan_employee').attr('readonly', false);
    $('#scan_name_div').hide();
    $('#scan_employee').show();
    $('#scan_employee').focus();
    empset = 0;
    /* check scan status */
    checkscan();
}
function setWO(wo){
    /* checkscan(); */
    $('#info_btnWO').removeClass('d-none');
    $('#wo-wonumber').val(wo.SALES_ORDER).addClass('pcbconfig');
    $('#jo_id').val(wo.ID).addClass('pcbconfig');
    $('#wo-number').val(wo.JOB_ORDER_NO).addClass('pcbconfig');
    $('#wo-quantity').val(wo.PLAN_QTY).addClass('pcbconfig');
    $('#wo-pcode').val(wo.ITEM_CODE).addClass('pcbconfig');
    $('#wo-pname').val(wo.ITEM_NAME).addClass('pcbconfig');
    $('#wo-rem').val('').addClass('pcbconfig');
    $('#wo-input').addClass('pcbconfig');
    $('#wo-output').addClass('pcbconfig');

    /* form input insert */
    $('#scanform-jo_id').val(wo.ID);
    $('#scanform-jo_number').val(wo.JOB_ORDER_NO);
    $('#scanform-work_order').val(wo.SALES_ORDER);

    WOset = 1;

    /* enable button on wo */
    $('#reload-wo-total').attr('disabled',false);
    $('#unsetWO').attr('disabled',false);

    /* Change tab */
    $('#serntab').tab('show');

    /* Collapse Config */
    $('#collapseConfig').collapse('hide');

    /* Load PCB */
    loadpcbtable('',$('#scanform-type').val(),$('#scanform-div_process_id').val());

    /* Get Lot Config */
    lotconfig(wo.ITEM_CODE);

    /* Get Lot Number */
    //getlotnumber($('#scanform-jo_id').val());

    /* Show Lot Number Panel */
    //showlotnumberpanel();
}
function unsetWO(){
    disablescan();
    $('#info_btnWO').addClass('d-none');
    $('#wo-wonumber').val('').removeClass('pcbconfig');
    $('#jo_id').val('').removeClass('pcbconfig');
    $('#wo-number').val('').removeClass('pcbconfig');
    $('#wo-quantity').val('').removeClass('pcbconfig');
    $('#wo-pcode').val('').removeClass('pcbconfig');
    $('#wo-pname').val('').removeClass('pcbconfig');
    $('#wo-rem').val('').removeClass('pcbconfig').removeClass('pcbconfigred');
    $('#wo-input').val('').removeClass('pcbconfig');
    $('#wo-output').val('').removeClass('pcbconfig');

    /* form input reset */
    $('#scanform-jo_id').val('');
    $('#scanform-jo_number').val('');
    $('#scanform-lot_id').val('');
    $('#lot_num').val('Check First.');
    $('#lot_total').val('');
    $('#close_lot_num').attr('disabled',false);
    $('#create_lot_num').attr('disabled',true);

    WOset = 0;
    lotset = 0;

    /* disable button on wo */
    $('#reload-wo-total').attr('disabled',true);
    $('#unsetWO').attr('disabled',true);

    /* check scan status */
    checkscan();

    /* load scan total emp table */
    loadscantotalemp(0);

    /* Hide Lot Number Panel */
    $('#close_lot_num').attr('disabled',true);
    $('#lot_panel').hide();
}
function disablescan(msg){
    $('#scanstatuslabel').html('Set: ' + msg).removeClass('text-success').addClass('text-danger');
    $('#scan_serial').removeClass('border-success').attr('disabled',true);
}
function enablescan(){
    $('#scanstatuslabel').html('READY TO SCAN. . .').removeClass('text-danger').addClass('text-success');
    $('#scan_serial').removeAttr('disabled').addClass('border-success');
}
function checkscan(){
    var chk = 0;
    var msg = '';
    if(configlock == 0){
        chk = 1;
        msg = '[Configuration] ';
    }
    if(empset == 0){
        chk = 1;
        msg += '[Employee] ';
    }
    if(WOset == 0){
        chk = 1;
        msg += '[Work Order] ';
    }

    /* if($('#scanform-type').val()==1 && $('#scanform-jo_id').val() != ''){
        if($('#scanform-div_process_id').val()==5 || $('#lc-input').val() == $('#scanform-div_process_id').val() ){
            if(lotset == 0){
                chk = 1;
                msg += '[Lot Number] ';
            }
            else{

            }
            $('#lot_panel').show();   
        }
    } */

    if($('#scanform-type').val()==1){
        if($('#scanform-div_process_id').val()==5 || $('#lc-input').val() == $('#scanform-div_process_id').val() ){
            if(lotset == 0){
                chk = 1;
                msg += '[Lot Number] ';
            }
            $('#lot_panel').show();   
        }
    }
    
    if(!chk){
        enablescan();
    }
    else{
        disablescan(msg);
    }
}
function loadwotable(){
    if(configlock == 1){
        $div = $('#pcb_division_id').val();
        $dte = $('#woDate').val();
        $line = $('#pcb_line_id option:selected').text();
        $.ajax({
            url: 'api/loadWOtable',
            type:'get',
            data: {
                'div':  $div,
                'dte':  $dte,
                'line': $line
            },
            global: false,
            success: function (data) {           
                $('#spTablediv').html(data);
                $('#setWO').addClass('d-none');
            }
        });
        /* $.get("api/loadWOtable",
            { 
                div:  $div,
                dte: $dte
            }, 
            function(data) {
                $('#spTablediv').html(data);
                $('#setWO').addClass('d-none');    
            }); */
    }else{
        iziToast.warning({
            message: 'Lock the Configuration First.',
            position: 'topCenter'
        });
    }
}
function loadpcbtable(txt = '',type,proc,url = "api/loadpcbtable"){
    if($('#scanform-jo_id').val() != ''){
        $jo_id = $('#scanform-jo_id').val();
        $.ajax({
            url: url,
            type:'get',
            data: {
                'jo_id':  $jo_id,
                'sn': txt,
                'type': type,
                'proc': proc
            },
            global: false,
            success: function (data) {           
                $('#pcbtable_div').html(data);
            }
        });

        /* $.get(url,
        { 
            jo_id:  $jo_id,
            sn: txt,
            type: type,
            proc: proc
        }, 
        function(data) {
            $('#pcbtable_div').html(data);   
        }); */
        getscantotal($('#scanform-jo_id').val());        
    }
    else{
        iziToast.warning({
            message: 'No Work Order Set.',
            position: 'topCenter'
        });
    }
}
function getscantotal(wo){
    $.ajax({
        url: 'api/totalscan',
        type:'get',
        data: {
            'jo':  wo,
        },
        global: false,
        success: function (data) {           
            $('#wo-input').val(data.in);
            $('#wo-output').val(data.out);
            if(data.total>0){
                /* $('#wo-rem').val(data.total); */
                $('#wo-rem').val(data.total).removeClass('text-pcbconfigred').addClass('pcbconfig');
                /* $('#wo-rem').val('').addClass('pcbconfig'); */                               
            }
            else{
                $('#wo-rem').val(data.total).addClass('pcbconfigred');
                $('#scanstatuslabel').html('Plan Quantity Reached!').removeClass('text-success').addClass('text-danger');
                $('#scan_serial').removeClass('border-success').attr('disabled',true);
            }
            if(data.total_in>=0){
                $('#wo-input').removeClass('pcbconfigred').addClass('pcbconfig');
            }
            else{
                $('#wo-input').addClass('pcbconfigred');
            }
            checkscan();
        }
    });
    /* $.get("api/totalscan",
        { 
            jo:  wo
        }, 
        function(data) {
            $('#wo-input').val(data.in);
            $('#wo-output').val(data.out);
            if(data.total>0){
                $('#wo-rem').val(data.total).removeClass('text-pcbconfigred').addClass('pcbconfig');
                checkscan();               
            }
            else{
                $('#wo-rem').val(data.total).addClass('pcbconfigred');
                $('#scanstatuslabel').html('Plan Quantity Reached!').removeClass('text-success').addClass('text-danger');
                $('#scan_serial').removeClass('border-success').attr('disabled',true);
            }            
    }); */
    loadscantotalemp(wo);
}
function loadscantotalemp(wo){
    $.ajax({
        url: 'api/loadempscantotaltable',
        type:'get',
        data: {
            'jo':  wo,
        },
        global: false,
        success: function (data) {           
            $('#emptotaltablediv').html(data)
        }
    });
    /* $.get("api/loadempscantotaltable",
        { 
            jo:  wo
        }, 
        function(data) {
            $('#emptotaltablediv').html(data)            
    }); */
}
function getlotnumber(wo){
    $.ajax({
        url: 'api/getln',
        type:'get',
        data: {
            'jo':  wo,
        },
        global: false,
        success: function (data) {           
            if(data){
                $('#lot_num').val(data.number);
                $('#scanform-lot_id').val(data.id);
                $('#close_lot_num').attr('disabled',false);
                $('#create_lot_num').attr('disabled',true);
                getlotnumbertotal(data.id);
                /* $('#check_lot_num').attr('disabled',true); */
                lotset = 1;
                showlotnumberpanel();
            }
            else{
                $('#lot_num').val('No Lot Number Found.');
                $('#lot_total').val('');
                $('#scanform-lot_id').val('');
                $('#close_lot_num').attr('disabled',true);
                $('#create_lot_num').attr('disabled',false);
                /* $('#check_lot_num').attr('disabled',true); */
                lotset = 0;
            }
            checkscan();
        }
    });    
}
function createlotnumber(div,line,jo,eid){
    $.ajax({
        url: 'api/createln',
        type:'post',
        data: {
            'div':  div,
            'line': line,
            'jo':  jo,
            'eid': eid
        },
        global: false,
        success: function (data) {
            if(data != 0){
                $('#scanform-lot_id').val(data.id);
                $('#lot_num').val(data.number);
                $('#create_lot_num').attr('disabled',true);
                $('#close_lot_num').attr('disabled',false);
                lotset = 1;
                iziToast.success({
                    message: 'Lot Number Created Successfully!',
                    position: 'topCenter'
                });
            }
            else{
                iziToast.error({
                    message: 'Open Lot Number found. Please click the CHECK button',
                    position: 'topCenter'
                });
                $('#create_lot_num').attr('disabled',false);
            }
            checkscan();
        }
    });
}
function closelotnumber(ln,eid){
    $.ajax({
        url: 'api/closeln',
        type:'post',
        data: {
            'ln':  ln,
            'eid': eid
        },
        global: false,
        success: function (data) {
            if(data.type == 'success'){
                lotset = 0;
                $('#lot_num').val('No Lot Number Found.');
                $('#scanform-lot_id').val('');
                $('#lot_total').val('');
                $('#close_lot_num').attr('disabled',true);
                $('#create_lot_num').attr('disabled',false);
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
            /* if(data == 1){
                lotset = 0;
                $('#lot_num').val('No Lot Number Found.');
                $('#scanform-lot_id').val('');
                $('#lot_total').val('');
                $('#close_lot_num').attr('disabled',true);
                $('#create_lot_num').attr('disabled',false);
                iziToast.success({
                    message: 'Lot Number Closed Successfully!',
                    position: 'topCenter'
                });
            }
            else{
                iziToast.error({
                    message: 'Lot Number Closing Failed!',
                    position: 'topCenter'
                });
            } */
            checkscan();        
        }
    });
}
function getlotnumbertotal(lid){
    $.ajax({
        url: 'api/getlntotal',
        type:'get',
        data: {
            'ln':  lid
        },
        global: false,
        success: function (data) {
            if(data){
                $('#lot_total').val(data);                
            }
        }
    });
}
function lotconfig(pc){
    $.ajax({
        url: 'api/getlc',
        type:'get',
        data: {
            'pc':  pc
        },
        global: false,
        success: function (data) {
            $('#lc-input').val(data);
            getlotnumber($('#scanform-jo_id').val());
        }
    });
}
function showlotnumberpanel(){
    /* if(inputt == 1){
        if($('#scanform-div_process_id').val()==5 || $('#lc-input').val() == $('#scanform-div_process_id').val() ){
            $('#lot_panel').show();
        }
    } */
    if($('#scanform-div_process_id').val()==5 || $('#lc-input').val() == $('#scanform-div_process_id').val() ){
        $('#lot_panel').show();
    }
}

/* --------------- E-V-E-N-T-S -------------- */

$('#scan_employee').on('keypress', function(e){    
    if(e.keyCode == 13)
    {
        e.preventDefault();
        verifyemployee($(this).val());
    }
});
$('#reset_emp').on('click', function(){
    resetemp();
});
$('#pcb_division_id').on('change', function(e){
    scanddload('divprocesses',$(this).val(),'pcb_process_id');
    scanddload('linenames',$(this).val(),'pcb_line_id');
});
$('#gen_url').on('click', function(){
    var url =app_url + 'sp?';
    if($('#pcb_input_type').is(":checked"))
    {
        url += 'type=1&';
    }
    if($('#pcb_division_id').val() != ''){
        url += 'div_id=' + $('#pcb_division_id').val() + '&';
    }
    if($('#pcb_process_id').val() != ''){
        url += 'div_proc_id=' + $('#pcb_process_id').val() + '&';
    }
    if($('#pcb_line_id').val() != ''){
        url += 'line_id=' + $('#pcb_line_id').val() + '&';
    }
    $('#gen_url_text').val(url);
    $.get("qr-code",
        { url: url }, 
        function(data) {
            $('#qr-div').html(data);
        });
});
$('#copy_url').on('click', function(e){
    $('#gen_url_text').select();
    document.execCommand("copy");
    document.getSelection().removeAllRanges();
    $('#gen_url_text').blur();
    iziToast.info({
        message: 'URL copied to clipboard',
        position: 'topCenter'
    });
});
$('#loadwotable').on('click',function(e){
    loadwotable();
});
/* Clickable table row */
$(document).on('click', '.wo-clickable-row', function(e) {        
    if($(this).hasClass("highlight2"))
    {
        $(this).removeClass('highlight2');
        $('#setWO').addClass('d-none');
    }        
    else
    {
        $(this).addClass('highlight2').siblings().removeClass('highlight2');
        $('#setWO').removeClass('d-none');
        $('#setWO').data('wodata',$(this).data('wodata'));
    }
});
$('#setWO').on('click', function(e){
    if($('#jo_id').val() == ''){
        swal.fire({
            title: 'Are you sure?',
            text: "You want to set the Work Order?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if (result.value) {
                setWO($(this).data('wodata'));                
            }
        })
    }
    else{
        iziToast.warning({
            message: 'Work Order already set! Unset Work Order first before setting a new Work Order.',
            position: 'topCenter'
        });
    }
    
});
$('#unsetWO').on('click', function(e){
    swal.fire({
        title: 'Are you sure?',
        text: "You want to unset the Work Order?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, unset it!'
    }).then((result) => {
        if (result.value) {
            if($('#scanform-lot_id').val() != ''){
                swal.fire({
                    title: 'Open Lot Detected.',
                    text: "You want to close the lot?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, close it!'
                }).then((result) => {
                    if (result.value) {
                        closelotnumber(
                            $('#scanform-lot_id').val(),
                            $('#scanform-employee_id').val()
                        );
                        /* alert('OK'); */
                    }
                    unsetWO();
                })
            }
            else{
                unsetWO();
            }                                   
        }
    })    
});
$('#refreshWO').on('click', function(e){
    getscantotal($('#scanform-jo_id').val());
});
$('#collapseConfig').on('hide.bs.collapse', function () {
    $('#config-collapse-btn').html('<i class="fas fa-caret-down"></i>');
});
$('#collapseConfig').on('show.bs.collapse', function () {
    $('#config-collapse-btn').html('<i class="fas fa-caret-up"></i>');
});
$('#scan_serial').on('keypress', function(e){
    if(e.keyCode == 13)
    {
        e.preventDefault();
        var err = 0;
        var msg = '';

        if(configlock == 0){
            err = 1;
            msg = 'Configuration not locked.<br>'
        }
        if(empset == 0){
            err = 1;
            msg += 'Employee not set.<br>'
        }
        if(WOset == 0){
            err = 1;
            msg += 'No work order set.<br>'
        }
        /* if($.trim( $(this).val() ) == ''){
            err = 1;
            msg += 'No scanned serial number. Try again.<br>'
        } */

        /* if(/^([a-zA-Z0-9.]){12}$/.test($(this).val()) == false){
            err = 1;
            msg += 'Invalid Serial Number. Try again.<br>'
        } */

        if(err){
            iziToast.warning({
                message: msg,
                position: 'topCenter'
            });

        }
        else{
            $('#scanform-serial_number').val($(this).val());
            serialscan(); 
        }        
        $(this).val('');       
    }
});
$('#configL').on('change', function(e){
    var t;
    var inputt;

    function unlock(){
        $('.configlock').hide();
        $('.configunlock').show();

        $('#display-input').val('');
        $('#display-division').val('');
        $('#display-line').val('');
        $('#display-process').val('');
        configlock = 0;

        /* form input reset */
        $('#scanform-type').val('');
        $('#scanform-division_id').val('');
        $('#scanform-line_id').val('');
        $('#scanform-process_id').val('');

        /* Unset WO when Config unlock */
        unsetWO();

        /* Clear WO table */
        $.get("api/loadWOtable",
            { 
                div: 0,
                dte: ''
            }, 
            function(data) {
                $('#spTablediv').html(data);
                $('#setWO').addClass('d-none');    
            });

        /* check scan status */
        checkscan();
    }
    
    if($(this).prop('checked')){
        if($('#scanform-lot_id').val() != ''){
            swal.fire({
                title: 'Open Lot Detected.',
                text: "You want to close the lot?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
            }).then((result) => {
                if (result.value) {
                    closelotnumber(
                        $('#scanform-lot_id').val(),
                        $('#scanform-employee_id').val()
                    );
                    /* alert('OK'); */
                }
                unlock();
            })
        }
        else{
            unlock();
        }
    }
    else{     

        if($('#pcb_input').prop('checked') == 1){
            t = 'IN';
            inputt = 0;
        }
        else{
            t = 'OUT';
            inputt = 1;
        }
        var chk = 0;
        if($('#pcb_division_id').val() == 0){
            chk = 1;
        }
        if($('#pcb_line_id').val() == 0){
            chk = 1;
        }
        if($('#pcb_process_id').val() == 0){
            chk = 1;
        }
        if(chk != 1){
            configlock = 1;
            $('#display-division').val($('#pcb_division_id option:selected').text());
            $('#display-line').val($('#pcb_line_id option:selected').text());
            $('#display-process').val($('#pcb_process_id option:selected').text());
            $('#display-input').val(t);
            $('.configunlock').hide();
            $('.configlock').show();

            /* form input insert */
            $('#scanform-type').val(inputt);
            $('#scanform-division_id').val($('#pcb_division_id').val());
            $('#scanform-line_id').val($('#pcb_line_id').val());
            $('#scanform-div_process_id').val($('#pcb_process_id').val());

            /* check scan status */
            checkscan();
        }
        else{
            iziToast.warning({
                message: 'Complete the fields first.',
                position: 'topCenter'
            });
            $(this).prop('checked', true).bootstrapToggle('destroy').bootstrapToggle();
        }        
        /* if($('#pcb_division_id').val() != 0){
            $('#display-division').val($('#pcb_division_id option:selected').text());
        }
        if($('#pcb_line_id').val() != 0){
            $('#display-line').val($('#pcb_line_id option:selected').text());
        }
        if($('#pcb_process_id').val() != 0){
            $('#display-process').val($('#pcb_process_id option:selected').text());
        }
        $('#display-input').val(t); */
    }
});
$('#loadpcbtable').on('click',function(e){
    loadpcbtable('',$('#scanform-type').val(),$('#scanform-div_process_id').val());
});
$('#searchpcbtable').on('keypress', function(e){
    if(e.keyCode == 13){
        loadpcbtable($(this).val(),$('#scanform-type').val(),$('#scanform-div_process_id').val());
        $(this).val('');
    }
});
$('#pcb_input').on('change', function(e){
    if($(this).prop('checked') == 1){
        inputt = 0;
        $('#lot_panel').hide();
    }
    else{
        inputt = 1;
        if(WOset == 1){
            showlotnumberpanel();
            /* if($('#scanform-div_process_id').val()==5 || $('#lc-input').val() == $('#scanform-div_process_id').val()){
                $('#lot_panel').show();
            } */
        }
    }    
    $('#scanform-type').val(inputt);
    checkscan();
});
$('#pcbtable_div').on('click','.pagination a.page-link', function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    loadpcbtable('',$('#scanform-type').val(),$('#scanform-div_process_id').val(),$(this).attr('href'));
});
$('#check_lot_num').on('click', function(){
    getlotnumber($('#scanform-jo_id').val());
});
$('#create_lot_num').on('click', function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You want to create a Lot?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, create it!'
    }).then((result) => {
        if (result.value) {
            $(this).attr('disabled',true);
            createlotnumber(
                $('#scanform-division_id').val(),
                $('#scanform-line_id').val(),
                $('#scanform-jo_id').val(),
                $('#scanform-employee_id').val()
            );
        }
    })
});
$('#close_lot_num').on('click', function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You want to close the Lot?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, close it!'
    }).then((result) => {
        if (result.value) {
            closelotnumber(
                $('#scanform-lot_id').val(),
                $('#scanform-employee_id').val()
                );
        }
    })    
});
$('#get_lot_total').on('click', function(){
    getlotnumbertotal($('#scanform-lot_id').val());
});
$('#reload-wo-total').on('click', function(){
    getscantotal($('#scanform-jo_id').val());
});
