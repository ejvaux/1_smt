@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb4').addClass('active');
    </script>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        @include('inc.messages')
        <div class="row mb-2">
            <div class="col-md">
                <button id='add-el-btn' class="btn btn-outline-secondary"><i class="fas fa-plus"></i> New Employee</button>
                {{-- <h5 class='text-success'>For additional employee, please contact the system administrator.</span> --}}
            </div>
            <div class="col-md-2">
                <button id="export-el-btn" class="btn btn-outline-secondary form-control">Export</button>
            </div>
            <div class="col-md-3 ml-0 pl-1">
                <form method='GET' action='{{url('el')}}'>
                    <div class="input-group">                    
                        <input type="text" class="form-control" name='text' placeholder="Search employee . . .">
                        <button type="submit" value="" id="search"><i class="fa fa-search"></i></button>
                    </div>               
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-0 mr-0" >
                @include('mes.inc.table.elTable')
            </div>
        </div>
    </div>
    @include('mes.inc.modal.elModal')
@endsection