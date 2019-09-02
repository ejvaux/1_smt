<div class="card shadow-sm bg-white rounded h-100">
    <div class="card-header bold-text">
        <i class="fas fa-barcode"></i> SCANNING{{--  CONFIGURATION --}}
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md">
                <div class="card" style='border-color:black'>
                    <div class="card-header bold-text">
                        <div class="row">
                            <div class="col-md">
                                <i class="fas fa-cog"></i> CONFIGURATION:
                            </div>
                            <div class="col-md ml-auto text-right">
                                <button id='config-collapse-btn' class="btn btn-outline-secondary p-0 px-2" type="button" data-toggle="collapse" data-target="#collapseConfig">
                                    <i class="fas fa-caret-up"></i>
                                </button>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-body bold-text collapse show" id='collapseConfig'>
                        <div class="row">
                            <div class="col-md">                                
                                <input id="configL" type="checkbox" checked data-toggle="toggle" data-size="small" data-on="<i class='fas fa-lock-open'></i>" data-off='<i class="fas fa-lock"></i>' data-onstyle="secondary" data-offstyle="secondary">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="pcb_input_type" class="col-form-label">TYPE:</label>
                                    </div>
                                    <div class="col-md-8">
                                        @isset($type)
                                            <input id='_type' type="hidden" name="" value='{{$type}}'>
                                        @endisset
                                        <div class="">
                                            <input class='' checked id="pcb_input" type="checkbox" data-toggle="toggle" data-on="SCAN AS IN" data-off="SCAN AS OUT" data-onstyle="primary" data-offstyle="secondary" data-width="100%" data-height="15">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="sel_division" class="col-form-label">DIVISION:</label>                  
                                    </div>
                                    <div class="col-8">
                                        @if (isset($sel_division))
                                            <input id="_div" type="hidden" name="">
                                            <input class='form-control pcbconfig' type="text" id='' value='{{$sel_division->DIVISION_NAME}}' readonly>
                                            <input id="pcb_division_id" type="hidden" name="division_id" value="{{$sel_division->DIVISION_ID}}">
                                        @else
                                            <input class='form-control pcbconfig configlock' type="text" id='display-division' value='' readonly>                    
                                            <select id="pcb_division_id" class="form-control configunlock" name="division_id" placeholder="" required>
                                                    <option value="0">- Please select -</option>
                                                    @foreach ($divisions as $division)
                                                        <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                                    @endforeach
                                            </select>
                                        @endif                                                                                
                                    </div>
                                </div>
                            </div>                                                
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="sel_line" class="col-form-label">LINE:</label>                  
                                    </div>
                                    <div class="col-8">
                                        {{-- @if (isset($sel_line))
                                            <input id="_line" type="hidden" name="">
                                            <input class='form-control pcbconfig' type="text" id='' value='{{$sel_line->description}}' readonly>
                                            <input id="pcb_line_id" type="hidden" name="line_id" value="{{$sel_line->name}}">
                                        @else --}}
                                            <input class='form-control pcbconfig configlock' type="text" id='display-line' value='{{-- {{ (count($sel_line)>0 ? $sel_line->name : '')}} --}}' readonly>
                                            <select id="pcb_line_id" class="form-control configunlock" name="line_id" placeholder="" disabled required>
                                                @if (isset($lines))
                                                    @if ($lines->count() > 0)
                                                        @foreach ($lines as $line)
                                                            <option value="{{$line->id}}">{{$line->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="0">- NO DATA FOUND -</option>
                                                    @endif                                                    
                                                @else
                                                    <option value="0">- Select Division First -</option>
                                                @endif                                            
                                            </select>
                                        {{-- @endif  --}}                                       
                                        {{-- <input id='sel_div_process_id' name='sel_div_process_id' type="hidden" value='{{ (count($sel_line)>0 ? $sel_line->id : '')}}'> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="sel_div_process" class="col-form-label">PROCESS:</label>                  
                                    </div>
                                    <div class="col-8">
                                        <input class='form-control pcbconfig configlock' type="text" id='display-process' value='{{-- {{ (count($sel_div_process)>0 ? $sel_div_process->name : '')}} --}}' readonly>                    
                                        <select class="form-control configunlock" id="pcb_process_id" disabled required>
                                            @if (isset($divprocesses))
                                                @foreach ($divprocesses as $divprocess)
                                                    <option value="{{$divprocess->id}}">{{$divprocess->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="0">- Select Division First -</option>
                                            @endif
                                        </select>
                                        {{-- <input id='sel_div_process_id' name='sel_div_process_id' type="hidden" value='{{ (count($sel_div_process)>0 ? $sel_div_process->id : '')}}'> --}}
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="scan_employee" class="col-form-label bold-text">EMPLOYEE:</label>                  
                                    </div>
                                    <div class="col-8">
                                        <input class='form-control border-success' type="text" id='scan_employee' autocomplete="off" placeholder="Scan employee barcode" style='border-width:medium'>                
                                        <div class="input-group" style='display:none' id='scan_name_div'>
                                            <input class='form-control pcbconfig' type="text" id='scan_name' readonly>
                                            <button type="button" class='' id="reset_emp"><i class="fas fa-redo"></i></button>
                                        </div>
                                        <input type="hidden" id='employee_id' name="employee_id">
                                    </div>
                                </div>                                                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('includes.scan.scanform')
        </div>
        <div class="form-group row">
            <div class="col-md">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link bold-text active" href="#wotab" role="tab" data-toggle="tab">Work Order</a>
                    </li>
                    <li class="nav-item bold-text">
                        <a id='serntab' class="nav-link" href="#serials" role="tab" data-toggle="tab">S/N</a>
                    </li>
                </ul>
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="wotab" style='height:100%' {{-- style='height: 400px' --}}>
                        @include('includes.scan.wotab')
                    </div>
                    <div class="tab-pane container" id="serials" style='height:100%' {{-- style='height: 400px' --}}>
                        @include('includes.scan.sntab')
                    </div>                    
                </div>
            </div>
        </div>
        {{-- <div class="row mb-1">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="col-form-label bold-text">DATE:</label>
                    </div>
                    <div class="col-md-9">
                        <input type="date" id="woDate" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md">
                        <div class="btn-group" role="group">
                            <button id="loadwotable" class="btn btn-primary"><i class="fas fa-sync-alt"></i> LOAD</button>
                            <button class="btn btn-danger"><i class="fas fa-ban"></i> CLEAR</button>
                        </div>
                    </div>                                                
                </div>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md">
                    <span class='text-danger bold-text'>Loaded Work Orders are based on the selected division.</span>
            </div>
        </div>
        <div id='spTablediv'>
            @include('includes.table.spTable')
        </div> --}}                            
        {{-- <div class="row">
            <div class="col-md">
                <div class="card" style='border-color:black'>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <label for="" class='bold-text'><i class="fas fa-info-circle"></i> WORK ORDER INFO:</label>
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="" class="col-form-label bold-text">WORK ORDER #:</label>                  
                                    </div>
                                    <div class="col-7">
                                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                        <div class="form-group row"> 
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="" class="col-form-label bold-text">PART CODE:</label>                  
                                    </div>
                                    <div class="col-7">
                                        <input class='form-control' type="text" id='sel_div_process' value='' readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="form-group row">
            <div class="col-md">
                <div class="card" style='border-color:black'>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="scan_employee" class="col-form-label bold-text">EMPLOYEE:</label>                  
                                    </div>
                                    <div class="col-8">
                                        <input class='form-control border-danger' type="text" id='scan_employee' placeholder="Scan employee barcode" style='border-width:medium'>                
                                        <div class="input-group" style='display:none' id='scan_name_div'>
                                            <input class='form-control pcbconfig' type="text" id='scan_name' readonly>
                                            <button type="button" class='' id="reset_emp"><i class="fas fa-redo"></i></button>
                                        </div>
                                        <input type="hidden" id='employee_id' name="employee_id">
                                    </div>
                                </div>                                                                            
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="scan_serial" class="col-form-label bold-text">SERIAL NO.:</label>                  
                                    </div>
                                    <div class="col-8">
                                        <input class="form-control border-danger" type="text" name="scan_serial" id="scan_serial" placeholder="Scan Serial Number here..." style='border-width:medium'>
                                    </div>
                                </div>
                            </div>                               
                        </div>
                    </div>
                </div>
            </div>
        </div> --}} 
        {{-- row end --}}
    </div>                                     
</div>