@extends('layouts.app2')

@section('content')
<div class="container-fluid">
<div class="white_bkg">
    
    <div class="row">
        {{-- LEFT PANEL --}}
        <div class="col-sm-8">              
            <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-cog"></i>&nbspSCANNING CONFIGURATION</div>
                    <div class="card-body">
                    
                        <div class="row no-gutters">
                            
                            <div class="col-sm-2 bold-text vertical-center text-center">INPUT TYPE: &nbsp</div>
                            <div class="col-sm-3  vertical-center">
                                    <input id="input_type" type="checkbox" checked data-toggle="toggle" data-on="SCAN AS IN" data-off="SCAN AS OUT" data-onstyle="success" data-offstyle="danger" data-width="200" data-height="15">
                            </div>

                            <div class="col-sm-2 bold-text vertical-center text-center">PROCESS: &nbsp</div>
                            <div class="col-sm-3  vertical-center">
                                <select class="select2">
                                            <option>SELECT PROCESS</option>
                                        @foreach ($processlist as $processlist_item)
                                            <option value="{{$processlist_item->id}}">{{$processlist_item->process_ini}}-{{$processlist_item->process_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        
                            <div class="w-100 d-none d-md-block"></div>
                        
                            <div class="col-sm-2 bold-text vertical-center text-center">PROD LINE: &nbsp</div>
                            <div class="col-sm-3 vertical-center">
                                    <select class="select2">
                                            <option>SELECT LINE</option>
                                        @foreach ($pline as $pline_item)
                                            <option value="{{$pline_item->id}}">{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                        @endforeach
                                        
                                    </select>
                            </div>
                            <div class="col-sm-2 bold-text vertical-center text-center">MACHINE: &nbsp</div>
                            <div class="col-sm-3  vertical-center">
                                    <select class="select2">
                                        <option>SELECT MACHINE</option>
                                    </select>
                            </div>

                        </div>
                        <br>
                    </div>
            </div>
                    
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-sm-4">
                <div class="card shadow-sm bg-white rounded">
                        <div class="card-header bold-text"><i class="fas fa-barcode"></i>&nbspSERIAL NUMBER SCANNING AREA</div>
                        <div class="card-body">
                            <p><b>NOTE:</b>  Make sure to configure the scanning options before scanning a serial number.</p>
                            {{$ipAdd}}
                            <hr>
                            <input type="text" name="input_scan" id="input_scan" placeholder="Input Serial Number here..." 
                            class="form-control" autofocus style="height: 30px" onkeypress="return enterEvent(event)">
                        </div>
                </div>

        </div>
    </div>
    

</div>
</div>
@endsection
{{-- 
 --}}