$('.editDefect').on('click', function(){

     $('#code').val($(this).data('code'));
     $('#name').val($(this).data('name'));
     $('#editFormDefectTypeModal').attr('action', '/1_smt/public/defecttype/'+$(this).data('id'));
     $('#editDefectTypeModal').modal('show');
 });


/* Delete Function */
$('.del_defect_btn').on('click',function(){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.value) {
        //initialize delete function calling the delete method
        $('#DeleteDefectTypeForm_'+$(this).data('id')).trigger('submit');
        /* alert($('#DeleteProcessForm_'+$(th).data('id')).attr('action')); */

        Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success')
        }
        })
});


/* Table Sorting Function */
function myFunctionTableDefect() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInputTable");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableDefect");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }

