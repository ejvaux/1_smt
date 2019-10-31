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
                        {{-- @include('includes.lr.linepanel') --}}
                        <lr-form-component :imgsrc="'{{ asset('images/loading3.gif')}}'" datenow="{{$date}}" :lines="{{$lines}}"></lr-form-component>
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
</div>
@include('includes.modal.lrModal')
@endsection
