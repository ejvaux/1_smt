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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label id='scanstatuslabel' for="" class='text-danger bold-text'>Set: [Configuration] [Employee] [Work Order]</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md">
                                <input class="form-control" type="text" name="scan_serial" id="scan_serial" placeholder="Scan Serial Number here..." style='border-width:medium' disabled>
                            </div>
                        </div>
                        
                    </div>
                </div>                
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <ul class="nav nav-tabs" role="tablist">                    
                    <li class="nav-item">
                        <a class="nav-link bold-text active" href="#woinfo" role="tab" data-toggle="tab">W.O.</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link bold-text" href="#stotal" role="tab" data-toggle="tab">TOTAL</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link bold-text" href="#lotnum" role="tab" data-toggle="tab">LOT</a>
                    </li> --}}
                </ul>                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="woinfo">
                        @include('includes.scan.woitab')
                    </div>
                    <div class="tab-pane container" id="stotal">
                        @include('includes.scan.sttab')
                    </div> 
                    {{-- <div class="tab-pane container" id="lotnum">
                        @include('includes.scan.lntab')
                    </div> --}}                                      
                </div>
            </div>
        </div>
    </div>
</div>