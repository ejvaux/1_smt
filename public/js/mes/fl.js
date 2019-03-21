/* $('.viewModel').on('click', function(){
    alert('View');
});
$('.editModel').on('click', function(){
    alert('Edit');
});
$('.deleteModel').on('click', function(){
    alert('Delete');
}); */
function viewfeederlist($m_id,$mt_id){
    $.ajax({
        type		: "GET",
        url		    : "/1_smt/public/fldmach/"+ $m_id +"/" + $mt_id,
        success		: function(html) {					
                        $("#fltable").html(html).show('slow');
                    }
    });
}
$('#flviewmachine').on('change', function(){
    /* alert($(this).val()); */
    viewfeederlist($('#mdl_id').val(),$(this).val());
});
$("#fltable").on('click','.addCmp', function(){
    /* alert($(this).data('model')+'---'+$(this).data('mach')+'---'+$(this).data('table')); */
    $('#amodel_id').val($(this).data('model'));
    $('#amachine_type_id').val($(this).data('mach'));
    $('#atable_id').val($(this).data('table'));
    $('#add_comp_form').trigger("reset");
    $('#atable_number').text($(this).data('table'));
    $('#add_comp').modal('show');
    $('.sel').select2({width: '100%'});
});
$("#fltable").on('click', '.cmp_edit', function(){
    /* alert($(this).data('model')+'---'+$(this).data('mach')+'---'+$(this).data('table')+'---'+$(this).data('mount')+'---'+$(this).data('pos')+'---'+$(this).data('pref')+'---'+$(this).data('cmp')); */
    $('#model_id').val($(this).data('model'));
    $('#machine_type_id').val($(this).data('mach'));
    $('#table_id').val($(this).data('table'));
    $('#mounter_id').val($(this).data('mount'));
    $('#pos_id').val($(this).data('pos'));
    $('#order_id').val($(this).data('pref'));
    $('#component_id').val($(this).data('cmp'));
    $('#feeder_id').val($(this).data('id'));

    $('#table_number').text($(this).data('table'));
    $('#edit_comp').modal('show');
    $('.sel').select2({width: '100%'});
});
$("#fltable").on('click', '.cmp_delete', function(){
    /* alert($(this).data('model')+'---'+$(this).data('mach')+'---'+$(this).data('table')+'---'+$(this).data('mount')+'---'+$(this).data('pos')+'---'+$(this).data('pref')+'---'+$(this).data('cmp')); */    
    /* alert($(this).data('id')); */
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
            $.ajax(
                {
                method:'DELETE',
                url:"/1_smt/public/feeders/"+$(this).data('id'),
                /* data: {
                    "_token":$('meta[name="csrf-token"]').attr('content')
                }, */
                success: function(data) {          
                    iziToast.success({
                        message: data,
                        position: 'topCenter',
                        timeout: 5000,
                        displayMode: 'replace'
                    });
                    $('#add_comp').modal('hide');
                    viewfeederlist($('#mdl_id').val(),$('#flviewmachine').val());
                }
            });
        }
    })    
});
$("#fdrmodl").on('click','#add_comp_submit', function(){
    /* alert('TEST'); */
    $.ajax(
        {
        method:'POST',
        url:"/1_smt/public/feeders",
        data: 
        {
            /* "_token":           $('meta[name="csrf-token"]').attr('content'), */
            'model_id':         $('#amodel_id').val(),
            'machine_type_id':  $('#amachine_type_id').val(),
            'table_id':         $('#atable_id').val(),
            'mounter_id':       $('#amounter_id').val(),
            'pos_id':           $('#apos_id').val(),
            'order_id':         $('#aorder_id').val(),
            'component_id':     $('#acomponent_id').val(),
            'user_id':          $('meta[name="user_num"]').attr('content')
        },
        success: function(data) {          
            iziToast.success({
                message: data,
                position: 'topCenter',
                timeout: 5000,
                displayMode: 'replace'
            });
            $('#add_comp').modal('hide');
            viewfeederlist($('#mdl_id').val(),$('#flviewmachine').val());
        }
    });
});
$("#fdrmodl").on('click','#edit_comp_submit', function(){
    /* alert('TEST'); */
    $.ajax(
        {
        method:'PUT',
        url:"/1_smt/public/feeders/"+ $('#feeder_id').val(),
        data: 
        {
            'model_id':         $('#model_id').val(),
            'mounter_id':       $('#mounter_id').val(),
            'pos_id':           $('#pos_id').val(),
            'order_id':         $('#order_id').val(),
            'component_id':     $('#component_id').val()
        },
        success: function(data) {          
            iziToast.success({
                message: data,
                position: 'topCenter',
                timeout: 5000,
                displayMode: 'replace'
            });
            $('#edit_comp').modal('hide');
            viewfeederlist($('#mdl_id').val(),$('#flviewmachine').val());
        }
    });
});