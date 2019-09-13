@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/jo/jo.js')}}" defer></script>
@endsection

@section('title')    
    JO TRACKING - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">                        
                       <h5>Search Job Order</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <form method="get" action="{{url('jo')}}">
                                    <div class="input-group">                        
                                        <input type="text" class="form-control" id="" name="text" placeholder="Scan Serial Number Here . . .">
                                        {{-- <button type="submit" class='' id=""><i class="fa fa-search"></i></button> --}}                                            
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form class='form_to_submit' action="{{url('jo')}}" method="get">
                                    <div class="input-group">                        
                                        <input type="date" class="form-control" id="" name="date" value='{{$date}}'>
                                        <button type="submit" class='form_submit_button' id=""><i class="fa fa-search"></i></button>                                            
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3 ml-auto">
                                @if ($wo == '')
                                    <h4 class="text-danger font-weight-bold">Serial Number not found in the database.</h4>
                                @else
                                    <h4>Work Order: <span class="font-weight-bold">{{$wo}}</span></h4>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                @include('includes.table.joTable')
                            </div>
                        </div>
                    </div>
                </div>                                
            </div>
        </div>
    </div>
</div>
@endsection
