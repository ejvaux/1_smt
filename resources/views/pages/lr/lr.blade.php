@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/lr/lr.js')}}" defer></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Line Scan Results</h5>
                    </div>
                    <div class="card-body">
                        <form method="get" action="{{url('lr')}}">
                            <div class="row form-group">                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" id="">Date :</div>
                                        </div>
                                        <input type="date" id="date" name="date" class="form-control" value="{{$date}}">
                                        <button type="submit" class='' id="">{{-- <i class="fa fa-search"></i> --}}GO</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    @include('includes.lr.linepanel')
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
