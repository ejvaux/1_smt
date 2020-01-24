/* EVENT */

$('#process-add-btn').on('click', function(e){
    alert('TEST');
});
$('.process-delete-btn').on('click', function(e){
    alert($(this).data('id'));
});