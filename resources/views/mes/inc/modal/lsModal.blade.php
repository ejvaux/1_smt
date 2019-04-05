{{-- ADD Component --}}
<div class="modal hide fade in" role="dialog" id="add_line_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Line - Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_line_form"  method="post" action='{{url('lines')}}'>
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="acode" class="col-form-label-sm">LINE:</label>                  
                            </div>
                            <div class="col-7">
                                <input id='acode' type="text" class='form-control form-control-sm' name="code">                   
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="amachine_id" class="col-form-label-sm">MACHINE:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="amachine_id" class="form-control form-control-sm" name="machine_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($machines as $machine)
                                        <option value="{{$machine->id}}">{{$machine->code}}</option>
                                    @endforeach        
                                </select>        
                            </div>
                        </div>
                    </div>                                
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="add_comp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT Component --}}
<div class="modal hide fade in" role="dialog" id="edit_line_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Line - Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_line_form"  method="post" action=''>
                @method('PUT')
                <input type="hidden" id="user_id" name="user_id">
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="code" class="col-form-label-sm">LINE:</label>                  
                            </div>
                            <div class="col-7">
                                <input id='code' type="text" class='form-control form-control-sm' name="code">                   
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="machine_id" class="col-form-label-sm">MACHINE:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="machine_id" class="form-control form-control-sm" name="machine_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($machines as $machine)
                                        <option value="{{$machine->id}}">{{$machine->code}}</option>
                                    @endforeach        
                                </select>        
                            </div>
                        </div>
                    </div>                                
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="edit_comp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>