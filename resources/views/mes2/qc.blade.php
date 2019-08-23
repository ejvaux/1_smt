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
{{-- <div class="container-fluid border mt-5 border-dark">
    <div class='row '>
        <div class="col-md">
                <div class="card border-dark mt-3 mb-3 "  >
                    <div class="card-header">
                        <h5>Quality Management - SMT</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                                    <div class="container-fluid mt-2" id="table_display" style="width: 100%;">
                                        <div class="row mb-2">
                                            <div class="col-md">
                                                        @include('inc.messages')                                                    
                                                <div class="container border-fluid p-0 mb-2">
                                                </div>
                                                <div class="container-fluid border " style="overflow-x:auto;">
                                                <div class="col p-0 border-fluid ">
                                                   
                                                        <div class="row mt-2">
                                                                <div class="col-md-6 mr-auto">
                                                                    <form class="formGetqc"  id="formGetqc" method="POST" action='{{url('qcs/')}}'>
                                                                        @csrf
                                                                        @method('GET')
                                                                                <input type="date" name ="Dateqc" class="date" data-date-format="yyyy/mm/dd" > <button type="submit"  class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal">Search</button>
                                                                    </form>
                                                                </div>


                                                                <div class="col-md-6">
                                                                    <form class="formGetqcl" method="POST" id="formGetqcl" action='{{url('qcl/')}}'>
                                                                        @csrf
                                                                        @method('GET')
                                                                            <input type="text" class="form-control" name="myInputLot" onkeyup="" placeholder="Search Lot Number Here" title="Type in a name" autocomplete="off">
                                                                    </form>
                                                                </div>
                                                            
                                                        </div>
                                                     
                                                    <table  id = "myTable" class="table table-responsive table-hover table-reflow mt-2" style="overflow-x:auto;">
                                                            <thead class="thead-dark" >
                                                            <tr>
                                                                <th >JUDGEMENT</th>
                                                                <th >LOT</th>
                                                                <th >JO NUMBER</th>
                                                                <th >CREATED_BY</th>
                                                                <th >CREATED_AT</th>
                                                                <th >CLOSED_BY</th>
                                                                <th >CLOSED_AT</th>
                                                                <th >CHECKED_BY</th>
                                                                <th >CHECKED_AT</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(count($Qcs) > 0)
                                                            @foreach($Qcs as $Qc)
                                                            <tr>   
                                                                <td>

                                                                        @if ($Qc->status == 0)
                                                                            <div class="div">
                                                                                <div class="row text-center">
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                            <h6><label for="" class="text-warning" style="color: red;">OPEN</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        @elseif($Qc->status == 1 && $Qc->qc_status == 1 )
                                                                        <div class="div">
                                                                                <div class="row text-center">                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <h6><label for="" style="color: green;  text-align: center;"><i class="far fa-check-circle"></i> GOOD</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        @elseif($Qc->status == 1 && $Qc->qc_status == 2 )
                                                                        <div class="div">
                                                                                <div class="row text-center">                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <h6><label for="" style="color: red;  text-align: center;"><i class="far fa-times-circle"></i> NO GOOD</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        
        
                                                                        @else
                                                                        
                                            
                                                                        
                                                                            <div class="row mt-2">
                                                                                    
                                                                                <div class="col-md-6 mr-auto">
                                                                                    <form method="POST" id="qcGood{{$Qc->id}}" action='{{url('qcgood')}}'>
                                                                                    @csrf
                                                                                    @method('GET')
                                                                                    
                                                                                    
                                                                                    <button type='button'  data-idqc='{{$Qc->id}}' class="btn btn-outline-success gbtn ml-5 btn-sm"><i class="far fa-check-circle"></i> Good</button>
                                                                                    <input id="lot{{$Qc->id}}" type="hidden" class="text" value='{{$Qc->id}}' name='id1'>
                                                                                    </form>
                                                                                </div>
                                                                                 
                                                                                
                                                                                <div class="col-md-6">
                                                                                    <form method="POST" id="qcnoGood{{$Qc->id}}"  action='{{url('qcnogood')}}'>
                                                                                    @csrf
                                                                                    @method('GET')
                                                                                  
                                                                                    <button type='button' data-idqc='{{$Qc->id}}' class="btn btn-outline-danger ngbtn ml-0 mr-10 btn-sm" ><i class="far fa-times-circle"></i> No Good</button>
                                                                                    <input id="lot{{$Qc->id}}" type="hidden" class="text" value='{{$Qc->id}}' name='id2'>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            
                                                                            
                                                                            
                                                                        @endif
                                                                       
                                                                    </td>
                                                                <td><strong>{{$Qc->number}}<button  type='button' data-idqc='{{$Qc->number}}' class="btn btn-outline-secondary ml-2 btn-sm showlot"  data-toggle="modal" data-target="#modalqc">View Data</button></strong></td>
                                                                <td><strong>{{$Qc->jo->JOB_ORDER_NO}}</strong></td>
                                                                
                                                                <td>
                                                                    <strong>{{$Qc->employee_rel_create->fname}} {{$Qc->employee_rel_create->lname}}</strong>
                                                                </td>
                                                                <td><strong>{{$Qc->created_at}}</strong></td>
                                                                <td>
                                                                    @if ($Qc->closed_by)
                                                                        <strong>{{$Qc->employee_rel_close->fname}} {{$Qc->employee_rel_close->lname}}</strong>
                                                                    @endif
                                                                    
                                                                </td>
                                                                <td><strong>{{$Qc->closed_at}}</strong></td>
                                                                <td>
                                                                    @if ($Qc->checked_by)
                                                                        <strong>{{$Qc->employee_rel_check->fname}} {{$Qc->employee_rel_check->lname}}</strong>
                                                                    @endif
                                                                    
                                                                </td>                                          
                                                                <td><strong>{{$Qc->date}}</strong></td>                           
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            @else
                                            <p>No Posts Found</p>
                                            @endif
                                            </div>
                                        </div>
                                    </div>

                    </ul>
                </div>
        </div>
    </div>    
</div> --}}
<div id="lotmodaldiv">
    @include('mes2.inc.snmodal')
</div>
@endsection