// Functions
function loadlist(line){
    $.ajax({
        url: 'mload',
        type:'get',
        data: {
            'line':  line
        },
        success: function (data) {            
            $('#ml_div').html(data);
        }
    });
}

// Events
$('#ml-btn-submit').on('click', function(){
    if ($('#line').val()) {
        loadlist($('#line').val());
    }
    else{
        iziToast.error({
            title: 'ERROR',
            position: 'topCenter',
            message: 'Select Line First.',
        });
    }    
});
$('#ml_div').on('click', '.delMat', function(e){
    alert('TEST');
});