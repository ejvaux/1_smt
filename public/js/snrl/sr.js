/* FUNCTIONS */
function loadreel($sn){
    $.ajax({
        url: 'loadreel',
        type:'get',
        data: {
            'sn':  $sn
        },
        success: function (data) {           
            $('#sntTableDiv').html(data);
            $('#snhead').html($('#snTB').val());
            $('#snTB').val('');
        }
    });    
}

/* EVENTS */
$('#snTB').on('keypress', function(e){
    if (e.keyCode == 13){
        loadreel(this.value);
    }
});
/* $('#exportBtn').on('click', function(){
    alert('TEST');
}); */