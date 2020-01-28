{{-- ADD PROCESS --}}
<div class="modal hide fade in" role="dialog" id="add_process_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Process</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='form_to_submit' id="add_process_form"  method="POST">
            <input type="hidden" id="user_id" name="user_id">            
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="product_number" class="col-form-label">Code:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="code" required>
                            </div>
                        </div>
                    </div>                               
                </div>
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="authorized_vendor" class="col-form-label">Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="name" required>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="vendor_pn" class="col-form-label">Department:</label>                  
                            </div>
                            <div class="col-7">
                                <select class='form-control' name="division_id" required>
                                    <option value="">-Select Department-</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                    @endforeach    
                                </select>                
                            </div>
                        </div>
                    </div>                       
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="add_process_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT PROCESS --}}
<div class="modal hide fade in" role="dialog" id="edit_process_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Process</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='form_to_submit' id="edit_process_form"  method="POST">
            <input type="hidden" id="e_user_id" name="user_id"> 
            <input type="hidden" id='process_id' name="">
            @method('PUT')          
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="product_number" class="col-form-label">Code:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="code" id="code" required>
                            </div>
                        </div>
                    </div>                               
                </div>
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="authorized_vendor" class="col-form-label">Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="name" id="name" required>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-group row">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <label for="vendor_pn" class="col-form-label">Department:</label>                  
                            </div>
                            <div class="col-7">
                                <select class='form-control' name="division_id" id="division_id" required>
                                    <option value="">-Select Department-</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                    @endforeach    
                                </select>                
                            </div>
                        </div>
                    </div>                       
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="edit_process_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>