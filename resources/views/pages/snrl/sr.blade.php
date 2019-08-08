@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/snrl/sr.js')}}" defer></script>
@endsection

@section('title')    
    SN/REEL - SMT SYSTEM
@endsection

@section('content')
    <div class="container-fluid">
        <div class="white_bkg">
            <div class="row">
                <div class="col-lg"></div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">                        
                            <h5 class="font-weight-bold">SERIAL NUMBER - REEL TRACKING</h5>
                        </div>
                        <div class="card-body">                        
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link bold-text active" href="#sn" role="tab" data-toggle="tab">Search by S/N</a>
                                </li>
                                <li class="nav-item bold-text">
                                    <a class="nav-link" href="#pn" role="tab" data-toggle="tab">Search by P/N</a>
                                </li>
                                <li class="nav-item bold-text">
                                    <a class="nav-link" href="#reel" role="tab" data-toggle="tab">Search by RID</a>
                                </li>
                                <li class="nav-item bold-text">
                                    <a class="nav-link" href="#snpn" role="tab" data-toggle="tab">Search by SN/PN</a>
                                </li>
                                {{-- <li class="nav-item bold-text">
                                    <a class="nav-link" href="#export" role="tab" data-toggle="tab">Export</a>
                                </li> --}}
                            </ul>
                            
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane container active" id="sn" style='height:100%'>
                                    @include('includes.snrl.snumberTab')
                                </div>
                                <div class="tab-pane container" id="pn" style='height:100%'>
                                    @include('includes.snrl.pnTab')
                                </div>
                                <div class="tab-pane container" id="reel" style='height:100%'>
                                    @include('includes.snrl.reelTab')
                                </div>
                                <div class="tab-pane container" id="snpn" style='height:100%'>
                                    @include('includes.snrl.snpnTab')
                                </div>
                                {{-- <div class="tab-pane container" id="export" style='height:100%'>
                                    @include('includes.snrl.exportTab')
                                </div> --}}                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg"></div>
            </div>
        </div>
    </div>
@endsection
