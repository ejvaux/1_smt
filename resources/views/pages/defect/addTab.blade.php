<form id="add_defect_form">
    @csrf
    <input id='division_id' type="hidden" name="division_id1">
    <input id='line_id' type="hidden" name="line_id">
<div class="row form-group">
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="serial_number" class="col-form-label-sm">S/N:</label>                  
            </div>
            <div class="col-8">
                <input id='scan_sn' class='form-control' type="text" placeholder="Scan Serial Number here . . ." autocomplete='off'>                 
                <div class="input-group" style='display:none' id='scan_lbl_div'>
                    <input class='form-control' type="text" id='scan_lbl' readonly>
                    <button type="button" class='' id="reset_sn"><i class="fas fa-redo"></i></button>
                </div>
                <input type="hidden" id='scan_serial_number' name="serial_number">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="process_id" class="col-form-label-sm">PROCESS:</label>                  
            </div>
            <div class="col-8">
                <select id="process_id" class="form-control select2" name="process_id" placeholder="">
                    <option value="">- Select DEPARTMENT first -</option>
                </select>                  
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="scan_employee" class="col-form-label-sm">EMPLOYEE:</label>                  
            </div>
            <div class="col-8">
                <input class='form-control' type="text" id='scan_employee' placeholder="Scan employee barcode" autocomplete="off">                
                <div class="input-group" style='display:none' id='scan_name_div'>
                    <input class='form-control' type="text" id='scan_name' readonly>
                    <button type="button" class='' id="reset_emp"><i class="fas fa-redo"></i></button>
                </div>
                <input type="hidden" id='employee_id' name="employee_id">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="defect_type_id" class="col-form-label-sm">DEFECT TYPE:</label>                  
            </div>
            <div class="col-8">
                <select id="defect_type_id" class="form-control select2" name="defect_type_id" placeholder="" required>
                        {{-- <option value="">- Please Select -</option> --}}
                        @foreach ($defect_types as $defect_type)
                        <option value="{{$defect_type->id}}">{{$defect_type->code}} - {{$defect_type->name}}</option>
                        @endforeach
                </select>
            </div>
        </div>
    </div>        
</div>
<div class="row form-group">
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="department_id" class="col-form-label-sm">DEPARTMENT:</label>                  
            </div>
            <div class="col-8">
                <select id="department_id" class="form-control" name="division_id" placeholder="">
                    <option value="">- Please Select -</option>
                    @foreach ($divisions as $div)
                        <option value="{{$div->DIVISION_ID}}">{{$div->DIVISION_NAME}}</option>
                    @endforeach
                </select>                  
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="defect_id" class="col-form-label-sm">DEFECT:</label>                  
            </div>
            <div class="col-8">
                <select id="defect_id" class="form-control select2" name="defect_id" placeholder="" required>
                        <option value="">- Select DEPARTMENT first -</option>
                </select>                  
            </div>
        </div>
    </div>              
</div>
<div class="row">
    <div class="col-md-6 text-right">
        <button type="button" class="btn btn-primary" name="submit" id="add_defect_submit"><i class="far fa-save"></i> Add Defect</button>        
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-4">
                <label for="locations" class="col-form-label-sm">LOCATION:</label>                  
            </div>
            <div class="col-8">
                <select id="locations" class="form-control select2" name="d_locations[]" placeholder='Select locations' multiple='multiple' required>
                        {{-- <option value="" selected>- Please Select -</option> --}}
                    @foreach ($locations as $location)
                        <option value="{{$location->id}}">{{$location->name}} - {{$location->program_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
</form>