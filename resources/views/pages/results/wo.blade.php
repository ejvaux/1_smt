@extends('layouts.app2')

@section('js')    
    {{-- <script src="{{ asset('js/lr/lr.js')}}" defer></script> --}}
@endsection

@section('title')    
    W.O. RESULTS - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Work Order Results</h5>
                    </div>
                    <div class="card-body">                        
                        @include('includes.results.wopanel')
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
</div>
@endsection
