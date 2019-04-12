{{-- Edit Component --}}
<div class="modal hide fade in" role="dialog" id="edit_emp_details" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_emp_form" method="POST" action='{{}}'>
            @method('PUT')           
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="fname" class="col-form-label">First Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="fname" id="fname" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="lname" class="col-form-label">Last Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="lname" id="lname" required>
                            </div>
                        </div>
                    </div>                                
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="edit_emp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>