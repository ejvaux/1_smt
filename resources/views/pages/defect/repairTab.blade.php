<form id="repair_defectmat_form" class='form_to_submit' method="post" action=''>
    @csrf
    <input type="hidden" name="mode" value="1">
    <div class="row form-group">
        <div class="col-md-6">
            <div class="row form-group">
                <div class="col-4">
                    <label for="aserial_number" class="col-form-label-sm">S/N:</label>                  
                </div>
                <div class="col-8">
                    <input id='ascan_sn' class='form-control' type="text" placeholder="Scan Serial Number here . . ." autocomplete='off'>                 
                    <div class="input-group" style='display:none' id='ascan_lbl_div'>
                        <input class='form-control' type="text" id='ascan_lbl' readonly>
                        <button type="button" class='' id="areset_sn"><i class="fas fa-redo"></i></button>
                    </div>
                    <input type="hidden" id='ascan_serial_number' name="serial_number">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-4">
                    <label for="ascan_employee" class="col-form-label-sm">EMPLOYEE:</label>                  
                </div>
                <div class="col-8">
                    <input class='form-control' type="text" id='ascan_employee' placeholder="Scan employee barcode" autocomplete="off">                
                    <div class="input-group" style='display:none' id='ascan_name_div'>
                        <input class='form-control' type="text" id='ascan_name' readonly>
                        <button type="button" class='' id="areset_emp"><i class="fas fa-redo"></i></button>
                    </div>
                    <input type="hidden" id='aemployee_id' name="repaired_by">
                </div>
            </div>
            <div class="row">
                <div class="col-md text-right">
                    <button type="button" class="btn btn-primary" name="submit" id="repair_defect_submit"><i class="fas fa-tools"></i> Repair Defect</button>        
                </div>        
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-4">
                    <label for="aremarks" class="col-form-label-sm">REMARKS:</label>                  
                </div>
                <div class="col-8">
                    {{-- <textarea id='aremarks' class='form-control' id="" name="remarks" cols="30" rows="4" required></textarea> --}}
                    <select id="aremarks" class="form-control select2" name="remarks" placeholder="" required>
                        @foreach ($defects as $defect)
                            <option value="{{$defect->DEFECT_NAME}}">{{$defect->DEFECT_NAME}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>    
</form>