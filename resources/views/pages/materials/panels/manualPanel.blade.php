<div class="row mb-1">
    <div class="col-md-5">
        <label for='scan_emp' class="col-form-label bold-text">EMPLOYEE:</label>
    </div>
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" id="scan_emp" placeholder="SCAN EMPLOYEE BARCODE" class="form-control" onkeypress="return event_emp(event)">
            <input hidden  type="text" id="scan_employee" placeholder="SCAN EMPLOYEE BARCODE" class="form-control">
            <button id='res_emp' type="button" class="btn btn-danger bold-text"><i class="fas fa-times"></i></button>
        </div>                                
    </div>
</div>
<div class="row mb-1">
    <div class="col-md-5">
        <label for='scan_machine' class="col-form-label bold-text">MACHINE CODE:</label>
    </div>
    <div class="col-md-7">
        <input type="text" id="scan_machine" placeholder="INPUT MACHINE CODE" class="form-control" onkeypress="return event_mach(event)" autocomplete='off' required>
    </div>
</div>
<div class="row mb-1">
    <div class="col-md-5">
        <label for='scan_feed_slot' class="col-form-label bold-text">FEEDER SLOT#:</label>
    </div>
    <div class="col-md-7">
        <select class="select2" id="scan_feed_slot" required>
            <option value="" selected>SELECT FEEDER #</option>
            @foreach ($mounter as $mounter_item)
            <option value="{{$mounter_item->id}}">{{$mounter_item->code}}</option>
            @endforeach 
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <label for='scan_pos' class="col-form-label bold-text">POSITION:</label>
    </div>
    <div class="col-md-7">
        <select class="select2" id="scan_pos" required>
            <option value="" selected>SELECT POSITION</option>
            @foreach ($position as $position_item)
            <option value="{{$position_item->id}}">{{$position_item->name}}</option>
            @endforeach 
        </select>
    </div>
</div>
<div class="row mb-1">
    <div class="col-md-5">
        <label for='scan_newPN' class="col-form-label bold-text">PRIMA PN TO LOAD:</label>
    </div>
    <div class="col-md-7">
        <input type="text" id="scan_newPN" placeholder="INPUT PRIMA PN TO LOAD" class="form-control" onkeypress="return event_loadPN(event)" autocomplete='off'>
    </div>
</div>