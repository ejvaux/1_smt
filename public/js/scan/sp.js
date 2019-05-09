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
                model.append("<option value=''>No Data Found.</option>");
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
        global: false,
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
                
                iziToast.success({
                    title: 'SUCCESS',
                    message: 'Employee found.',
                    position: 'topCenter'
                });
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
                // something weird is happening
            }
            resetemp();
        }
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
}

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
    $div = $('#sel_division_sap_id').val();
    $dte = $('#woDate').val();
    $.get("api/loadWOtable",
        { 
            div:  $div,
            dte: $dte
         }, 
        function(data) {
            $('#spTablediv').html(data);            
        });
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
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, set it!'
      }).then((result) => {
        if (result.value) {
          swal.fire(
            'SET!',
            'Work Order has been set.',
            'success'
          )
        }
      })
});
