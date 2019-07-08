/* Good Function */
$('.gbtn').on('click',function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Make this lot good!'
        }).then((result) => {
        if (result.value) {
       

        swal.fire(
        'Mark as No Good!',
        'Your file has been Marked as Good.',
        'success')
        $('#qcGood').trigger('submit');
        }
        })
});


/* No Good Function */
$('.ngbtn').on('click',function(){
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Make this lot No good!'
        }).then((result) => {
        if (result.value) {
       

        swal.fire(
        'Mark as No Good!',
        'Your file has been Marked as No Good.',
        'success')

        $('#qcnoGood').trigger('submit');
        }
        })
});

/* Getting Lot Number */

$('.showlot').on('click', function(){

    $('#idlot').val($(this).data('idqc'));
    /* $('#name').val($(this).data('name')); */
    //$('#editFormDefectTypeModal').attr('action', '/1_smt/public/defecttype/'+$(this).data('id'));
    $('#modalqc').modal('show');
});