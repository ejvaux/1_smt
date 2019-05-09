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
                                                                        {{-- @foreach ($pline as $pline_item)
                                                                            <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                                                        @endforeach --}}
                                                                </select>
                                                        </div>
                                                        <div class="w-100 d-none d-md-block"  style="margin-top:2%"></div>
                                                        <div class="col-lg-3 vertical-center bold-text">PROCESS:</div>
                                                        <div class="col-lg-9">
                                                                <select class="select2" id="bot_panel_process_sel" name="process_sel" onchange="LoadDataTable()">
                                                            
                                                                        {{-- @foreach ($processlist as $processlist_item)
                                                                            <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                                                                        @endforeach --}}
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