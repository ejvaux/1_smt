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
    <div class="container-fluid mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id='process-add-btn' class="btn btn-outline-secondary" href='#'><i class="fas fa-plus"></i> New Process</button>           
                </div>
            </div>
            <div class="col-md-3 ml-0 pl-1 ">
                <div class="input-group">                    
                    <input id="search-tb" type="text" class="form-control" name='text' placeholder="Search process . . .">
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-0 mr-0" >
                <div id='process-table-div' class="text-center">
                    {{-- @include('mes.inc.table.prTable') --}}
                    <h3>LOADING TABLE.. PLEASE WAIT...</h3>
                    <img src="{{asset('images/103.gif')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    @include('mes.inc.modal.prModal')
@endsection