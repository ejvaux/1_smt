function colorsets(){
        
    $col =[
        '#99A3A4',
        '#42a5f5',
        '#5c6bc0',
        '#7e57c2',
        '#ab47bc',
        '#ec407a',
        '#ef5350',
        '#d4e157',
        '#9ccc65',
        '#66bb6a',
        '#26a69a',
        '#26c6da',
        '#29b6f6',
        '#bdbdbd',
        '#8d6e63',
        '#ff7043',
        '#ffa726',
        '#ffee58',
        '#ffca28',
        '#78909C'
    ];
    return $col;
}

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

$(document).ready(function(){
    $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });
    $('.select2').select2({width: '100%'});
    $('.sel2').select2({height: '100%'});
    $('[data-toggle="tooltip"]').tooltip();
    $('#scan_pos').on('select2:select', function (e) {
        setTimeout(function() {
            $('.select2-container-active').removeClass('select2-container-active');
            $(':focus').blur();
            selinput();
        }, 1);
    });
    $('#scan_model').on('select2:select', function (e) {
        /* $('#scan_line').select2('open'); */
        /* $("#scan_machine").focus(); */
        setTimeout(function() {
            $('.select2-container-active').removeClass('select2-container-active');
            $(':focus').blur();
            $("#scan_machine").focus();
        }, 1);
    });
    $('#scan_employee').on('select2:select', function (e) {
        //alert('Do something');
        if(document.getElementById('scan_employee').value!=""){
            document.getElementById('emp_PIN').value="";
            $('.modal').modal('show');
            $('.modal').on('shown.bs.modal', function () {
                $('#emp_PIN').focus();
            })  
        }
    });

});

$('#scan_line').on('select2:close', function(e){
    /* iziToast.info({
        position: 'topCenter',
        message: 'TEST',
    }); */
    setTimeout(function() {
        $('.select2-container-active').removeClass('select2-container-active');
        $(':focus').blur();
        $("#scan_machine").focus();
    }, 1);
});
$('#scan_feed_slot').on('select2:close', function(e){
    /* setTimeout(function() {
        $('.select2-container-active').removeClass('select2-container-active');
        $(':focus').blur();
        selinput();
    }, 1); */
    $('#scan_pos').select2('open');
});

function selinput(){
    if($('#replenish').prop("checked") != true){
        $("#scan_newPN").focus();
    }
    else{
        /* $("#scan_oldPN").focus(); */
    }    
}

function enterEvent(e) {
        var datainput = "";
        var input_text = document.getElementById('input_serial').value;
        var joborder = document.getElementById('work_num').value;
        var pname = document.getElementById('process_sel').value;
        var pline = document.getElementById('prodline_sel').value;
        var inputs="";
        if ($('#input_type').is(":checked")){
            inputs = "IN";
        }
        else{
            inputs = "OUT";
        }

        if (e.keyCode == 13){
            if(input_text==""){
                iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please Input Serial Number!',
                });
            }
            else {

                    if(pname!="" && pline!=""){
                        if ($('#R_panel_input_type').is(":checked")){
                            if ($('#input_type').is(":checked")){
                                if(joborder!=""){
                                    datainput="IN";
                                    CheckRecord("OK",datainput);
                                    
                                }
                                else{
                                    iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'Please select a JOBORDER NO.',});
                                }
                              
                            }
                            else {
                                datainput="OUT";
                                CheckRecord("OK",datainput);  
                            }
                        }
                        else {
                            var ecode = document.getElementById('ecode_sel').value;
                            if(ecode!=""){
                                if ($('#input_type').is(":checked")){
                                    if(joborder!=""){
                                        datainput="IN";
                                        CheckRecord("NG",datainput);
                                    }
                                    else{
                                        iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'Please select a JOBORDER NO.',});
                                    }
                                   
                                }
                                else{
                                    datainput="OUT";
                                    CheckRecord("NG",datainput);
                                }  
                            }
                            else{
                                iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'Please select an error code',});
                            }
                             
                            
                        }
                    }
                    else{
                        iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'Please complete the required fields. Select a Process and Prod Line.',});
                    }

          
                
            } //end else of if input has text
            
        }
        
}

function errormsg()
{
    iziToast.error({
        title: 'WARNING',
        position: 'topCenter',
        message: 'Serial Number record not saved.',
    }) 
    document.getElementById('input_serial').value="";
    document.getElementById('ecode_sel').value="";
}

function modifyscanrecord(res,datainput,ajax_url)
{
var pname = document.getElementById('process_sel').value;
var pline = document.getElementById('prodline_sel').value;
var mach = document.getElementById('machine_sel').value;
var result = res;
var ecode = document.getElementById('ecode_sel').value;
var snum = document.getElementById('input_serial').value;
var userid=document.getElementById('userid').value;
var JO_ID = document.getElementById('jo_id').value;
var JO_Num=document.getElementById('work_num').value;
var scan_input = datainput;
// alert(snum);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    url: ajax_url,
    type:'POST',
    dataType:'JSON',
    data:{
        'sel_process':pname,
        'sel_prodline':pline,
        'sel_machine':mach,
        'sel_result':result,
        'sel_ecode':ecode,
        'serialnum':snum,
        'sel_user':userid,
        'sel_scaninput':scan_input,
        'sel_ID':JO_ID,
        'sel_JoNum':JO_Num
    },
    success: function (data) {
        //dt = JSON.stringify(data);
        //alert('good');
    }/* ,
    error: function (data) {
        marker = JSON.stringify(data);
        //alert(marker);
    } */
});
}

function haserrorcode()
{
var datainput = "";
if ($('#input_type').is(":checked")){
    datainput="IN";
    CheckRecord("NG",datainput);
    $('.modal').modal('hide');
}
else{
    datainput="OUT";
    CheckRecord("NG",datainput);
    $('.modal').modal('hide');
}

}

function CheckRecord(res,datainput){
var input_text = document.getElementById('input_serial').value;
var pname = document.getElementById('process_sel').value;
var pline = document.getElementById('prodline_sel').value;
var mach = document.getElementById('machine_sel').value;
var result = res;
var ecode = document.getElementById('ecode_sel').value;
var snum = document.getElementById('input_serial').value;
var userid=document.getElementById('userid').value;
var scan_input = datainput;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $.ajax({
    url: 'ajax/Check_Record',
    type:'POST',
    dataType:'text',    
    data:{
        'sel_process':pname,
        'sel_prodline':pline,
        'sel_machine':mach,
        'sel_result':result,
        'sel_ecode':ecode,
        'serialnum':snum,
        'sel_user':userid,
        'sel_scaninput':scan_input
    },
    success: function (data) {
            
            if (data=="HAS RECORD-OK"){
                    if(datainput=="IN"){
                        iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'This record already exists! Please check your scanning configuration and scan again',});
                    }
                    else if(datainput=="OUT"){
                        modifyscanrecord(result,datainput,"scanrecord/upOUT");
                        iziToast.success({title: 'OK',position: 'topCenter',message: input_text+' record updated successfully.',color: 'blue'});
                    }
                    document.getElementById('input_serial').value="";
                    document.getElementById('ecode_sel').value="";
            }
            else if(data=="NO RECORD")
            {
                    if(datainput=="IN"){
                        modifyscanrecord(result,datainput,"scanrecord");
                        iziToast.success({title: 'OK',position: 'topCenter', message: input_text+' Successfully added to the record!',});
                    }
                    else{
                        iziToast.error({title: 'ERROR',position: 'topCenter',message: input_text+' has no record in the database. Please Scan this item as IN first.',});
                    }
                    document.getElementById('input_serial').value="";
                    document.getElementById('ecode_sel').value="";
            }
            else if (data=="HAS RECORD-NG"){
                    if(datainput=="IN"){
                        modifyscanrecord(result,datainput,"scanrecord/upOUT");
                        iziToast.success({title: 'OK',position: 'topCenter',message: input_text+' record updated successfully.',});
                    }
                    else if(datainput=="OUT"){
                        modifyscanrecord(result,datainput,"scanrecord/upOUT");
                        iziToast.success({title: 'OK',position: 'topCenter',message: input_text+' record updated successfully.',    color: 'blue'});
                    }
                    document.getElementById('input_serial').value="";
                    document.getElementById('ecode_sel').value="";

                }
            else{
                alert(data);
            }

            document.getElementById('ecode_sel').value="";
                        $('#ecode_sel').val("").trigger('change');
                        $('#R_panel_input_type').prop('checked', true).change();
            document.getElementById("loadtbl").click();

    }/* ,
    error: function (data) {
        marker = JSON.stringify(data);
        alert(marker);
    } */
});

}

function LoadDataTable(){
    var datainput = "";
    if ($('#bot_panel_input_type').is(":checked")){
        datainput="IN";
    }
    else{
        datainput="OUT";
    }
    var IO_date = document.getElementById('scan_IO_date').value;
    var pname = document.getElementById('bot_panel_process_sel').value;
    var pline = document.getElementById('bot_panel_prodline_sel').value;
    var snum = document.getElementById('bot_panel_input_serial').value;
    var mach = document.getElementById('bot_panel_machine_sel').value;
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if(IO_date==""){

        if (dd < 10) {
            dd = '0' + dd;
            }
    
            if (mm < 10) {
            mm = '0' + mm;
            }
            document.getElementById('scan_IO_date').value = yyyy+"-"+mm+"-"+dd;
            IO_date = yyyy+"-"+mm+"-"+dd;
    }
    /* 
    var ecode = document.getElementById('ecode_sel').value;
    var snum = document.getElementById('input_serial').value;
    var userid=document.getElementById('userid').value; */
    
    var scan_input = datainput;
    // alert(snum);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        url: 'ajax/loaddatatable',
        type:'POST',
        data:{
            'sel_process':pname,
            'sel_prodline':pline,
            'sel_scaninput':scan_input,
            'sel_sn':snum,
            'sel_machine':mach,
            'io_date':IO_date
        },
        success: function (data) {
            //$('#datatable tr').not(':first').not(':last').remove();
            //console.log(JSON.stringify(data));
        $('#datatable>tbody').empty();
        var html = '';
        
        if(data.length==0)
        {
            html +="<tr style='height:100px'><td colspan='9' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the scanning options then load data again.</td></tr>";
        }
        for(var i = 0; i < data.length; i++){
            var errorcode="";
            var machinecode="";
            if(data[i].errorlink==null){
                errorcode="N/A";
            }
            else{
                errorcode=data[i].errorlink.error_code;
            }
            if(data[i].machinelink==null){
                machinecode="N/A";
            }
            else{
                machinecode=data[i].machinelink.machine_ini;
            }
            html += '<tr class="text-center">'+
                        '<td>' + '<a href="scanrecord/'+data[i].id+'/edit"'+' class="btn btn-sm btn-danger" style="font-size:0.7em"><i class="fas fa-info-circle"></i> &nbspDETAILS</a>' + '</td>' +  
                        '<td>' + data[i].prodlinelink.prodline_ini + '</td>' +
                        '<td>' + data[i].userlink.name  + '</td>' +
                        '<td>' + data[i].serial_number  + '</td>' +
                        '<td>' + data[i].scan_result + '</td>' +
                        '<td>' + errorcode + '</td>' +
                        '<td>' + data[i].processlink.process_ini + '</td>' +
                        '<td>' + machinecode + '</td>' +
                        '<td>' + data[i].created_at + '</td>' +
                    '</tr>';
            }   
            
        //$('#datatable tr').first().after(html);
        $('#datatable').append(html);
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });
}

function LoadSAPDataTable(){
    var selectedDate = document.getElementById('SAP_date').value;
    var searchbox = document.getElementById('SAP_searchbox').value;
    var searchfield = document.getElementById('search_field').value;

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if(selectedDate==""){

        if (dd < 10) {
            dd = '0' + dd;
            }
    
            if (mm < 10) {
            mm = '0' + mm;
            }
            document.getElementById('SAP_date').value = yyyy+"-"+mm+"-"+dd;
            selectedDate = yyyy+"-"+mm+"-"+dd;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        url: 'ajax/saploaddatatable',
        type:'POST',
        data:{
            'plandate':selectedDate,
            'searchbox':searchbox,
            's_field':searchfield
        },
        success: function (data) {
            //$('#datatable tr').not(':first').not(':last').remove();
        //console.log(JSON.stringify(data));
        $('#JOdatatable>tbody').empty();
        var html = '';
        
        if(data['sap_plan'].length==0)
        {
            html +="<tr style='height:100px'><td colspan='6' class='text-center' style='font-size:1.5em'>No data to display.</td></tr>";
        }
        for(var i = 0; i < data['sap_plan'].length; i++){

            /* $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
            $.ajax({
                url: 'ajax/totalpjo',
                type:'POST',
                data:{
                    'pid':idd
                },
                success: function (data2) {
                    //alert(data2.length);
                    total = data2;
                },
                error: function (data) {
                    marker = JSON.stringify(data);
                    //alert(marker);
                }
            }); */
            var total="0";
            for(var z = 0; z < data['smt_result'].length; z++){
                if(data['smt_result'][z].SapPlanID==data['sap_plan'][i].DocEntry){
                    total = data['smt_result'][z].res;
                    break;
                }
                else{
                    total="0";
                }
            }
            html += '<tr class="text-center">'+
                        '<td>' + "<button class='btn btn-sm btn-danger' style='font-size:0.7em'"+
                        " onclick='JOSelectRow("+"\""+data['sap_plan'][i].DocNum+"\",\""+data['sap_plan'][i].ItemCode+"\",\""+data['sap_plan'][i].ProdName+"\",\""+data['sap_plan'][i].PlannedQty+"\",\""+data['sap_plan'][i].DocEntry+"\")'"+
                        "><i class='fas fa-check-square'></i>&nbspSELECT</button>" + '</td>' +  
                        '<td>' + data['sap_plan'][i].DocNum + '</td>' +
                        '<td>' + data['sap_plan'][i].ItemCode  + '</td>' +
                        '<td>' + data['sap_plan'][i].ProdName + '</td>' +
                        '<td>' + Math.round(data['sap_plan'][i].PlannedQty) + '</td>' +
                        '<td>' + total + '</td>' +
                    '</tr>';
            }   

        //$('#datatable tr').first().after(html);
        $('#JOdatatable').append(html);
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });
}

function SetInputType()
{ 
    if ($('#input_type').is(":checked")){
        $('#bot_panel_input_type').prop('checked', true).change();
    }
    else{
        $('#bot_panel_input_type').prop('checked', false).change();
    }
}

function SetProdLine()
{
    //$('#bot_panel_prodline_sel').val(document.getElementById('prodline_sel').value).trigger('change');
}

