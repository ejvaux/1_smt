/*   
function get_errorcode()
    {
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            url: 'ajax/errorcode',
            type:'POST',
            dataType:'JSON',
            data:{
                'ajax':'text'
            },
            success: function (data) {
                //dt = JSON.stringify(data);
               
                return data;
                  
              
            },
            error: function (data) {
                marker = JSON.stringify(data);
                alert(marker);
            }
        });
    } */

      /* 
             var data = get_errorcode();
            for (var i = 0; i < data.length; i++){
                var obj = data[i];
                for (var key in obj){
                  var value = obj[key];
                  alert(value.error_code);
                }
                
            }
            */



$(document).ready(function() {
    $('.select2').select2({width: '100%'});
    //$('.select22').select2({dropdownParent: $(".modal"),width: '100%'}); search_select2
    });

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
                    }
                    else{
                        iziToast.error({ title: 'ERROR',position: 'topCenter', message: 'Please complete the required fields. Select a Process and Prod Line.',});
                    }

               /*  Swal.fire({
                    title: 'Select item status?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK-GOOD',
                    cancelButtonText:'NG-NOT GOOD'
                  }).then((result) => {
                    if (result.value) {
                        ///if input has no errorcode
                            if ($('#input_type').is(":checked")){
                                    datainput="IN";
                                    CheckRecord("OK",datainput);
                            }
                            else {
                                    datainput="OUT";
                                    CheckRecord("OK",datainput);      
                            }
                    }
                    else if(result.dismiss == 'cancel'){
                        //if has error ->input error code on modal
                        //document.getElementById("ecode_sel").focus();
                        $('.modal').modal('show');

                     }
                  
                  }) */

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
        },
        error: function (data) {
            marker = JSON.stringify(data);
            //alert(marker);
        }
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

        },
        error: function (data) {
            marker = JSON.stringify(data);
            alert(marker);
        }
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
        var pname = document.getElementById('bot_panel_process_sel').value;
        var pline = document.getElementById('bot_panel_prodline_sel').value;
        var snum = document.getElementById('bot_panel_input_serial').value;
        var mach = document.getElementById('bot_panel_machine_sel').value;
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
                'sel_machine':mach
            },
            success: function (data) {
                //$('#datatable tr').not(':first').not(':last').remove();
              console.log(JSON.stringify(data));
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
                            '<td>' + "ctrls" + '</td>' +  
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
            },
            error: function (data) {
                marker = JSON.stringify(data);
                //alert(marker);
            }
        });
    }

    function LoadSAPDataTable(){
        var selectedDate = document.getElementById('SAP_date').value;
        var searchbox = document.getElementById('SAP_searchbox').value;
        var searchfield = document.getElementById('search_field').value;
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
            console.log(JSON.stringify(data));
            $('#JOdatatable>tbody').empty();
            var html = '';
            
            
            if(data.length==0)
            {
                html +="<tr style='height:100px'><td colspan='6' class='text-center' style='font-size:1.5em'>No data to display.</td></tr>";
            }
            for(var i = 0; i < data.length; i++){

                var total = 0;
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                $.ajax({
                    url: 'ajax/totalpjo',
                    type:'POST',
                    data:{
                        'pid':data[i].DocEntry
                    },
                    success: function (data2) {
                        //alert(data2.length);
                        total = data2.length
                    },
                    error: function (data) {
                        marker = JSON.stringify(data);
                        //alert(marker);
                    }
                });

                
                html += '<tr class="text-center">'+
                            '<td>' + "<button class='btn btn-sm btn-danger' style='font-size:0.7em'"+
                            " onclick='JOSelectRow("+"\""+data[i].DocNum+"\",\""+data[i].ItemCode+"\",\""+data[i].ProdName+"\",\""+data[i].PlannedQty+"\",\""+data[i].DocEntry+"\")'"+
                            "><i class='fas fa-check-square'></i>&nbspSELECT</button>" + '</td>' +  
                            '<td>' + data[i].DocNum + '</td>' +
                            '<td>' + data[i].ItemCode  + '</td>' +
                            '<td>' + data[i].ProdName + '</td>' +
                            '<td>' + Math.round(data[i].PlannedQty) + '</td>' +
                            '<td>' + total + '</td>' +
                        '</tr>';
                }   

            //$('#datatable tr').first().after(html);
            $('#JOdatatable').append(html);
            },
            error: function (data) {
                marker = JSON.stringify(data);
                //alert(marker);
            }
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
        $('#bot_panel_prodline_sel').val(document.getElementById('prodline_sel').value).trigger('change');
    }

    function SetProcess()
    {
        $('#bot_panel_process_sel').val(document.getElementById('process_sel').value).trigger('change');
    }
    function SetMachine()
    {
        $('#bot_panel_machine_sel').val(document.getElementById('machine_sel').value).trigger('change');
    }

    function ScanRecordClearData()
    {
        document.getElementById('bot_panel_process_sel').value = "";
        document.getElementById('bot_panel_machine_sel').value = "";
        document.getElementById('bot_panel_prodline_sel').value = "";
        document.getElementById('bot_panel_input_serial').value = "";
        $('#bot_panel_process_sel').val("").trigger('change');
        $('#bot_panel_machine_sel').val("").trigger('change');
        $('#bot_panel_prodline_sel').val("").trigger('change');
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
        document.getElementById('SAP_date').value = yyyy+mm+dd;
        document.getElementById('SAP_searchbox').value="";
        LoadSAPDataTable();
    }