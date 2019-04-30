function empcheckpin(pin,set)
{
    if (set == '1'){
        $('#scan_employee').val('Please Wait . . .');
        $('#scan_employee').attr('readonly', true);
    }
    else if(set == '2'){
        $('#ascan_employee').val('Please Wait . . .');
        $('#ascan_employee').attr('readonly', true);
    }
    else if(set == '3'){
        $('#escan_employee').val('Please Wait . . .');
        $('#escan_employee').attr('readonly', true);
    }

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
                if(set == '1'){
                    $('#scan_employee').hide();
                    $('#scan_name').val(data.fname + ' ' + data.lname);
                    $('#employee_id').val(data.id);
                    $('#scan_name_div').show();
                    $('#division_id').focus();
                }
                else if(set == '2'){
                    $('#ascan_employee').hide();
                    $('#ascan_name').val(data.fname + ' ' + data.lname);
                    $('#aemployee_id').val(data.id);
                    $('#ascan_name_div').show();
                    $('#aremarks').focus();
                }
                else if(set == '3'){
                    $('#escan_employee').hide();
                    $('#escan_name').val(data.fname + ' ' + data.lname);
                    $('#eemployee_id').val(data.id);
                    $('#escan_name_div').show();
                    $('#adivision_id').focus();
                }
                
                iziToast.success({
                    title: 'SUCCESS',
                    message: 'Employee found.',
                    position: 'topCenter'
                });
            }
            else
            {
                resetemp(set);
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
            resetemp(set);
        }
    });
}
function resetemp(set)
{
    if(set == 1){
        $('#scan_employee').val('');
        $('#scan_employee').attr('readonly', false);
        $('#scan_name_div').hide();
        $('#scan_employee').show();
        $('#scan_employee').focus();
    }
    else if(set == 2){
        $('#ascan_employee').val('');
        $('#ascan_employee').attr('readonly', false);
        $('#ascan_name_div').hide();
        $('#ascan_employee').show();
        $('#ascan_employee').focus();
    }
    else if(set == 3){
        $('#escan_employee').val('');
        $('#escan_employee').attr('readonly', false);
        $('#escan_name_div').hide();
        $('#escan_employee').show();
        $('#escan_employee').focus();
    }
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
$('#adefect_datetime').on('change', function(){
    var dt = new Date($(this).val());
    var dte = moment(dt).format('HH:mm');
    if(dte > '05:59' && dte < '18:00'){
        $('#shift').val('1')
    }
    else if(dte => '18:00' || dte < '06:00'){
        $('#ashift').val('2');
    }
    else{
        $('#ashift').val('0');
    }
});
$('#scan_employee').on('keypress', function(e){    
    if(e.keyCode == 13)
    {
        e.preventDefault();
        empcheckpin($(this).val(),'1');
    }
});
$('#ascan_employee').on('keypress', function(e){    
    if(e.keyCode == 13)
    {
        e.preventDefault();
        empcheckpin($(this).val(),'2');
    }
});
$('#escan_employee').on('keypress', function(e){    
    if(e.keyCode == 13)
    {
        e.preventDefault();
        empcheckpin($(this).val(),'3');
    }
});
$('#reset_emp').on('click', function(){
    resetemp('1');
});
$('#areset_emp').on('click', function(){
    resetemp('2');
});
$('#ereset_emp').on('click', function(){
    resetemp('3');
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
$('#edit_defect_form').on('submit', function(){
    if ($('#eemployee_id').val() == '') {
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
$('#repair_defectmat_form').on('submit', function(){
    if ($('#aemployee_id').val() == '') {
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
$('#serial_number').on('keypress', function(e){
    if(e.keyCode == 13)
    {
        e.preventDefault();
        $('#scan_employee').focus();
    }
});
$('.edit_defectmat_btn').on('click', function(){
    $('#edit_defect_modal').modal('show');
});
$('.repair_defectmat_btn').on('click', function(){
    $('#repair_defectmat_form').attr('action', '/1_smt/public/defectmats/'+$(this).data('id'));
    $('#repair_modal').modal('show');
});
$('.details_defectmat_btn').on('click', function(){
    alert('Details');
});

$('#division_id').on('change',function(){
    ddpop($(this).val(),'process_id','defect_id');
})
$('#adivision_id').on('change',function(){
    ddpop($(this).val(),'aprocess_id','adefect_id');
})