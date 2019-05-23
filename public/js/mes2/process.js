 /* Modals for editing employees */

 $('.editProcess').on('click', function(){
    /*  $('#code').val($(this).data('code'));
     $('#name').val($(this).data('name'));
     $('#division_id').val($(this).data('division_id')); */
     $('#code').val($(this).data('code'));
     $('#name').val($(this).data('name'));
     $('#division_id').val($(this).data('division_id'));
     $('#editFormProcessModal').attr('action', '/1_smt/public/process/'+$(this).data('id'));
     $('#editProcessModal').modal('show');
 });

$('.editProcess1').on('click', function(){
   /*  $('#code').val($(this).data('code'));
    $('#name').val($(this).data('name'));
    $('#division_id').val($(this).data('division_id')); */

    $('#editFormProcessModal').attr('action', '/1_smt/public/process/'+$(this).data('id'));
    $('#editProcessModal').modal('show');
});


 /* Modals for editing employees */
 /* $('.tableClick').on('click', function(){

    $('#code1').val($(this).data('code1'));
    $('#name1').val($(this).data('name1'));
    $('#division_id1').val($(this).data('division_id1'));
    //Check to see if background color is set or if it's set to white.
    if(this.style.background == "" || this.style.background =="white") {
        $(this).css('background', 'lightblue');


    }
    else {
        $(this).css('background', 'white');
    }


}); */



/* Delete Function */
$('.del_process_btn').on('click',function(){
    swal.fire({
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
        $('#DeleteProcessForm_'+$(this).data('id')).trigger('submit');
        /* alert($('#DeleteProcessForm_'+$(th).data('id')).attr('action')); */

        swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success')
        }
        })
});

/* Table Sorting Function */
function myFunctionTableDtr() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
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