function SetProcess()
{
    //$('#bot_panel_process_sel').val(document.getElementById('process_sel').value).trigger('change');
}
function SetMachine()
{
    //$('#bot_panel_machine_sel').val(document.getElementById('machine_sel').value).trigger('change');
}

function ScanRecordClearData()
{
    document.getElementById('bot_panel_process_sel').value = "";
    document.getElementById('bot_panel_machine_sel').value = "";
    document.getElementById('bot_panel_prodline_sel').value = "";
    document.getElementById('bot_panel_input_serial').value = "";
    //$('#bot_panel_process_sel').val("").trigger('change');
    $('#bot_panel_process_sel option:eq(0)').prop('selected',true);
    //$('#bot_panel_machine_sel').val("").trigger('change');
    $('#bot_panel_machine_sel option:eq(0)').prop('selected',true);
    // $('#bot_panel_prodline_sel').val("").trigger('change');
    $('#bot_panel_prodline_sel option:eq(0)').prop('selected',true);
    $('#datatable>tbody').empty();
    var html = '';
    html +="<tr style='height:100px'><td colspan='9' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the scanning options then load data again.</td></tr>";
    $('#datatable').append(html);
}

function ChangeToggle()
{
    if ($('#R_panel_input_type').is(":checked")){
        document.getElementById("ecode_sel").disabled = true;
    }
    else{
        document.getElementById("ecode_sel").disabled = false;
    }
}

function IsReplenish()
{
    if ($('#replenish').is(":checked")){
        /* document.getElementById("scan_oldPN").disabled = false;
        $('#scan_oldPN').focus(); */
        //alert('YES');
    }
    else{            
        /* document.getElementById("scan_oldPN").disabled = true; */
        $("#scan_newPN").focus();
        //alert('NO');
    }
}

function JOSelectRow(DocNum,ItemCode,ProdName,PlannedQty,jo_id){

    //alert(DocNum+ItemCode+ProdName+PlannedQty);

    document.getElementById('work_num').value=DocNum;
    document.getElementById('part_code').value=ItemCode;
    document.getElementById('part_name').value=ProdName;
    document.getElementById('plan_qty').value=Math.round(PlannedQty);
    document.getElementById('jo_id').value=jo_id;

    iziToast.success({title: 'OK',position: 'topCenter',message: 'JOB ORDER #: '+DocNum+ ' selected successfully.'});
}

function ClearJOSearch(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
    dd = '0' + dd;
    }

    if (mm < 10) {
    mm = '0' + mm;
    }
    document.getElementById('SAP_date').value = yyyy+"-"+mm+"-"+dd;
    document.getElementById('SAP_searchbox').value = "";
    LoadSAPDataTable();
}

function event_mach(e){
    if (e.keyCode == 13){
        document.getElementById("scan_pos").focus();
        //sloaddetails();
        //loaddata_panel_right();
        /* $('#scan_pos').select2('open'); */
        document.getElementById("scan_feed_slot").focus();
        $('#scan_feed_slot').select2('open');
    }
}

function event_model(e){
    if (e.keyCode == 13){
        document.getElementById("scan_machine").focus();
     
       
    }
   
}

function event_lastPN(e){
    if (e.keyCode == 13){
        document.getElementById("scan_newPN").focus();
    }
}

function event_emp(e){
    if (e.keyCode == 13){
        var emp_id = document.getElementById("scan_emp").value;
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
    
          $.ajax({
            url: 'ajax/ScanEmpID',
            type:'POST',
            data:{
                'empCode':emp_id
             
            },
            success: function (data) {
                
                if(data.length>0){
                    //$('#scan_model').select2('open');
                    document.getElementById("scan_employee").value = data[0].id;
                    document.getElementById("scan_emp").value = data[0].lname+', '+data[0].fname;
                    document.getElementById("scan_emp").readOnly = true;

                    //for model input text
                    /* document.getElementById("scan_model").focus();
                    $('#scan_model').select2('open'); */
                    // focus machine input
                    $("#scan_machine").focus();
                }
                else{
                    /* iziToast.error({title: 'ERROR',position: 'topCenter',message: 'Employee code do not exists. Please scan the barcode given by the MIS department or contact MIS Personnel to verify your ID.',}); */
                    swal.fire({
                        title: 'Employee does not exists',
                        text: 'Employee code do not exists. Please scan the barcode given by the MIS department or contact MIS Personnel to verify your ID.',
                        type: 'error',
                        timer: 3000
                      })
                    document.getElementById("scan_emp").value="";
                    document.getElementById("scan_employee").value="";
                    document.getElementById("scan_emp").focus();
                }   

                /* 
                if(data=="no match"){
                    iziToast.error({title: 'ERROR',position: 'topCenter',message: 'Employee code do not exists. Please scan the barcode given by the MIS department or contact MIS Personnel to verify your ID.',});
                    document.getElementById("scan_emp").value="";
                    document.getElementById("scan_employee").value="";
                    document.getElementById("scan_emp").focus();
                }
                else{
                    $('#scan_model').select2('open');
                    document.getElementById("scan_employee").value = data;

                } */
            }/* ,
            error: function (data) {
                marker = JSON.stringify(data);
                  swal.fire({
                    title: 'Session Expires',
                    text: 'Reload the page',
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if (result.value) {
                        //window.location.href = "http://172.16.1.13:8000/1_smt/public/mscan2";
                    }
                  })
                
               
            } */
        });
            

       
    }
}

function event_PIN(e){
    if (e.keyCode == 13){
        var emp_id = document.getElementById("scan_employee").value;
        var PINtoValidate=document.getElementById("emp_PIN").value;
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
    
          $.ajax({
            url: 'ajax/empPIN',
            type:'POST',
            data:{
                'empid':emp_id
             
            },
            success: function (data) {
                for(var z = 0; z < data.length; z++){
                    
                    emp_PIN = data[z].pin;
                }

                if(PINtoValidate!=emp_PIN){
                    iziToast.error({
                        title: 'ERROR',
                        position: 'topCenter',
                        message: 'Wrong PIN!',
                    });
                    $('#scan_employee').val("").trigger('change');
                    document.getElementById('emp_PIN').value="";
                    $('.modal').modal('hide');
                }
                else{
                    iziToast.success({
                         title: 'SUCCESS',
                        position: 'topCenter',
                        message: 'PIN matched!',
                    });
                    $('.modal').modal('hide');
                    document.getElementById('scan_model').focus();
                    $('#scan_model').select2('open');
                }
                //alert(data);
            }/* ,
            error: function (data) {
                marker = JSON.stringify(data);
                //alert(marker); 
               
            } */
        });
    }
}

function WrongPIN(){
    $('#scan_employee').val("").trigger('change');
    document.getElementById('emp_PIN').value="";
}

