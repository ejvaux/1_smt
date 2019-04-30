function empcheckpin(pin)
{
    $('#scan_employee').val('Please Wait . . .');
    $('#scan_employee').attr('readonly', true);
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'scanpinemp',
        type:'POST',
        global: false,
        data:{
            'pin': pin
        },
        success: function (data) {
            if(data != 0)
            {
                $('#scan_employee').hide();
                $('#scan_name').val(data.fname + ' ' + data.lname);
                $('#employee_id').val(data.id);
                $('#scan_name_div').show();
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
    $('#scan_employee').attr('readonly', false);
    $('#scan_name_div').hide();
    $('#scan_employee').show();
    $('#scan_employee').focus();
}
$('#addDefect_btn').on('click', function(){
    $('#add_defect_modal').modal('show');
});
$('#repair_btn').on('click', function(){
    $('#repair_modal').modal('show');
});
$('#defect_datetime').on('change', function(){
    var dt = new Date($(this).val());
    var dte = moment(dt).format('HH:mm');
    if(dte > '05:59' && dte < '18:00'){
        $('#shift').val('1')
    }
    else if(dte => '18:00' || dte < '06:00'){
        $('#shift').val('2');
    }
    else{
        $('#shift').val('0');
    }
});
$('#scan_employee').on('keypress', function(e){    
    if(e.keyCode == 13)
    {
        e.preventDefault();
        empcheckpin($(this).val());
    }
});
$('#reset_emp').on('click', function(){
    resetemp();
});
$('.repair_btn').on('click', function(){
    alert($(this).data('id'));
});
$('#defect_id').on('change', function(){
    var selected = $(this).find('option:selected');
    $('#division_id').val(selected.data('div_id'));
});
$('#add_defect_form').on('submit', function(){
    if ($('#employee_id').val() == '') {
        iziToast.warning({
            title: 'WARNING',
            message: 'No employee set!',
            position: 'topCenter'
        });
        $('.form_submit_button').prop('disabled', false);
        $('.form_submit_button').html('<i class="far fa-save"></i> Save');
        return false;        
    }
});