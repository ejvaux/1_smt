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
            if ($('#snhead').html() != '') {
                $('#serialExport').val($('#snhead').html());
                $('#exportBtn').attr('disabled',false);                
            }
            else{
                $('#exportBtn').attr('disabled',true);
            }
        }
    });    
}

/* EVENTS */
$('#snTB').on('keypress', function(e){
    if (e.keyCode == 13){
        loadreel(this.value);
        this.value = '';
    }
});
/* $('#exportBtn').on('click', function(){
    alert('TEST');
}); */