function resetval(){
    if ($('#replenish').is(":checked")){
        resetemp();
        $('#scan_model').val("").trigger('change');
        $('#scan_line').val("").trigger('change');
        $('#scan_pos').val("").trigger('change');
        $('#scan_feed_slot').val("").trigger('change');
        document.getElementById('scan_machine').value="";
        /* document.getElementById('scan_oldPN').value=""; */
        document.getElementById('scan_newPN').value="";
        document.getElementById("scan_emp").focus();
    }
    else{
        if ($('#scan_pos').val() == 1) {
            $('#scan_pos').val('2').trigger('change');
            $('#scan_newPN').val('');
        }
        else if($('#scan_pos').val() == 2){
            $nf = parseInt($('#scan_feed_slot').val());
            $('#scan_feed_slot').val($nf+1).trigger('change');
            $('#scan_pos').val('1').trigger('change');
            $('#scan_newPN').val('');
        }
        else{
            $('#scan_pos').val("").trigger('change');
            $('#scan_feed_slot').val("").trigger('change');
            /* document.getElementById('scan_oldPN').value=""; */
            document.getElementById('scan_newPN').value="";
            /* $('#scan_pos').select2('open'); */
            /* $("#scan_machine").focus().select(); */
            /* $('#scan_feed_slot').focus(); */
            $('#scan_feed_slot').select2('open');
        }
    }    
}
function resetval1(){
    $('#scan_pos').val("").trigger('change');
    $('#scan_feed_slot').val("").trigger('change');
    /* document.getElementById('scan_machine').value=""; */
    /* document.getElementById('scan_oldPN').value=""; */
    document.getElementById('scan_newPN').value="";
    /* document.getElementById("scan_machine").focus(); */
    $('#scan_pos').select2('open');
    /* $('#scan_pos').focus('open'); */
}

function event_loadPN(e){

    var replenish = "";
    if ($('#replenish').is(":checked")){
        replenish = "YES";
    }
    else{
        replenish = "NO";
    }

    var line = $('#scan_line').val();
    var emp_name = document.getElementById('scan_employee').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    /* var old_PN = document.getElementById('scan_oldPN').value; */
    var new_PN = document.getElementById('scan_newPN').value;

   

        if ($('#replenish').is(":checked")){
            var temp1 = new Array();
            if(old_PN.includes(",")){
                temp1 = old_PN.split(",");
            }
            else if(old_PN.includes(";")){
                temp1 = old_PN.split(";");
            }              
    
            for (a in temp1 ) {
                temp1[a] = (temp1[a]); 
            }
            /* if(a!=0){                
                old_PN = temp1[4].substr(3);
            } */
            if(a!=0){
                for (a in temp1 ) {
                    var res2 = temp1[a].split(":");
                    if(res2[0] == "PN"){
                        old_PN = res2[1];
                    }
                }
            }  
        }
       

        var temp2 = new Array();
        if(new_PN.includes(",")){
            temp2 = new_PN.split(",");
        }
        else if(new_PN.includes(";")){
            temp2 = new_PN.split(";");
        }  

        for (b in temp2 ) {
            temp2[b] = (temp2[b]);
        }
        /* if(b!=0){
            new_PN = temp2[4].substr(3);
        } */
        if(b!=0){
            for (b in temp2 ) {
                var res2 = temp2[b].split(":");
                if(res2[0] == "PN"){
                    new_PN = res2[1];
                }
            }
        }
        
    if (e.keyCode == 13){
      
        if(emp_name && machine_code && new_PN){
            //all req fields are good
            if(replenish=="YES"){
                        
                    if(old_PN==new_PN){
                        //ajax checking to feeder here..
                        CheckFeeder();
                    }
                    else{
                        /*   iziToast.error({
                            title: 'ERROR',
                            position: 'topCenter',
                            timeout: 10000,
                            messageSize:'20',
                            message: 'OLD PN and NEW PN must be matched. <br>If you are sure to load different PN, please set <br> the replenish toggle to NO for initial loading.',
                        }); */
                        swal.fire({
                            title: 'OLD PN and NEW PN does not matched',
                            text: 'OLD PN and NEW PN must be matched. If you are sure to load different PN, please set the replenish toggle to NO for initial loading.',
                            type: 'error',
                            /* timer: 3000 */
                            })
                            
                        ErrorIns("OLD PN and NEW PN not matched");
                        /* document.getElementById('scan_oldPN').value=""; */
                        document.getElementById('scan_newPN').value="";
                        /* document.getElementById('scan_oldPN').focus(); */
                    }

            }
            else{
                //replenish => NO --ajax save as initial running
                CheckFeeder();
            }


        }
        //error handlers for required fields
        else{

            if(!emp_name){
                /*  iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please input employee name',
                }); */
                swal.fire({
                    title: 'Employee Field is required',
                    text: 'Please input employee name',
                    type: 'error',
                    timer: 1500
                    })
                
            }
            else if(!machine_code){
                /* iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please scan the machine code',
                }); */
                swal.fire({
                    title: 'Machine Code Field is required',
                    text: 'Please scan the machine code',
                    type: 'error',
                    timer: 1500
                    })
            }
            /* else if(!model_code){
                swal.fire({
                    title: 'Model Name Field is required',
                    text: 'Please input model name',
                    type: 'error',
                    timer: 1500
                    })
            } */
            else if(!position){
                /* iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please input position',
                }); */
                swal.fire({
                    title: 'Position Field is required',
                    text: 'Please input position',
                    type: 'error',
                    timer: 1500
                    })
            }
            else if(!feeder_slot){
                /* iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please input feeder slot #',
                }); */
                swal.fire({
                    title: 'Feeder Slot # is required',
                    text: 'Please input feeder slot #',
                    type: 'error',
                    timer: 1500
                    })
            }
            else if(!new_PN){
                /* iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please input new PN to load',
                }); */
                swal.fire({
                    title: 'PN is required',
                    text: 'Please input new PN to load',
                    type: 'error',
                    timer: 1500
                    })
            }
            else{

                /* iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please fill out all the required fields',
                }); */
                swal.fire({
                    title: 'ERROR',
                    text: 'Please fill out all the required fields',
                    type: 'error',
                    timer: 1500
                    })
            }



        }
    }

}

function CheckFeeder(){

    var replenish = "";
    if ($('#replenish').is(":checked")){
        replenish = "YES";
    }
    else{
        replenish = "NO";
    }

    var line = $('#scan_line').val();
    var emp_name = document.getElementById('scan_employee').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    /* var old_PN = document.getElementById('scan_oldPN').value; */
    var new_PN = document.getElementById('scan_newPN').value;

    if ($('#replenish').is(":checked")){
        var temp1 = new Array();
        if(old_PN.includes(",")){
            temp1 = old_PN.split(",");
        }
        else if(old_PN.includes(";")){
            temp1 = old_PN.split(";");
        } 

        for (a in temp1 ) {
            temp1[a] = (temp1[a]); 
        }
        /* if(a!=0){
            old_PN = temp1[4].substr(3);
        } */
        if(a!=0){
            for (a in temp1 ) {
                var res2 = temp1[a].split(":");
                if(res2[0] == "PN"){
                    old_PN = res2[1];
                }
            }
        }
        
       
    }
   

        var temp2 = new Array();
        if(new_PN.includes(",")){
            temp2 = new_PN.split(",");
        }
        else if(new_PN.includes(";")){
            temp2 = new_PN.split(";");
        }  

        for (b in temp2 ) {
            temp2[b] = (temp2[b]);
        }
        /* if(b!=0){
            new_PN = temp2[4].substr(3);
        } */
        if(b!=0){
            for (b in temp2 ) {
                var res2 = temp2[b].split(":");
                if(res2[0] == "PN"){
                    new_PN = res2[1];
                }
            }
        }

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/feedlist',
        type:'POST',
        data:{
            'replenish':replenish,
            /* 'line': $('#scan_line').val(), */
            'emp_id':emp_name,
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot,
            /* 'old_PN':old_PN, */
            'new_PN':new_PN
        },
        success: function (data) {

            //alert(data);
            if(data!="NO RECORD"){
               
                if(replenish=="YES"){
                    CheckRunning(data);
                   
                }
                else{
                    InsertRecord(data);
                }
            }
            else{
                document.getElementById('scan_newPN').value="";
                swal.fire({
                    title: 'Check Feeder List or the QR Code to scan',
                    text: 'Component not found in the feeder list. Please check your input data or the MODEL in Line Config.',
                    type: 'error',
                  })

                ErrorIns("Component not found in feeder list.");
            }
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
            swal.fire({
                title: 'Session Expires',
                text: 'Reload the page',
                type: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.value) {
                    //window.location.href = "http://172.16.1.13:8000/1_smt/public/mscan2";
                }
              })
        } */
    });

}

