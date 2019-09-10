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
                    <div class="row form-group">
                        <div class="col-md">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item bold-text">
                                    <a class="nav-link active" href="#hide-tab" role="tab" data-toggle="tab">HIDE</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bold-text" href="#add-tab" role="tab" data-toggle="tab">ADD</a>
                                </li>
                                {{-- <li class="nav-item bold-text">
                                    <a class="nav-link" href="#repair-tab" role="tab" data-toggle="tab">REPAIR</a>
                                </li> --}}
                                {{-- <li class="nav-item bold-text">
                                    <a class="nav-link" href="#search-tab" role="tab" data-toggle="tab">SEARCH</a>
                                </li> --}}
                                <li class="nav-item bold-text">
                                    <a class="nav-link" href="#export-tab" role="tab" data-toggle="tab">EXPORT</a>
                                </li>
                                <li class="nav-item bold-text ml-auto">
                                    <button type="button" class="btn btn-success" id="refresh-table-button"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                                </li>
                                <li class="nav-item bold-text ml-2" style="width:30%">
                                    <form action="" method="get">                   
                                        <div class="input-group">
                                            <input type="date" class='form-control' name="sdate" id="sdate" value="{{$dte}}">
                                            <select class='form-control' name="shift" id="shift">
                                                @if ($shift == '')selected @endif
                                                <option value="" @if ($shift == '')selected @endif>ALL SHIFT</option>
                                                <option value="1" @if ($shift == 1)selected @endif>DAY</option>
                                                <option value="2" @if ($shift == 2)selected @endif>NIGHT</option>
                                            </select>
                                            <button type="button" id="date-search-button">Go</button>
                                        </div>
                                    </form>
                                </li>
                                <li class="nav-item bold-text ml-2" style="width:15%">
                                    <div class="input-group">                        
                                        <input type="text" class="form-control" id="text" name="text" placeholder="Search Serial Number . . .">
                                        <button type="button" class='' id="sn-search-button"><i class="fa fa-search"></i></button>                                            
                                    </div>
                                </li>
                            </ul>
                            
                            <!-- Tab panes -->
                            <div class="tab-content border border-top-0">
                                <div class="tab-pane container py-5" id="add-tab" style='height:100%'>
                                    @include('pages.defect.addTab')                                    
                                </div>
                                {{-- <div class="tab-pane container py-5" id="repair-tab" style='height:100%'>
                                    @include('pages.defect.repairTab')
                                </div> --}}
                                {{-- <div class="tab-pane container py-5" id="search-tab" style='height:100%'>
                                    @include('pages.defect.searchTab')
                                </div> --}}
                                <div class="tab-pane container py-5" id="export-tab" style='height:100%'>
                                    @include('pages.defect.exportTab')
                                </div>
                                <div class="tab-pane container active" id="hide-tab" style='height:100%'>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            @include('pages.defect.addCard')
                        </div>
                        <div class="col-md-4">
                            @include('pages.defect.repairCard')
                        </div>
                        <div class="col-md-4">
                            @include('pages.defect.searchCard')
                        </div> --}}
                    </div>
                    {{-- <div class="row">
                        <div class="col-md">
                            <div class="card">
                                <a id='config-collapse-btn' class="" data-toggle="collapse" data-target="#tool-collapseDiv">
                                    <div class="card-header">               
                                        <div class="row">
                                            <div class="col-md">
                                                TOOL
                                            </div>
                                            <div class="col-md text-right" id="tool-collapse-label">
                                                <i class="fas fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>            
                                </a>    
                                <div class="card-body collapse" id="tool-collapseDiv" >        
                                    
                                </div>
                            </div>
                        </div>
                    </div> --}}                    
                    <div class="row">
                        <div class="col-md">
                            <div id="dsTable-div">
                                @include('includes.table.dsTable')
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modal.dsModal')
@endsection