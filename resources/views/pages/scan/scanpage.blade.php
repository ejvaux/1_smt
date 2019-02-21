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
                                    <input id="input_type" type="checkbox" checked data-toggle="toggle" data-on="SCAN AS IN" data-off="SCAN AS OUT" data-onstyle="success" data-offstyle="danger" data-width="100%" data-height="15" onchange="SetInputType()">
                            </div>

                            <div class="col-lg-2 bold-text vertical-center text-center">PROCESS: &nbsp</div>
                            <div class="col-lg-4  vertical-center">
                                <select class="select2" id="process_sel" onchange="SetProcess();LoadDataTable()">
                                            <option value="">SELECT PROCESS</option>
                                        @foreach ($processlist as $processlist_item)
                                            <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                                        @endforeach
                                </select>
                            </div>
                        
                            <div class="w-100 d-none d-md-block"></div>
                        
                            <div class="col-lg-2 bold-text vertical-center text-center">PROD LINE: &nbsp</div>
                            <div class="col-lg-4 vertical-center">
                                    <select class="select2" id="prodline_sel" onchange="SetProdLine();LoadDataTable()">
                                            <option value="">SELECT LINE</option>
                                        @foreach ($pline as $pline_item)
                                            <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-lg-2 bold-text vertical-center text-center">MACHINE: &nbsp</div>
                            <div class="col-lg-4  vertical-center">
                                    <select class="select2" id="machine_sel" onchange="SetMachine();LoadDataTable()">
                                        <option value="">SELECT MACHINE</option>
                                    </select>
                            </div>

                        </div>
                        <br>
                    </div>
            </div>
                    
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-lg-4">
                <div class="card shadow-sm bg-white rounded">
                        <div class="card-header bold-text"><i class="fas fa-barcode"></i>&nbspSERIAL NUMBER SCANNING AREA</div>
                        <div class="card-body">
                            <p><b>NOTE:</b>  Make sure to configure the scanning options before scanning a serial number.</p>
                            {{-- {{Request::getClientIp()}} --}}
                            <hr>
                            <input type="text" name="input_scan" id="input_serial" placeholder="Input Serial Number here..." 
                            class="form-control" style="height: 30px" onkeypress="return enterEvent(event)">
                        </div>
                </div>

        </div>
    </div>

    <br>
    {{-- BOTTOM PANEL --}}
    <div class="card shadow-sm bg-white rounded">
        <div class="card-header bold-text"><i class="fas fa-cog"></i>&nbspSCAN DATA TABLE</div>
        <div class="card-body">
            <b>SEARCH PARAMETERS:</b>
            <div class="row">
                <div class="col-lg-2 text-center"> 
                   <b> INPUT TYPE:</b>&nbsp
                    <input id="bot_panel_input_type" type="checkbox" checked data-toggle="toggle" data-on="IN" data-off="OUT" data-onstyle="success" data-offstyle="danger" data-width="70" data-height="25" data-size="sm">
                </div>
                <div class="col-lg-2">
                        <select class="select2" id="bot_panel_prodline_sel" name="sel2">
                                <option value="">SELECT LINE</option>
                            @foreach ($pline as $pline_item)
                                <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-lg-2">
                        <select class="select2" id="bot_panel_process_sel">
                                <option value="">SELECT PROCESS</option>
                            @foreach ($processlist as $processlist_item)
                                <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                        <select class="select2" id="bot_panel_machine_sel">
                                <option value="">SELECT MACHINE</option>
                        </select>
                </div>
                <div class="col-lg-2">
                        <input type="text" name="bot_panel_input_scan" id="bot_panel_input_serial" placeholder="Input Serial Number here..." 
                        class="form-control" style="height: 30px">
                </div>
                <div class="col-lg-2">
                    <button type="button" name="load_data_button" class="btn btn-sm btn-primary bold-text" onclick="LoadDataTable()"><i class="fas fa-sync-alt"></i>&nbspLOAD</button>
                    <button type="button" name="load_data_button" class="btn btn-sm btn-danger bold-text" onclick="LoadDataTable()"><i class="fas fa-ban"></i>&nbspCLEAR</button>
                </div>
            </div>
<br>
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

@include('modal.scanerror')
@endsection
{{-- 
 --}}