function InsertRecord(order_id){
    var replenish = "";
    if ($('#replenish').is(":checked")){
        replenish = "YES";
    }
    else{
        replenish = "NO";
    }

    var emp_name = document.getElementById('scan_employee').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    /* var old_PN = document.getElementById('scan_oldPN').value; */
    var new_PN = document.getElementById('scan_newPN').value;
    var reelInfo = document.getElementById('scan_newPN').value;

    if ($('#replenish').is(":checked")){
        var temp1 = new Array();
        if(old_PN.includes(",")){
            temp1 = old_PN.split(",");
        }
        else if(old_PN.includes(";")){
            temp1 = old_PN.split(";");
        } 

        for (a in temp1 ) {
            temp1[a] = (temp1[a]); 
        }
        /* if(a!=0){
            old_PN = temp1[4].substr(3);
        } */
        if(a!=0){
            for (a in temp1 ) {
                var res2 = temp1[a].split(":");
                if(res2[0] == "PN"){
                    old_PN = res2[1];
                }
            }
        }
        
       
    }
   

    var temp2 = new Array();
    if(new_PN.includes(",")){
        temp2 = new_PN.split(",");
    }
    else if(new_PN.includes(";")){
        temp2 = new_PN.split(";");
    }

    if(temp2.length > 12){
        iziToast.error({
            title: 'ERROR',
            position: 'topCenter',
            message: 'Error processing Reel Qr Code. Please try again.',
        });
        $('#scan_newPN').val('');
        return 0;
    }

    for (b in temp2 ) {
        temp2[b] = (temp2[b]);
    }
    /* if(b!=0){
        new_PN = temp2[4].substr(3);
    } */
    if(b!=0){
        comp_rid = '';
        for (b in temp2 ) {
            var res2 = temp2[b].split(":");
            if(res2[0] == "PN"){
                new_PN = res2[1];
            }
            if(res2[0] == "QTY"){
                comp_qty = res2[1];
            }
            if(res2[0] == "RID"){
                comp_rid = res2[1];
            }
        }
    }
    if(comp_rid == ''){
        iziToast.error({
            title: 'ERROR',
            position: 'topCenter',
            message: 'Error processing Reel Qr Code. Please try again.',
        });
        $('#scan_newPN').val('');
        return 0;
    }

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'materialload',
        type:'POST',
        data:{
            'replenish':replenish,
            'emp_id':emp_name,
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot,
            /* 'old_PN':old_PN, */
            'new_PN':new_PN,
            'order_id':order_id,
            'reelInfo':reelInfo,
            'comp_qty':comp_qty,
            'comp_rid':comp_rid
        },
        success: function (data) {

            if(data.type == 'success'){                
                iziToast.success({
                    message: data.message,
                    position: 'topCenter'
                });
                loaddata_panel_right();
                resetval();  
            }
            else if(data.type == 'error'){
                iziToast.warning({
                    message: data.message,
                    position: 'topCenter'
                });
                $('#scan_newPN').val('');
            }             
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });

}

function CheckRunning(order_id){
    var replenish = "";
    if ($('#replenish').is(":checked")){
        replenish = "YES";
    }
    else{
        replenish = "NO";
    }

    var emp_name = document.getElementById('scan_employee').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    /* var old_PN = document.getElementById('scan_oldPN').value; */
    var new_PN = document.getElementById('scan_newPN').value;

    if ($('#replenish').is(":checked")){
            var temp1 = new Array();
            if(old_PN.includes(",")){
                temp1 = old_PN.split(",");
            }
            else if(old_PN.includes(";")){
                temp1 = old_PN.split(";");
            } 
    
            for (a in temp1 ) {
                temp1[a] = (temp1[a]); 
            }
            /* if(a!=0){
                old_PN = temp1[4].substr(3);
            } */
            if(a!=0){
                for (a in temp1 ) {
                    var res2 = temp1[a].split(":");
                    if(res2[0] == "PN"){
                        old_PN = res2[1];
                    }
                }
            }
            
           
        }
       

        var temp2 = new Array();
        if(new_PN.includes(",")){
            temp2 = new_PN.split(",");
        }
        else if(new_PN.includes(";")){
            temp2 = new_PN.split(";");
        }  

        for (b in temp2 ) {
            temp2[b] = (temp2[b]);
        }
        /* if(b!=0){
            new_PN = temp2[4].substr(3);
        } */
        if(b!=0){
            for (b in temp2 ) {
                var res2 = temp2[b].split(":");
                if(res2[0] == "PN"){
                    new_PN = res2[1];
                }
            }
        }

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/CheckRunningTable',
        type:'POST',
        data:{
            'replenish':replenish,
            'emp_id':emp_name,
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot,
            /* 'old_PN':old_PN, */
            'new_PN':new_PN,
            'order_id':order_id
        },
        success: function (data) {
         
            if(data!="not match in running"){
                //has match the running
               
                InsertRecord(order_id);
                /* resetval(); */
            }
            else{
               /*  iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Component partname does not match the previous prima partname. if you are sure to load this partname,<br>toggle the replenishment button to NO for initial loading.',
                }); */

                swal.fire({
                    title: 'OLD PN does NOT matched the current running data',
                    text: 'Component partname does not match the previous prima partname. if you are sure to load this partname,toggle the replenishment button to NO for initial loading.',
                    type: 'error'
                  })

                ErrorIns("Component PN does not match the currently running PN");
            }


        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });
}

function clear_date(){
    document.getElementById('mat_hist_date').value="";
    loaddata_panel_right();
}

