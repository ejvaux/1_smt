{{-- Edit Component --}}
<div class="modal hide fade in" role="dialog" id="edit_comp" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_comp_form"  method="POST" action=''>
            @method('PUT')
            <input type="hidden" id="model_id" name="model_id">
            <input type="hidden" id="machine_type_id" name="machine_type_id">
            <input type="hidden" id="table_id" name="table_id">
            <input type="hidden" id="feeder_id" name="feeder_id">
            <input type="hidden" id="user_id" name="user_id">            
            <div class="modal-body" style="">
                <h6>TABLE <span id='table_number'></span></h6>
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="mounter_id" class="col-form-label-sm">MOUNTER:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="mounter_id" class="form-control form-control-sm sel" name="mounter_id" placeholder="">
                                    @foreach ($mounters as $mounter)
                                        <option value="{{$mounter->id}}">{{$mounter->code}}</option>
                                    @endforeach        
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="pos_id" class="col-form-label-sm">POSITION:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="pos_id" class="form-control form-control-sm sel" name="pos_id" placeholder="">
                                    @foreach ($positions as $position)
                                        <option value="{{$position->id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="order_id" class="col-form-label-sm">PREFERENCE:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="order_id" class="form-control form-control-sm sel" name="order_id" placeholder="">
                                    @foreach ($prefs as $pref)
                                        <option value="{{$pref->id}}">{{$pref->name}}</option>
                                    @endforeach        
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="component_id" class="col-form-label-sm">COMPONENT:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="component_id" class="form-control form-control-sm sel" name="component_id" placeholder="">
                                    @foreach ($components as $component)
                                        <option value="{{$component->id}}" title='{{$component->authorized_vendor}}'>{{$component->product_number}}</option>
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

{{-- ADD Component --}}
<div class="modal hide fade in" role="dialog" id="add_comp" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Component</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_comp_form"  method="post" action='{{url('feeders')}}'>
            <input type="hidden" id="amodel_id" name="model_id">
            <input type="hidden" id="amachine_type_id" name="machine_type_id">
            <input type="hidden" id="atable_id" name="table_id">
            <input type="hidden" id="auser_id" name="user_id">
            <div class="modal-body" style="">
                <h6>TABLE <span id='atable_number'></span></h6>
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="amounter_id" class="col-form-label-sm">MOUNTER:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="amounter_id" class="form-control form-control-sm sel" name="mounter_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($mounters as $mounter)
                                        <option value="{{$mounter->id}}">{{$mounter->code}}</option>
                                    @endforeach        
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="apos_id" class="col-form-label-sm">POSITION:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="apos_id" class="form-control form-control-sm" name="pos_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($positions as $position)
                                        <option value="{{$position->id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="aorder_id" class="col-form-label-sm">PREFERENCE:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="aorder_id" class="form-control form-control-sm" name="order_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($prefs as $pref)
                                        <option value="{{$pref->id}}">{{$pref->name}}</option>
                                    @endforeach        
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="acomponent_id" class="col-form-label-sm">COMPONENT:</label>                  
                            </div>
                            <div class="col-7">
                                <select id="acomponent_id" class="form-control form-control-sm sel" name="component_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                    @foreach ($components as $component)
                                        <option value="{{$component->id}}" title='{{$component->authorized_vendor}}'>{{$component->product_number}}</option>
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