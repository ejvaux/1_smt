@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- LEFT PANEL --}}
            <div class="col-lg-6">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-barcode"></i> &nbspSCAN AREA</div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 vertical-center text-center bold-text">EMPLOYEE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_employee">
                                                        <option value="">SELECT EMPLOYEE</option>
                                                        <option value="2018000460-GERNALE">2018000460-GERNALE</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MACHINE CODE:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_machine" placeholder="INPUT MACHINE CODE" class="form-control" onkeypress="return event_mach(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MODEL:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_model">
                                                        <option value="">SELECT MODEL</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">TABLE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_table">
                                                        <option value="">SELECT TABLE</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">CONFIG POSITION:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="config_pos">
                                                    <option value="1">L-LEFT</option>
                                                    <option value="2">R-RIGHT</option>
                                                    <option value="0">NONE</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">FEEDER SLOT#:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_feeder" placeholder="INPUT FEEDER SLOT CODE" class="form-control"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">FOR REPLENISHMENT? &nbsp</label>
                                                <input id="replenish" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO" data-offstyle="danger" onchange="IsReplenish()" checked>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will load the same reel component/partname. 
                                                                This will require you to scan both reel barcodes.</span>
                                        </div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">&nbsp&nbsp&nbsp&nbspUSE ALTERNATIVES? &nbsp</label>
                                                <input id="alt_items" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="mr-1" data-on="YES" data-offstyle="danger" data-off="NO">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will use alternative item components.</span>
                                        </div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">LAST PRIMA PN:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_oldPN" placeholder="INPUT LAST PRIMA PN" class="form-control"  onkeypress="return event_lastPN(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">PRIMA PN TO LOAD:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_newPN" placeholder="INPUT PRIMA PN TO LOAD" class="form-control"></div>
                                        <div class="col-lg-2"></div>
                                    </div>
                            </div>
                    </div>
            </div>
            {{-- RIGHT PANEL --}}
            <div class="col-lg-6">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-info-circle"></i> &nbspSCAN DETAILS</div>
                            <div class="card-body">
                               
                            </div>
                    </div>
            </div>
        </div>
            



    </div>
</div>
@include('modal.employeepin')
@endsection