function loaddata_panel_right(){

    var s_date = document.getElementById('mat_hist_date').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    var today = new Date();

    if(s_date!=""){
        today = s_date;
    }
    else{
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 
        today = yyyy+"-"+mm+"-"+dd;
        document.getElementById('mat_hist_date').value = yyyy+"-"+mm+"-"+dd;
    }

    document.getElementById('hidDateParam').value=today;

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/loadhistory',
        type:'POST',
        data:{
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot,
            'sdate':today
        },
        success: function (data) {
            //console.log(JSON.stringify(data));
            
            $('#datatable2>tbody').empty();
            var html = '';
            
            if(data.length==0)
            {
                html +="<tr style='height:100px'><td colspan='9' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the date parameters to load data.</td></tr>";
            }
 
            for(var i = 0; i < data.length; i++){
               var table = "";
               table = "TABLE "+ data[i].table_id;
               /* if(data[i].smt_table_rel.name=='A')
               {
                   table = "TABLE 1";
               }
               else  if(data[i].smt_table_rel.name=='B')
               {
                   table = "TABLE 2";
               }
               else  if(data[i].smt_table_rel.name=='C')
               {
                   table = "TABLE 3";
               }
               else  if(data[i].smt_table_rel.name=='D')
               {
                   table = "TABLE 4";
               } */

              var mc = '';
               if(data[i].machine_id){
                   mc = data[i].machine_rel.code;
                }

                html +='<tr class="text-center">'+
                            '<td nowrap>' + data[i].created_at + '</td>' +
                            '<td nowrap>' + data[i].component_rel.product_number + '</td>' +
                            '<td nowrap>' + data[i].component_rel.authorized_vendor + '</td>' +
                            '<td nowrap>' + mc  + '</td>' +
                            '<td nowrap>' + data[i].smt_model_rel.code  + '</td>'+
                            '<td nowrap>' + table + '</td>'+
                            '<td nowrap>' + data[i].mounter_rel.code + '</td>' +
                            '<td nowrap>' + data[i].smt_pos_rel.name + '</td>' +
                            '<td nowrap>' + data[i].employee_rel.lname + ', '+ data[i].employee_rel.fname + '</td>' +
                        '</tr>';
                }   
            
            $('#datatable2').append(html);
           
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });
    load_running_machine_tbl();
}

function clear_running(){

    $('#datatable3>tbody').empty();
    $('#theads').empty();
    $('#FvsA').empty();
    var html = '';
    html +="<tr style='height:100px'><td colspan='32' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the date parameters to load data.</td></tr>";
    $('#datatable3').append(html);
    var trhead = '<th scope="col" rowspan="2">LINE</th>'+
                        '<th scope="col" rowspan="2">MACHINE</th>'+
                        '<th scope="col" rowspan="2">TABLE</th>'+
                        '<th scope="col" rowspan="2">POSITION</th>';
    $('#theads').append(trhead);
}

function load_running_machine_tbl(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    today = yyyy+"-"+mm+"-"+dd;

    //alert(today);
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/LoadRunning',
        type:'POST',
        data:{
            'today':today
        },
        success: function (data) {
            //console.log(JSON.stringify(data)); '<th scope="col">col1</th>'
            $('#datatable3>tbody').empty();
            $('#theads').empty();
            $('#FvsA').empty();
            var html = '';
            var trhead ='<th scope="col" rowspan="2">LINE</th>'+
                        '<th scope="col" rowspan="2">MACHINE</th>'+
                        '<th scope="col" rowspan="2">TABLE</th>'+
                        '<th scope="col" rowspan="2">POSITION</th>';
            var fvsa = '';
            $('#theads').append(trhead);
            var col_head = 0;
                for(var i = 0; i < data['running'].length; i++){
                        
                        if(col_head<data['running'][i].mounter_id){
                            col_head = data['running'][i].mounter_id;
                            trhead = '<th scope="col" colspan="2">'+data['running'][i].mounter_rel.code+'</th>';
                            $('#theads').append(trhead);
                            fvsa = '<th scope="col" class="text-center">FEEDERLIST</th><th scope="col" class="text-center">SCAN</th>';
                            $('#FvsA').append(fvsa);
                        }

                }
                  
                    for(var a = 0; a < data['machine'].length; a++){
                        var rowcount = 1;
                        for(var b = 1; b <= data['machine'][a].machine_type_rel.table_count; b++){
                           var rowspan_count = data['machine'][a].machine_type_rel.table_count * 3;
                           
                            for(var c = 1; c <= 3; c++){
                                html +='<tr class="text-center">';
                                if(c==1){
                                    position = "LEFT";
                                    if(rowcount==1){
                                        html+='<td rowspan="'+rowspan_count+'" nowrap class="bold-text" id="L'+data['machine'][a].line_id +'">' +  data['machine'][a].line_rel.code+ '</td>';
                                        html+='<td rowspan="'+rowspan_count+'" nowrap class="bold-text" id="M'+data['machine'][a].id +'">' +  data['machine'][a].code+ '</td>';
                                    }
                                   
                                    
                                    var table = "";
                                    html+='<td rowspan="3" nowrap class="bold-text" style="color:' + colorsets()[b] + '">TABLE ' + b + '</td>';
                                    /* if(b==1)
                                    {
                                        table = "TABLE 1";
                                        html+='<td rowspan="3" nowrap class="tbl1 bold-text">' + table + '</td>';
                                    }
                                    else  if(b==2)
                                    {
                                        table = "TABLE 2";
                                        html+='<td rowspan="3" nowrap class="tbl2 bold-text">' + table + '</td>';
                                    }
                                    else  if(b==3)
                                    {
                                        table = "TABLE 3";
                                        html+='<td rowspan="3" nowrap class="tbl3 bold-text">' + table + '</td>';
                                    }
                                    else  if(b==4)
                                    {
                                        table = "TABLE 4";
                                        html+='<td rowspan="3" nowrap class="tbl4 bold-text">' + table + '</td>';
                                    } */
                                }
                                else if(c==2){
                                    position = "RIGHT";
                                   
                                }
                                else if(c==3){
                                    position = "NONE";
                                  
                                }
                                html+='<td nowrap>' + position + '</td>';
                               /*  for(var x = 0; x < data['mounter'].length; x++){
                                    html+='<td id="'+data['machine'][a].id+'-'+b+'-'+c+'-'+ data['mounter'][x].id+'">-</td>';
                                } */
                                col_head = 0;
                                for(var d = 0; d < data['running'].length; d++){
                                    
                                    if(col_head<data['running'][d].mounter_id){
                                        col_head = data['running'][d].mounter_id;
                                        html+='<td id="F'+data['machine'][a].id+'-'+b+'-'+c+'-'+ data['running'][d].mounter_id+'">-</td>';
                                        html+='<td id="A'+data['machine'][a].id+'-'+b+'-'+c+'-'+ data['running'][d].mounter_id+'">-</td>';
                                    }
            
                            }

                                html+='</tr>';
                                rowcount+=1;
                            }

                            if(rowcount==rowspan_count){
                                rowcount=1;
                            }

                        }
                    }

                    $('#datatable3').append(html);

                    for(var y = 0; y < data['running'].length; y++){
                        $('#A'+data['running'][y].machine_id+'-'+data['running'][y].table_id+'-'+data['running'][y].pos_id+'-'+data['running'][y].mounter_id).empty();
                        var runPN = "";
                        runPN=data['running'][y].component_rel.product_number;
                        $('#A'+data['running'][y].machine_id+'-'+data['running'][y].table_id+'-'+data['running'][y].pos_id+'-'+data['running'][y].mounter_id).append(runPN);
                        
                        //ajax for F
                        LoadFeederRunningTable(data['running'][y].machine_id,data['running'][y].table_id,data['running'][y].pos_id,data['running'][y].mounter_id,data['running'][y].model_id);
                    }

               
  
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });
        
}

function LoadFeederRunningTable(machine_id,table_id,position_id,mounter_id,model_id){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/LoadFeederRunningTable',
        type:'POST',
        data:{
            'machine_id':machine_id,
            'table_id':table_id,
            'position_id':position_id,
            'mounter_id':mounter_id,
            'model_id':model_id
        },
        success: function (data) {
            //console.log(JSON.stringify(data));
            $('#F'+machine_id+'-'+table_id+'-'+position_id+'-'+mounter_id).empty();
            var FeedList = "<select class='bold-text'>";
            for(var y = 0; y < data.length; y++){
                FeedList+='<option>'+data[y].component_rel.product_number+' - '+data[y].order_rel.name+'</option>';
                /* data[y].component_rel.product_number; */
                
            }
            FeedList += "</select>";
            $('#F'+machine_id+'-'+table_id+'-'+position_id+'-'+mounter_id).append(FeedList);
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });


}

