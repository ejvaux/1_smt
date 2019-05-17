@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/scan/sp.js')}}" defer></script>
    <script>
        var app_url = "{{ env("APP_URL") }}";
    </script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header">
                        SCAN PAGE SETTINGS GENERATOR
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md">
                                <div class="input-group">                        
                                    <input type="text" class="form-control" id="gen_url_text" name="" placeholder="">
                                    <button type="submit" class='' id="copy_url"><i class="far fa-copy"></i></button> 
                                    <button type="submit" class='' id="gen_url">GENERATE</button>                                            
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md">            
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="pcb_input_type" class="col-form-label">INPUT TYPE:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input checked id="pcb_input_type" type="checkbox" data-toggle="toggle" data-on="SCAN AS IN" data-off="SCAN AS OUT" data-onstyle="primary" data-offstyle="secondary" data-width="100%" data-height="15">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="pcb_division_id" class="col-form-label">DIVISION:</label>                  
                                            </div>
                                            <div class="col-8">
                                                <select id="pcb_division_id" class="form-control " name="division_id" placeholder="" required>
                                                        <option value="">- Please select -</option>
                                                        @foreach ($divisions as $division)
                                                            <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                                                        @endforeach
                                                </select>                               
                                            </div>
                                        </div>
                                    </div>                                                        
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="pcb_line_id" class="col-form-label">LINE:</label>                  
                                            </div>
                                            <div class="col-8">
                                                <select id="pcb_line_id" class="form-control " name="line_id" placeholder="" disabled required>
                                                    <option value="">- Select Division First -</option>
                                                </select>                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="pcb_process_id" class="col-form-label">PROCESS:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" id="pcb_process_id" disabled required>
                                                    <option value="">- Select Division First -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        QR Code
                    </div>
                    <div class="card-body">
                        <div id="qr-div"></div>
                    </div>
                </div>                
            </div>
        </div>        
    </div>
</div>
@endsection