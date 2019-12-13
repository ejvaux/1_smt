{{-- <div class="row mb-1">
    <div class="col-md-5">
        <div class="row">
            <div class="col">
                <label for='rep_scan_emp' class="col-form-label bold-text">EMPLOYEE:</label>
            </div>
            <div class="col text-right">
                <button class='btn btn-primary mt-1 py-0' id='replenish-refresh-btn'><i class="fas fa-sync-alt"></i></button>
            </div>
        </div>        
    </div>
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" id="rep_scan_emp" placeholder="SCAN EMPLOYEE BARCODE" class="form-control">
            <input type="hidden" id="employee_id">
            <button id='emp-reset-btn' type="button" class="btn btn-danger bold-text"><i class="fas fa-times"></i></button>
        </div>                                
    </div>
</div> --}}
<div class="row mb-1">
    <div class="col-md">
        <div class="row">
            <div class="col">
                <label for='rep_scan_emp' class="col-form-label bold-text">EMPLOYEE:</label>
            </div>
            <div class="col text-right">
                <button class='btn btn-primary mt-1 py-0' id='replenish-refresh-btn'><i class="fas fa-sync-alt"></i> LOAD</button>
            </div>
        </div>        
    </div>
</div>
<div class="row mb-1">
    <div class="col-md">
        <div class="input-group">
            <input type="text" id="rep_scan_emp" placeholder="SCAN EMPLOYEE BARCODE" class="form-control" autocomplete="off">
            <input type="hidden" id="employee_id">
            <button id='emp-reset-btn' type="button" class="btn btn-danger bold-text"><i class="fas fa-times"></i></button>
        </div>                                
    </div>
</div>
<div class="row mb-2">
    <div class="col-3">
        <label for='scan_machine' class="col-form-label bold-text">LINE:</label>
    </div>
    <div class="col-9 pt-1">
        <select class="form-control select2" name="line_id" id="line_id_rep">
            @foreach ($lines2 as $line)
                <option value="{{$line->id}}">{{$line->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card container">
            <div class="row">
                <div class="col-md">
                    <div id="replenish-div">
                        @include('includes.table.replenishTable')
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>