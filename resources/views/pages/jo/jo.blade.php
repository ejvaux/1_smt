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
                            <div class="col-md-4">
                                <form method="get" action="{{url('jo')}}">
                                    <div class="input-group">                        
                                        <input type="text" class="form-control" id="" name="text" placeholder="Scan Serial Number Here . . .">
                                        <button type="submit" class='' id=""><i class="fa fa-search"></i></button>                                            
                                    </div>
                                </form>
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
