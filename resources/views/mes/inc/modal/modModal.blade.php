{{-- ADD Model --}}
<div class="modal hide fade in" role="dialog" id="add_model_mod" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_model_form"  method="post" action='{{url('models')}}'>
                <input type="hidden" id="user_id" name="updated_by">
                <div class="modal-body" style="">
                    <!-- ____________ FORM __________________ -->
            
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">
                                    <label for="code" class="col-form-label-sm">MODEL NAME:</label>                  
                                </div>
                                <div class="col-7">
                                    <input class='form-control form-control' type="text" name="code" id="code">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">
                                    <label for="program_name" class="col-form-label-sm">PROGRAM NAME:</label>                  
                                </div>
                                <div class="col-7">
                                    <input class='form-control form-control' type="text" name="program_name" id="program_name">
                                </div>
                            </div>
                        </div>                                
                    </div>                    
                    <!-- ____________ FORM END __________________ -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="submit" id="add_model_submit"><i class="far fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
{{-- Line Config --}}
<div class="modal hide fade in" role="dialog" id="line_config_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Line Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="line_config_form"  method="post" action=''>
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
                <div id='lctable-div'>
                    {{-- @include('mes.inc.table.lcTable') --}}
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="submit" id="line_config_submit"><i class="far fa-save"></i> SAVE</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>