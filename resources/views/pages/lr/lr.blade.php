@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/lr/lr.js')}}" defer></script>
@endsection

@section('title')    
    LINE RESULTS - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Line Scan Results</h5>
                    </div>
                    <div class="card-body">
                        {{-- <form method="get" action="">
                            <div class="row form-group">                                
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" id="">Date :</div>
                                        </div>
                                        <input type="date" id="date" name="date" class="form-control" value="{{$date}}">
                                        <button type="button" class='' id="date-btn">GO</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="line" id="line">
                                            <option value="">-SELECT LINE-</option>
                                        @foreach ($lines as $line)
                                            <option value="{{$line->line_id}}">{{$line->line->name}}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md text-center">
                                    <div id="lr_div">
                                        @include('includes.table.lrTable')
                                    </div>                                                                      
                                </div>
                            </div>
                        </form> --}}
                        @include('includes.lr.linepanel')
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
</div>
@endsection
