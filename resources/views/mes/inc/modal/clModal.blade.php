{{-- Add Component --}}
<div class="modal hide fade in" role="dialog" id="add_new_comp_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='form_to_submit' id="add_new_comp_form"  method="POST" action='{{url("components")}}'>
            <input type="hidden" id="user_id" name="user_id">            
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="product_number" class="col-form-label">Product Number:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="product_number" id="product_number">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="authorized_vendor" class="col-form-label">Authorized Vendor:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="authorized_vendor" id="authorized_vendor">
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="vendor_pn" class="col-form-label">Vendor P/N:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="vendor_pn" id="vendor_pn">                 
                            </div>
                        </div>
                    </div>                               
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="add_new_comp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Component --}}
<div class="modal hide fade in" role="dialog" id="edit_comp_details" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Component Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_comp_form" method="POST" action=''>
            @method('PUT')
            <input type="hidden" id="user_id" name="user_id">            
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="eproduct_number" class="col-form-label">Product Number:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="product_number" id="eproduct_number">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="eauthorized_vendor" class="col-form-label">Authorized Vendor:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="authorized_vendor" id="eauthorized_vendor">
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="evendor_pn" class="col-form-label">Vendor P/N:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control form-control' type="text" name="vendor_pn" id="evendor_pn">                 
                            </div>
                        </div>
                    </div>                               
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="edit_comp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>