function gotosearch(){
    var targetloc = document.getElementById('goto_search').value;

    window.location.href = "#"+targetloc;
}

function loaddetails(){
   
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/loadDetails',
        type:'POST',
        data:{
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot
        },
        success: function (data) {
            console.log(JSON.stringify(data));
            
            $('#datatable2>tbody').empty();
            var html = '';
            
            if(data['feedlist'].length==0)
            {
                html +="<tr style='height:100px'><td colspan='9' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the scanning options then load data again.</td></tr>";
            }
            var hold_data="";
            for(var i = 0; i < data['feedlist'].length; i++){
               var table = "";
               table = "TABLE "+ data['feedlist'][i].table_id;
               /* if(data['feedlist'][i].smt_table_rel.name=='A')
               {
                   table = "TABLE 1";
               }
               else  if(data['feedlist'][i].smt_table_rel.name=='B')
               {
                   table = "TABLE 2";
               }
               else  if(data['feedlist'][i].smt_table_rel.name=='C')
               {
                   table = "TABLE 3";
               }
               else  if(data['feedlist'][i].smt_table_rel.name=='D')
               {
                   table = "TABLE 4";
               } */

               var run_data = data['feedlist'][i].smt_table_rel.id;
               if(hold_data!=run_data){
                html += '<tr class="text-center"><td colspan="6" class="bold-text text-left row_table">'+table+'</td></tr>';
                hold_data=run_data
               }

               if(data['feedlist'][i].order_rel.name=="PRIMARY"){
                        html+='<tr class="text-center row_primary">';
                }
                else{
                        html+='<tr class="text-center row_secondary">';
                }
                

                html +='<td>' + data['feedlist'][i].mounter_rel.code  + '</td>' +
                            '<td>' + data['feedlist'][i].smt_pos_rel.name  + '</td>'+
                            '<td>' + data['feedlist'][i].order_rel.name + '</td>'+
                            '<td>' + data['feedlist'][i].component_rel.product_number + '</td>' +
                            '<td>' + data['feedlist'][i].component_rel.authorized_vendor + '</td>' +
                            '<td>' + data['feedlist'][i].component_rel.vendor_pn + '</td>' +
                        '</tr>';
                }   
            
            $('#datatable2').append(html);
           
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });

}

function exportMatloading(){

    var s_date = document.getElementById('mat_hist_date').value;
    if(s_date!=""){
        today = s_date;
    }
    else{
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 
        today = yyyy+"-"+mm+"-"+dd;
    }

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/MatHistExport',
        type:'POST',
        data:{
            'sdate':today
        },
        success: function (data) {
            //console.log(JSON.stringify(data));
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });


}

function ErrorIns(errorType){

    var replenish = "";
    if ($('#replenish').is(":checked")){
        replenish = "YES";
    }
    else{
        replenish = "NO";
    }

    var emp_name = document.getElementById('scan_employee').value;
    var machine_code = document.getElementById('scan_machine').value;
    /* var model_code = document.getElementById('scan_model').value; */
    var position = document.getElementById('scan_pos').value;
    var feeder_slot = document.getElementById('scan_feed_slot').value;
    /* var old_PN = document.getElementById('scan_oldPN').value; */
    var new_PN = document.getElementById('scan_newPN').value;
    var reelInfo = document.getElementById('scan_newPN').value;
    if ($('#replenish').is(":checked")){
        var temp1 = new Array();
        if(old_PN.includes(",")){
            temp1 = old_PN.split(",");
        }
        else if(old_PN.includes(";")){
            temp1 = old_PN.split(";");
        } 

        for (a in temp1 ) {
            temp1[a] = (temp1[a]); 
        }
        /* if(a!=0){
            old_PN = temp1[4].substr(3);
        } */
        if(a!=0){
            for (a in temp1 ) {
                var res2 = temp1[a].split(":");
                if(res2[0] == "PN"){
                    old_PN = res2[1];
                }
            }
        }
       
    }
   

    var temp2 = new Array();
    if(new_PN.includes(",")){
        temp2 = new_PN.split(",");
    }
    else if(new_PN.includes(";")){
        temp2 = new_PN.split(";");
    }  

    for (b in temp2 ) {
        temp2[b] = (temp2[b]);
    }
    /* if(b!=0){
        new_PN = temp2[4].substr(3);
    } */
    if(b!=0){
        for (b in temp2 ) {
            var res2 = temp2[b].split(":");
            if(res2[0] == "PN"){
                new_PN = res2[1];
            }
        }
    }

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/ErrorIns',
        type:'POST',
        data:{
            'replenish':replenish,
            'emp_id':emp_name,
            'machine_id':machine_code,
            /* 'model_id':model_code, */
            'position':position,
            'feeder_slot':feeder_slot,
            /* 'old_PN':old_PN, */
            'new_PN':new_PN,
            'errorType':errorType,
            'reelInfo':reelInfo
        },
        success: function (data) {
            
            //alert(data);
           
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });

}

function LoadErrorTbl(){

    var s_date = document.getElementById('date_error').value;
    var today = new Date();

    if(s_date!=""){
        today = s_date;
    }
    else{
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 
        today = yyyy+"-"+mm+"-"+dd;
        document.getElementById('date_error').value = yyyy+"-"+mm+"-"+dd;
    }

    document.getElementById('hidDateParam').value=today;
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: 'ajax/loadError',
        type:'POST',
        data:{
            'sdate':today
        },
        success: function (data) {
            //console.log(JSON.stringify(data));
            
            $('#datatable2>tbody').empty();
            var html = '';
            
            if(data.length==0)
            {
                html +="<tr style='height:100px'><td colspan='10' class='text-center' style='font-size:1.5em'>No data to display. Try to configure the date parameters to load data.</td></tr>";
            }
 
            for(var i = 0; i < data.length; i++){
               var table = "";
               table = "TABLE "+ data[i].table_id;
               /* if(data[i].smt_table_rel.name=='A')  
               {
                   table = "TABLE 1";
               }
               else  if(data[i].smt_table_rel.name=='B')
               {
                   table = "TABLE 2";
               }
               else  if(data[i].smt_table_rel.name=='C')
               {
                   table = "TABLE 3";
               }
               else  if(data[i].smt_table_rel.name=='D')
               {
                   table = "TABLE 4";
               } */
               var mnt = '';
               var mc = '';
               var ps = '';
               if(data[i].mounter_id){
                mnt = data[i].mounter_rel.code;
               }               
               if(data[i].machine_id){
                   mc = data[i].machine_rel.code;
                }
                if(data[i].pos_id){
                    ps = data[i].smt_pos_rel.name;
                }          

                html +='<tr class="text-center">'+
                            '<td nowrap>' + data[i].created_at + '</td>' +
                            '<td nowrap>' + data[i].component_rel.product_number + '</td>' +
                            '<td nowrap>' + data[i].component_rel.authorized_vendor + '</td>' +
                            '<td nowrap>' + mc  + '</td>' +
                            '<td nowrap>' + data[i].smt_model_rel.code  + '</td>'+
                            '<td nowrap>' + table + '</td>'+
                            '<td nowrap>' + mnt + '</td>' +
                            '<td nowrap>' + ps + '</td>' +
                            '<td nowrap>' + data[i].employee_rel.lname + ', '+ data[i].employee_rel.fname + '</td>' +
                            '<td nowrap>' + data[i].ErrorType + '</td>' +
                        '</tr>';
                }   
            
            $('#datatable2').append(html);
           
        }/* ,
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        } */
    });

}
function error_clear_date(){
    document.getElementById('date_error').value="";
    LoadErrorTbl();
}

