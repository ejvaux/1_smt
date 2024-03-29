@extends('layouts.app2')

@section('content')
<div class="container-fluid">
<div class="white_bkg">
   
    <div class="row">
        {{-- LEFT PANEL --}}
        <div class="col-lg-8">              
            <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-cog"></i>&nbspSCANNING CONFIGURATION</div>
                    <div class="card-body">
                    
                        <div class="row no-gutters"> 
                            <div class="col-lg-2 bold-text vertical-center text-center">INPUT TYPE: &nbsp</div>
                            <div class="col-lg-4  vertical-center text-center">
                                    <input id="input_type" type="checkbox" checked data-toggle="toggle" data-on="SCAN AS IN" data-off="SCAN AS OUT" data-onstyle="primary" data-offstyle="secondary" data-width="100%" data-height="15" onchange="SetInputType()">
                            </div>

                            <div class="col-lg-2 bold-text vertical-center text-center">PROCESS: &nbsp</div>
                            <div class="col-lg-4  vertical-center">
                                <select class="select2" id="process_sel" onchange="SetProcess();">
                                            <option value="">SELECT PROCESS</option>
                                        @foreach ($processlist as $processlist_item)
                                            <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                                        @endforeach
                                </select>
                            </div>
                        
                            <div class="w-100 d-none d-md-block"></div>
                        
                            <div class="col-lg-2 bold-text vertical-center text-center">PROD LINE: &nbsp</div>
                            <div class="col-lg-4 vertical-center">
                                    <select class="select2" id="prodline_sel" onchange="SetProdLine();">
                                            <option value="">SELECT LINE</option>
                                        @foreach ($pline as $pline_item)
                                            <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                        @endforeach 
                                    </select>
                            </div>
                            <div class="col-lg-2 bold-text vertical-center text-center">MACHINE: &nbsp</div>
                            <div class="col-lg-4  vertical-center">
                                    <select class="select2" id="machine_sel" onchange="SetMachine();">
                                        <option value="">SELECT MACHINE</option>
                                    </select>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-1 text-right vertical-center bold-text">DATE: </div>
                            <div class="col-lg-3">
                            <input type="date" id="SAP_date" class="form-control">
                            </div>
                            <div class="col-lg-5">
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                              {{-- <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span> --}}
                                              <select class="input-group-text" id="search_field">
                                                <option value="ItemCode">PARTCODE</option>
                                                <option value="ProdName">PARTNAME</option>
                                                <option value="DocNum">WORKORDER</option>
                                              </select>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Type anything to search.." id="SAP_searchbox">
                                    </div>
                            </div>
                            <div class="col-lg-3 bold-text">
                                <button id="loadtbl" class="btn btn-sm btn-primary" onclick="LoadSAPDataTable()" style="height:35px"><i class="fas fa-sync-alt"></i>&nbspLOAD</button>
                                <button class="btn btn-sm btn-danger" onclick="ClearJOSearch()" style="height:35px"><i class="fas fa-ban"></i>&nbspCLEAR</button>
                            </div>
                        </div>
                        <br>
                       
                        <div class="table-responsive-xl" style="overflow:auto;height: 400px;">
                           
                                <table class="table table-striped table-bordered table-hover table-sm" id="JOdatatable">
                                        <thead class="thead-dark">
                                                <tr class="text-center">
                                                  <th scope="col">CTRLS</th>
                                                  <th scope="col">WORK ORDER #</th>
                                                  <th scope="col">PART CODE</th>
                                                  <th scope="col">PART NAME</th>
                                                  <th scope="col">PLAN QTY</th>
                                                  <th scope="col">RESULT</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                    <tr style='height:100px'>
                                                        <td colspan='9' class='text-center' style='font-size:1.5em;height:355px'>
                                                            No data to display.
                                                        </td>
                                                    </tr>
                                              </tbody>
                                </table>
                        </div>

                    </div>
            </div>
                    
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-lg-4">
                <div class="card shadow-sm bg-white rounded">
                        <div class="card-header bold-text"><i class="fas fa-barcode"></i>&nbspSERIAL NUMBER SCANNING AREA</div>
                        <div class="card-body">
                            <b><i class="fas fa-wrench"></i>&nbspERROR CONFIG</b>
                            <div class="row">
                                <div class="col-lg-3">
                                        <input id="R_panel_input_type" type="checkbox" checked data-toggle="toggle" data-on="GOOD" data-off="NG" data-onstyle="success" data-offstyle="danger" data-width="70" data-height="25" data-size="sm" onchange="ChangeToggle()">
                                </div>
                                <div class="col-lg-9">
                                        <select class="select2" id="ecode_sel" disabled>
                                                <option value="">SELECT ERROR CODE</option>
                                            @foreach ($ecode as $ecode_item)
                                                <option value="{{$ecode_item->id}}">{{$ecode_item->error_code}}-{{$ecode_item->error_desc}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>

                            <hr>

                            <b><i class="fas fa-qrcode"></i>&nbspSERIAL SCANNING</b>
                            <input type="text" name="input_scan" id="input_serial" placeholder="Input Serial Number here..." 
                            class="form-control" style="height: 30px" onkeypress="return enterEvent(event)">
                                                        
                            <hr>
                            <b><i class="fas fa-info-circle"></i>&nbspSELECTED INFO:</b>
                            <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-3 font-small bold-text vertical-center">WORK ORDER #:</div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" readonly id="work_num">
                                </div>
                                <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-3 font-small bold-text vertical-center">PART CODE:</div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" readonly id="part_code">
                                </div>
                                <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-3 font-small bold-text vertical-center">PART NAME:</div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" readonly id="part_name">
                                </div>
                                <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-3 font-small bold-text vertical-center">PLAN QTY:</div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" readonly id="plan_qty">
                                    <input type="text" class="form-control" readonly hidden id="jo_id">
                                </div>
                            </div>

                            <hr>
                            
                            <b>NOTE:</b>
                                <ul>
                                    <li>Make sure to configure the scanning options before scanning a serial number.</li>
                                    <li>If Item is NG-NOT GOOD, Please toggle the button below and select the corresponding error code for reference.</li>
                                    <li>Please select a work order first before scanning an item</li>
                                </ul>
                        </div>
                </div>

        </div>
    </div>

    <br>
    {{-- BOTTOM PANEL --}}
    <div class="card shadow-sm bg-white rounded">
        <div class="card-header bold-text"><i class="fas fa-cog"></i>&nbspSCAN DATA TABLE</div>
        <div class="card-body">

        
                            <div class="row">
                                {{-- LEFT --}}
                                <div class="col-lg-4">
                                        <div class="card shadow-sm bg-white rounded">
                                        <div class="card-body">
                                                <form  action = "{{ route('ScanRecordexport') }}" method = "POST" id="scanIO_export_form" name="scanIO_export_form1">
                                                @csrf
                                                    <b>SEARCH PARAMETERS:</b>
                                                    <hr>
                                                    <div class="row no-gutters">
                                                        <div class="col-lg-12">
                                                                <b> INPUT TYPE:</b>&nbsp
                                                                <input id="bot_panel_input_type" type="checkbox" checked data-toggle="toggle" data-on="IN" data-off="OUT" data-onstyle="primary" data-offstyle="secondary" data-width="70" data-height="25" data-size="sm">
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">LINE:</div>
                                                        <div class="col-lg-9">
                                                                <select class="select2" id="bot_panel_prodline_sel" name="pline_sel" onchange="LoadDataTable()">
                                                                        @foreach ($pline as $pline_item)
                                                                            <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                                                        @endforeach
                                                                </select>
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">PROCESS:</div>
                                                        <div class="col-lg-9">
                                                                <select class="select2" id="bot_panel_process_sel" name="process_sel" onchange="LoadDataTable()">
                                                            
                                                                        @foreach ($processlist as $processlist_item)
                                                                            <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                                                                        @endforeach
                                                                </select>
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">MACHINE:</div>
                                                        <div class="col-lg-9">
                                                                <select class="select2" id="bot_panel_machine_sel" name="machine_sel" onchange="LoadDataTable()">
                                                                        <option value="">SELECT MACHINE</option>
                                                                </select>
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">SERIAL #:</div>
                                                        <div class="col-lg-9">
                                                                <input type="text" name="bot_panel_input_scan" id="bot_panel_input_serial" placeholder="Input Serial Number here..." 
                                                                class="form-control" style="height: 30px">
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">DATE:</div>
                                                        <div class="col-lg-9">
                                                                <input type="date" id="scan_IO_date" class="form-control" name="io_date" style="height: 30px">
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">STATUS:</div>
                                                        <div class="col-lg-9">
                                                                <select class="select2" id="export_param">
                                                                        <option value="0">NOT YET EXPORTED</option>
                                                                        <option value="1">ALREADY EXPORTED</option>
                                                                </select>
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-12 text-center">
                                                                <button style="margin-top: 10px; width: 100%" type="button" name="load_data_button" class="btn btn-sm btn-primary bold-text" onclick="LoadDataTable()" data-toggle="tooltip" title="LOAD DATA"><i class="fas fa-sync-alt"></i>&nbspLOAD DATA</button>
                                                                <br>
                                                                <button style="margin-top: 10px;width: 100%" type="button" name="load_data_button" class="btn btn-sm btn-danger bold-text" onclick="ScanRecordClearData()" data-toggle="tooltip" title="RESET SEARCH"><i class="fas fa-times"></i>&nbspCLEAR SEARCH</button>
                                                                <br>
                                                                <button style="margin-top: 10px;width: 100%" class="btn btn-sm btn-success bold-text" type="submit" data-toggle="tooltip" title="EXPORT DATA"><i class="fas fa-file-excel"></i>&nbspEXPORT DATA</button>
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
                                        </div>
                                </div>
                                {{-- RIGHT --}}
                                <div class="col-lg-8">
                                        <div class="table-responsive-xl">
                                                <table class="table table-striped table-bordered table-hover table-sm" id="datatable">
                                                        <thead class="thead-dark">
                                                                <tr class="text-center">
                                                                    <th scope="col">CTRLS</th>
                                                                    <th scope="col">PROD LINE</th>
                                                                    <th scope="col">USER</th>
                                                                    <th scope="col">SERIAL NUMBER</th>
                                                                    <th scope="col">RESULT</th>
                                                                    <th scope="col">ERROR CODE</th>
                                                                    <th scope="col">PROCESS</th>
                                                                    <th scope="col">MACHINE</th>
                                                                    <th scope="col">TIME</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr style='height:100px'>
                                                                        <td colspan='9' class='text-center' style='font-size:1.5em'>
                                                                            No data to display. Try to configure the scanning options then load data again.
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                </table>
                                        </div>
                                </div>

                            </div>

               

        </div>
    </div>


</div>
</div>

{{-- @include('modal.scanerror') --}}
@endsection
{{-- 
 --}}