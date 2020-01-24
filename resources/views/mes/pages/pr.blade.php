@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb7').addClass('active');
    </script>
@endsection
@section('js')
    <script src="{{ asset('js/mes/pr.js') }}" defer></script>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id='process-add-btn' class="btn btn-outline-secondary" href='#'><i class="fas fa-plus"></i> New Process</button>           
                </div>
            </div>
            <div class="col-md-3 ml-0 pl-1 ">
                <form method='GET' {{-- action="{{url('ln')}}" --}}>
                    <div class="input-group">                    
                        <input type="text" class="form-control" name='text' placeholder="Search process . . .">
                        <button type="submit" id="search"><i class="fa fa-search"></i></button>
                    </div>               
                </form>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md">
                @include('mes.inc.messages')
            </div>
        </div> --}}
        <div class="row">
            <div class="col-sm-12 py-0 mr-0" >
                <div id='process-table-div'>
                    @include('mes.inc.table.prTable')
                </div>
            </div>
        </div>
    </div>
    {{-- @include('mes.inc.modal.lnModal') --}}
@endsection