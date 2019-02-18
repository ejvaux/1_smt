$(document).ready(function() {
    $('.select2').select2({width: '100%'});
    });


function enterEvent(e) {
        var data = "";
        var input_text = document.getElementById('input_scan').value;
        if ($('#input_type').is(":checked")){
        data="switch on";
        }
        else{
            data="switch off"
        }
        
        if (e.keyCode == 13){
            if(input_text==""){
                iziToast.error({
                    title: 'ERROR',
                    position: 'topCenter',
                    message: 'Please Input Serial Number!',
                });
            }
            else {
                iziToast.success({
                    title: 'OK',
                    position: 'topCenter',
                    message: input_text+' Successfully added to the record!',
                });
            }
            document.getElementById('input_scan').value="";
        }
        
    }