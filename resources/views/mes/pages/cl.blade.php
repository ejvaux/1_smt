@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb2').addClass('active');
    </script>
@endsection
@section('content')
    <div class="container-fluid mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    {{-- <a class="btn btn-secondary" href='/1_atms/public/it/aq'>Handled</a> --}}
                    <button id='addComponent' class="btn btn-outline-secondary" href='#'><i class="fas fa-plus"></i> New Component</button>      
                </div>
            </div>
            <div class="col-md-3 ml-0 pl-1 ">
                <form method="get" action="{{url('cl')}}">
                    <div class="input-group">                    
                        <input type="text" class="form-control" id="" name='text' placeholder="Search component . . .">
                        <button type='submit' value="" id="search"><i class="fa fa-search"></i></button>
                    </div>               
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center w-100">
                @include('mes.inc.messages')
            </div>
        </div>
        <div class="row">
            <div class="col-md py-0 mr-0 text-center" >
                {{-- <h1>MODEL - PARTS TEST PAGE</h1> --}}                
                @include('mes.inc.table.clTable')
            </div>
        </div>
    </div>
    @include('mes.inc.modal.clModal')
@endsection