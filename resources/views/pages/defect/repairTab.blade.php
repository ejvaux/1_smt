<div class="form-group row">
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
<div class="form-group row">
    <div class="col-4">
        <label for="aremarks" class="col-form-label-sm">REMARKS:</label>                  
    </div>
    <div class="col-8">
        <textarea id='aremarks' class='form-control' id="" name="remarks" cols="30" rows="4" required></textarea>
    </div>
</div>
<div class="row text-right">
    <div class="col-md">
        <button type="button" class="btn btn-primary" name="submit" id="repair_defect_submit"><i class="far fa-save"></i> Repair</button>
        <button type="button" class="btn btn-success" id="refresh-table-button"><i class="fas fa-sync-alt"></i> Refresh Table</button>
    </div>
</div>