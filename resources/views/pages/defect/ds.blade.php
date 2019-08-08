@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/defect/ds.js')}}" defer></script>
@endsection

@section('title')    
    DEFECT - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="card shadow-sm bg-white rounded">
            <div class="card-header bold-text"><i class="fas fa-times-circle"></i> DEFECT MATERIALS LIST</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            @include('includes.messages')
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <div class="input-group">
                                <a id="addDefect_btn" class='btn btn-outline-secondary'><i class="fas fa-plus"></i> Add Defect</a>
                                {{-- <a id='repair_btn' class='btn btn-outline-secondary'><i class="fas fa-hammer"></i> Repair</a> --}}
                            </div>
                        </div>
                        <div class="col-md"></div>
                        {{-- <div class="col-md-2">
                            <button id='ds_advancesearch_btn' type="button" class="btn btn-outline-secondary">
                                <i class="fas fa-search"></i> Advanced Search
                            </button>
                        </div> --}}
                        <div class="col-md-3">                        
                            <form action="{{url('ds')}}" method="get">                   
                                <div class="input-group">
                                    <input type="date" class='form-control' name="sdate" id="sdate" value="{{$dte}}">
                                    <button type="submit">Go</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="get" action="{{url('ds')}}">
                                <div class="input-group">                        
                                    <input type="text" class="form-control" id="" name="text" placeholder="Search Serial Number . . .">
                                    <button type="submit" class='' id=""><i class="fa fa-search"></i></button>                                            
                                </div>
                            </form>
                        </div>
                    </div>                  
                    <div class="row">
                        <div class="col-md">
                            @include('includes.table.dsTable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modal.dsModal')
@endsection