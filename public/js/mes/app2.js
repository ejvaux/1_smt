$('.form_to_submit').on('submit',function(){
    $('.form_submit_button').prop('disabled', true);
    $('.form_submit_button').html('Processing... Please Wait...');
});