function resetemp(){
    document.getElementById("scan_emp").value="";
    document.getElementById("scan_employee").value="";
    document.getElementById("scan_emp").focus();
    document.getElementById("scan_emp").readOnly = false;
    $("#scan_employee").val("").trigger("change");
    $("#scan_model").val("").trigger("change");
}

$('#res_emp').on('click', function(e){
    resetemp();
});

/* Clickable table row */
$(document).on('click', '.clickable-row', function(e) {        
    if($(this).hasClass("highlight2"))
    {
        $(this).removeClass('highlight2');
        /* $('#repair_btn_'+$(this).data('id')).hide(); */
        /* $('#action_div_'+$(this).data('id')).hide();
        $('#details_div_'+$(this).data('id')).show(); */
        var toast = document.querySelector('.iziToast');
        iziToast.hide({
            transitionOut: 'fadeOutUp'
        }, toast);
        /* iziToast.destroy(); */
    }        
    else
    {
        $(this).addClass('highlight2').siblings().removeClass('highlight2');
        /* $('.action_div').hide();   */   
        /* clickeddanplarow = $(this).data('id'); */
        /* alert($(this).data('id')); */
        /* $('#repair_btn_'+$(this).data('id')).show(); */
        /* $('#action_div_'+$(this).data('id')).show();
        $('#details_div_'+$(this).data('id')).hide(); */
        iziToast.destroy();
        displaymenu($(this).data('sn'),$(this).data('rep'),$(this).data('id'),$(this).data('div'),$(this).data('repby'),$(this).data('arr'));
    }
});
$('.form_to_submit').on('submit',function(){
    $('.form_submit_button').prop('disabled', true);
    $('.form_submit_button').html('<img src="http://172.16.1.13:8000/1_smt/public/images/loading2.gif" alt="Loading gif" style="height:1.5rem;width:auto;overflow:hidden;margin-top:-4px;padding-left:-10px"> Processing... Please Wait...');
});
$(function () {
    $('[data-toggle="popover"]').popover({ html : true});
    $('[data-toggle="popover"]').on('click', function (e) {
        $('[data-toggle="popover"]').not(this).popover('hide');
    });
})
function ddpop(id,id1,id2,id3){
    $.get("processes/"+ id, 
        { id: id }, 
        function(data) {
            var model = $('#'+id1);
            model.empty();
            model.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            }
            else{
                model.attr('disabled',true);
                model.append("<option value=''>No Process Found.</option>");
            }
            
        });
    $.get("defects/"+ id, 
        { id: id }, 
        function(data) {
            var model1 = $('#'+id2);
            model1.empty();
            model1.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model1.append("<option value='"+ element.DEFECT_ID +"'>" + element.DEFECT_NAME + "</option>");
                });
            }
            else{
                model1.attr('disabled',true);
                model1.append("<option value=''>No Defect Found.</option>");
            }
            
        });
    $.get("linenames/"+ id, 
        { id: id }, 
        function(data) {
            var model2 = $('#'+id3);
            model2.empty();
            model2.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model2.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            }
            else{
                model2.attr('disabled',true);
                model2.append("<option value=''>No Line Found.</option>");
            }
            
        });
}
function ddpop2(id,id1,id2,arr){
    $.get("processes/"+ id, 
        { id: id }, 
        function(data) {
            var model = $('#'+id1);
            model.empty();
            model.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
                model.val(arr.process_id);
            }
            else{
                model.attr('disabled',true);
                model.append("<option value=''>No Process Found.</option>");
            }
            
        });
    $.get("defects/"+ id, 
        { id: id }, 
        function(data) {
            var model1 = $('#'+id2);
            model1.empty();
            model1.attr('disabled',false);
            if(data.length > 0){
                $.each(data, function(index, element) {
                    model1.append("<option value='"+ element.DEFECT_ID +"'>" + element.DEFECT_NAME + "</option>");
                });
                model1.val(arr.defect_id);
            }
            else{
                model1.attr('disabled',true);
                model1.append("<option value=''>No Defect Found.</option>");
            }
            
        });              
}
function displaymenu(sn,rep,id,div,repby,arr){
    /* var arr1 = JSON.parse(arr); */
    /* alert(JSON.stringify(arr)); */
    /* alert(repby); */
    /* var df = arr.defected_at;
    var df2 = df.substr(0,10)+'T'+df.substr(11);    */ 
    if(rep == 0){
        buttons = [
            ["<a id='edit_defectmat_btn_{{$defect_mat->id}}' style='font-size:20px' class='btn btn-outline-primary nav-link btn-sm edit_defectmat_btn py-1 px-2' title='Edit' data-id='{{$defect_mat->id}}'><i class='fas fa-edit'></i> Edit</a>", function (instance, toast) {
                ddpop2(div,'aprocess_id','adefect_id',arr);
                $('#aserial_number').val(sn);
                /* $('#adivision_id').val(div);
                $('#aline_id').val(arr.line_id); */
                /* $('#adefect_datetime').val(df2); */
                $('#adefect_type_id').val(arr.defect_type_id);
                $('#edit_defect_form').attr('action', '/1_smt/public/defectmats/'+arr.id);
                $('#edit_defect_modal').modal('show');
                $('#aprocess_id').val(arr.process_id);
                $('#adefect_id').val(arr.defect_id);
            }],
            /* ["<a id='repair_defectmat_btn_{{$defect_mat->id}}' style='font-size:20px' class='btn btn-outline-primary nav-link btn-sm repair_defectmat_btn py-1 px-2' title='Repair' data-id='{{$defect_mat->id}}'><i class='fas fa-hammer'></i> Repair</a>", function (instance, toast) { 
                $('#repair_defectmat_form').attr('action', '/1_smt/public/defectmats_rep/'+id);
                $('#repair_modal').modal('show');
            }], */
        ]
    }
    else{
        buttons = [
            ["<a id='details_defectmat_btn_{{$defect_mat->id}}' style='font-size:20px' class='btn btn-outline-primary nav-link btn-sm details_defectmat_btn py-1 px-2' title='View Repair' data-id='{{$defect_mat->id}}'><i class='fas fa-eye'></i> Details</a>", function (instance, toast) { 
                /* alert(repby); */
                $('#drepair_by').val(repby);
                $('#dremarks').val(arr.remarks);
                $('#drepaired_at').val(arr.repaired_at);
                $('#repair_details_modal').modal('show');
            }],
        ]
    }
    iziToast.info({
        timeout: false,
        /* overlay: true, */
        /* layout: 2, */
        titleSize: 25,
        titleLineHeight: 26,
        messageSize: 25,
        messageLineHeight: 26,
        icon: 'fas fa-cog',
        displayMode: 'once',
        id: 'inputs',
        zindex: 999,
        title: 'S/N:',
        message: ''+sn+'',
        position: 'bottomCenter',
        close: false,
        buttons: buttons
    });
}