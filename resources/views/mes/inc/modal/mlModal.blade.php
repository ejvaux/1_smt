{{-- ADD Machine --}}
<div class="modal hide fade in" role="dialog" id="add_mach_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_mach_form"  method="post" action='{{url('machines')}}'>
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-md">
                        <div class="row mb-2">
                            <div class="col-md">
                                <span class='text-danger font-weight-bold'><span style='font-size:1rem'>NOTE</span>: <u>Machine codes</u> are generated by the system.</span>                  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <label for="machine_type_id" class="col-form-label">Machine Type:</label>                  
                            </div>
                            <div class="col-7">
                                <select class="form-control" id="machine_type_id" name='machine_type_id' required>
                                    <option value="">-Select Machine Type-</option> 
                                    @foreach ($machinetypes as $machinetype)
                                    <option value="{{$machinetype->id}}">{{$machinetype->name}}</option>
                                    @endforeach   
                                </select>                   
                            </div>
                        </div>
                    </div>                       
                </div>                           
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="add_mach_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>