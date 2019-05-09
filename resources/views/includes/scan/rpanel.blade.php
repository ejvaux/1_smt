<div class="card shadow-sm bg-white rounded">
    <div class="card-header bold-text">
        <i class="fas fa-barcode"></i> SERIAL NUMBER SCANNING AREA
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md">
                <div class="card" style='border-color:black'>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <label for="" class='bold-text'><i class="fas fa-qrcode"></i> SERIAL SCANNING:</label>
                                <label id='scanstatuslabel' for="" class='text-danger bold-text'>Set Work Order first.</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <input class="form-control" type="text" name="scan_serial" id="scan_serial" placeholder="Scan Serial Number here..." style='border-width:medium' disabled>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>        
        {{-- Work Order --}}
        <input id='jo_id' type="hidden" name="jo_id">
        <div class="row">
            <div class="col-md">
                <label for="" class='bold-text'><i class="fas fa-info-circle"></i> WORK ORDER INFO:</label>
            </div>
        </div>
        <div class="row mb-1"> 
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">WORK ORDER #:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">PLAN QTY:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-1"> 
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">PART CODE:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>                            
        </div>
        <div class="row form-group">
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">PART NAME:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>
        </div>
        {{-- Scan Total --}}
        <div class="row">
            <div class="col-md">
                <label for="" class='bold-text'><i class="fas fa-stream"></i> SCAN TOTAL:</label>    
            </div>    
        </div>
        <div class="row mb-1">
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">INPUT:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">                            
            <div class="col-md">
                <div class="row">
                    <div class="col-5">
                        <label for="" class="col-form-label bold-text">OUTPUT:</label>                  
                    </div>
                    <div class="col-7">
                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                    </div>
                </div>
            </div>                           
        </div>
    </div>
</div>