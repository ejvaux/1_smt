@extends('mes2.layouts.app')
@section('tabs')
    <script>
        $('#tab1').addClass('active');
    </script>
@endsection
@section('content')
    <div class="container-fluid mt-5" id="table_display">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-10">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <form method='GET' action="{{url('qc')}}">
                            <div class="input-group">                    
                                <input type="text" class="form-control" name='sn' placeholder="Scan Serial Number . . .">
                                {{-- <button type="submit" id="search"><i class="fa fa-search"></i></button> --}}
                            </div>               
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form action="{{url('qc')}}" method="GET">
                            <div class="input-group">                        
                                <input type="date" class="form-control" id="" name="date" value='{{$date}}'>
                                <button type="submit" class='' id=""><i class="fa fa-search"></i></button>                                            
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form id="lot-sort-form" action="{{url('qc')}}" method="GET">
                            <div class="input-group">                        
                                <select name="sort" id="lot-sort" class="form-control" >
                                    <option value="0" @if($sort == 0)selected="selected"@endif >ALL</option>
                                    <option value="1" @if($sort == 1)selected="selected"@endif >OPEN</option>
                                    <option value="2" @if($sort == 2)selected="selected"@endif >FOR INSPECT</option>
                                    <option value="3" @if($sort == 3)selected="selected"@endif >GOOD</option>
                                    <option value="4" @if($sort == 4)selected="selected"@endif >NO GOOD</option>
                                </select>                                            
                            </div>
                            <input type="hidden" name="date" value="{{$date}}">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        @include('mes.inc.messages')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md py-0 mr-0" >
                        @include('mes2.table.lotTable')
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>        
    </div>
<div id="lotmodaldiv">
    @include('mes2.inc.snmodal')
</div>
@endsection