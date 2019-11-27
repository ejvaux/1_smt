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
    loadlist($('#line').val());
});