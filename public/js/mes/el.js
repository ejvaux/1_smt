$('#repair,#repair-add-check').bootstrapToggle({
    on: 'Yes',
    off: 'No',
    onstyle: 'success',
    offstyle: 'danger'
});

/* $('#employee-dd').select2({
    width: '100%',
    maximumSelectionLength: 20
}); */

$('.editEmployee').on('click', function(){
    /* alert('Test'); */
    $('#fname').val($(this).data('fn'));
    $('#lname').val($(this).data('ln'));
    if($(this).data('rp')){
        $('#repair').bootstrapToggle('on');
    }
    else{
        $('#repair').bootstrapToggle('off');
    }
    $('#edit_emp_form').attr('action', '/1_smt/public/employees/'+$(this).data('id'));
    $('#edit_emp_details').modal('show');
});
$('.deleteEmployee').on('click', function(){    
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {
            alert('delete');
            /* $('#del_comp_form_'+$(this).data('id')).trigger('submit'); */
        }
    })
});
$('#add-el-btn').on('click',function(e){
    $('#add-el-modal').modal('show');
});
$('#export-el-btn').on('click', function(e){
    $('#export-el-modal').modal('show');
});
$('#export-el-modal').on('hidden.bs.modal',function(){
    $("#employee-dd").val([]).trigger("change");
});