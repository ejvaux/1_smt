{{-- Add Defect --}}
<div class="modal hide fade in" role="dialog" id="add_defect_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Defect Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_defect_form" class='form_to_submit'  method="POST" action='{{url('defectmats_temp')}}'>
                @csrf
            <div class="modal-body" style="">

                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="serial_number" class="col-form-label-sm">S/N:</label>                  
                            </div>
                            <div class="col-8">
                                <input id='serial_number' name='serial_number' class='form-control' type="text" required>                 
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="scan_employee" class="col-form-label-sm">EMPLOYEE:</label>                  
                            </div>
                            <div class="col-8">
                                <input class='form-control' type="text" id='scan_employee' placeholder="Scan employee barcode">                
                                <div class="input-group" style='display:none' id='scan_name_div'>
                                    <input class='form-control' type="text" id='scan_name' readonly>
                                    <button type="button" class='' id="reset_emp"><i class="fas fa-redo"></i></button>
                                </div>
                                <input type="hidden" id='employee_id' name="employee_id">
                            </div>
                        </div>
                    </div>                                              
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="division_id" class="col-form-label-sm">DIVISION:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="division_id" class="form-control " name="division_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                        @endforeach
                                </select>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="process_id" class="col-form-label-sm">PROCESS:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="process_id" class="form-control" name="process_id" placeholder="" disabled>
                                        <option value="">- Select division first -</option>
                                        {{-- @foreach ($processes as $process)
                                        <option value="{{$process->id}}">{{$process->division->DIVISION_NAME}} - {{$process->name}}</option>
                                        @endforeach --}}
                                </select>                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">                    
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="line_id" class="col-form-label-sm">LINE:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="line_id" class="form-control" name="line_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                        @foreach ($linenames as $linename)
                                        <option value="{{$linename->id}}">{{$linename->name}}</option>
                                        @endforeach
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="defect_id" class="col-form-label-sm">DEFECT:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="defect_id" class="form-control" name="defect_id" placeholder="" required disabled>
                                        <option value="">- Select division first -</option>
                                        {{-- @foreach ($defects as $defect)
                                        <option value="{{$defect->DEFECT_ID}}" data-div_id='{{$defect->division_id}}'>{{$defect->DEFECT_GROUP}} - {{$defect->DEFECT_CODE}} - {{$defect->DEFECT_NAME}}</option>
                                        @endforeach --}}
                                </select>                  
                            </div>
                        </div>
                    </div>                                                   
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="defect_datetime" class="col-form-label-sm">DEFECTED AT:</label>                  
                            </div>
                            <div class="col-8">
                                <input class='form-control' type="datetime-local" name="defected_at" id="defect_datetime" {{-- value="{{date('Y-m-d')}}T00:00:00" --}} required>                               
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="aorder_id" class="col-form-label-sm">REMARKS:</label>                  
                            </div>
                            <div class="col-8">
                                <textarea class='form-control' name="" id="" cols="30" rows="4"></textarea>                
                            </div>
                        </div>
                    </div> --}}                    
                    {{-- <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="shift" class="col-form-label-sm">SHIFT:</label>                  
                            </div>
                            <div class="col-8">
                                <input id='shift' name='shift' class="form-control" type="text" readonly required>                                
                            </div>
                        </div>
                    </div> --}}
                    <input type="hidden" id='shift' name='shift'>                                                  
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="add_defect_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Repair Defect --}}
<div class="modal hide fade in" role="dialog" id="repair_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Repair Defect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="repair_defectmat_form" class='form_to_submit' method="post" action=''>
                @csrf
            <div class="modal-body" style="">

                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-4">
                        <label for="ascan_employee" class="col-form-label-sm">EMPLOYEE:</label>                  
                    </div>
                    <div class="col-8">
                        <input class='form-control' type="text" id='ascan_employee' placeholder="Scan employee barcode">                
                        <div class="input-group" style='display:none' id='ascan_name_div'>
                            <input class='form-control' type="text" id='ascan_name' readonly>
                            <button type="button" class='' id="areset_emp"><i class="fas fa-redo"></i></button>
                        </div>
                        <input type="hidden" id='aemployee_id' name="repaired_by">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label for="aremarks" class="col-form-label-sm">REMARKS:</label>                  
                    </div>
                    <div class="col-8">
                        <textarea id='aremarks' class='form-control' id="" name="remarks" cols="30" rows="4" required></textarea>
                    </div>
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="add_repair_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Defect --}}
<div class="modal hide fade in" role="dialog" id="edit_defect_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Defect Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_defect_form" class='form_to_submit'  method="POST" action=''>
                @csrf
                @method('PUT')
            <div class="modal-body" style="">

                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="serial_number" class="col-form-label-sm">S/N:</label>                  
                            </div>
                            <div class="col-8">
                                <input id='aserial_number' name='serial_number' class='form-control' type="text" readonly>                 
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="escan_employee" class="col-form-label-sm">EMPLOYEE:</label>                  
                            </div>
                            <div class="col-8">
                                <input class='form-control' type="text" id='escan_employee' placeholder="Scan employee barcode">                
                                <div class="input-group" style='display:none' id='escan_name_div'>
                                    <input class='form-control' type="text" id='escan_name' readonly>
                                    <button type="button" class='' id="ereset_emp"><i class="fas fa-redo"></i></button>
                                </div>
                                <input type="hidden" id='eemployee_id' name="employee_id">
                            </div>
                        </div>
                    </div>                                              
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="division_id" class="col-form-label-sm">DIVISION:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="adivision_id" class="form-control " name="division_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                        @endforeach
                                </select>                               
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="aprocess_id" class="col-form-label-sm">PROCESS:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="aprocess_id" class="form-control" name="process_id" placeholder="" disabled>
                                        <option value="">- Select division first -</option>
                                        {{-- @foreach ($processes as $process)
                                        <option value="{{$process->id}}">{{$process->division->DIVISION_NAME}} - {{$process->name}}</option>
                                        @endforeach --}}
                                </select>                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">                    
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="line_id" class="col-form-label-sm">LINE:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="aline_id" class="form-control" name="line_id" placeholder="" required>
                                        <option value="">- Please select -</option>
                                        @foreach ($linenames as $linename)
                                        <option value="{{$linename->id}}">{{$linename->name}}</option>
                                        @endforeach
                                </select>                  
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="defect_id" class="col-form-label-sm">DEFECT:</label>                  
                            </div>
                            <div class="col-8">
                                <select id="adefect_id" class="form-control" name="defect_id" placeholder="" required disabled>
                                        <option value="">- Select division first -</option>
                                        {{-- @foreach ($defects as $defect)
                                        <option value="{{$defect->DEFECT_ID}}" data-div_id='{{$defect->division_id}}'>{{$defect->DEFECT_GROUP}} - {{$defect->DEFECT_CODE}} - {{$defect->DEFECT_NAME}}</option>
                                        @endforeach --}}
                                </select>                  
                            </div>
                        </div>
                    </div>                                                   
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <label for="defect_datetime" class="col-form-label-sm">DEFECTED AT:</label>                  
                            </div>
                            <div class="col-8">
                                <input class='form-control' type="datetime-local" name="defected_at" id="adefect_datetime" value="{{date('Y-m-d')}}T00:00:00" required>                               
                            </div>
                        </div>
                    </div>                    
                    <input type="hidden" id='ashift' name='shift'>                                                  
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="edit_defect_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- Repair Details --}}
<div class="modal hide fade in" role="dialog" id="repair_details_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Repair Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="repair_defectmat_form" class='form_to_submit' method="post" action=''>
                @csrf
            <div class="modal-body" style="">

                <!-- ____________ FORM __________________ -->        
                <div class="form-group row">
                    <div class="col-md">
                        <label for="drepair_by" class="col-form-label-sm">REPAIRED BY:</label>
                        <input id="drepair_by" type="text" class='form-control' name="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md">
                        <label for="dremarks" class="col-form-label-sm">REMARKS:</label>
                        <textarea id='dremarks' class='form-control' name="remarks" cols="30" rows="4" readonly></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md">
                        <label for="drepaired_at" class="col-form-label-sm">REPAIRED AT:</label>
                        <input id='drepaired_at' class='form-control' name="remarks" readonly>
                    </div>
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                {{-- <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="add_repair_submit"><i class="far fa-save"></i> Save</button> --}}
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>