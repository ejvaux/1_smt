{{-- ADD Component --}}
<div class="modal hide fade in" role="dialog" id="add_linename_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Line</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_linename_form"  method="post" action='{{url('linenames')}}'>
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-md">
                        <div class="row">
                            <div class="col-5">
                                <label for="name" class="col-form-label">NAME:</label>                  
                            </div>
                            <div class="col-7">
                                <input id='name' type="text" class='form-control' name="name">                   
                            </div>
                        </div>
                    </div>                                
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="add_linename_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT Component --}}
<div class="modal hide fade in" role="dialog" id="edit_linename_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Line</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_linename_form"  method="post" action=''>
                @method('PUT')
                <input type="hidden" id="user_id" name="user_id">
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-md">
                        <div class="row">
                            <div class="col-5">
                                <label for="ename" class="col-form-label">NAME:</label>                  
                            </div>
                            <div class="col-7">
                                <input id='ename' type="text" class='form-control' name="name">                   
                            </div>
                        </div>
                    </div>                                
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="edit_linename_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>