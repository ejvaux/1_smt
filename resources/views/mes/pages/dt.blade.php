@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb8').addClass('active');
    </script>
@endsection
@section('js')
    <script src="{{ asset('js/mes/dt.js') }}" defer></script>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id='defecttype-add-btn' class="btn btn-outline-secondary" href='#'><i class="fas fa-plus"></i> Defect Type</button>           
                </div>
            </div>
            <div class="col-md-3 ml-0 pl-1 ">
                <div class="input-group">                    
                    <input id="search-tb" type="text" class="form-control" name='text' placeholder="Search defect type . . ." autocomplete="off">
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-0 mr-0" >
                <div id='defecttype-table-div' class="text-center">
                </div>
            </div>
        </div>
    </div>
    @include('mes.inc.modal.dtModal')
@endsection