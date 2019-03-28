@extends('mes.layouts.app')
@section('tabs')
    <ul class="navbar-nav nav-tabs mr-auto mt-1" id="tb">
        <li><a id="tb1" class="nav-link tbl active" href="{{url('fl')}}">Feeder List</a></li>
        {{-- <li><a id="tb2" class="nav-link tbl" href="{{url('mp')}}">Model - Parts</a></li>
        <li><a id="tb3" class="nav-link tbl" href="{{url('lm')}}">Line - Machine Structure</a></li>
        <li><a id="tb4" class="nav-link tbl" href="{{url('el')}}">Employees</a></li> --}}
    </ul>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-10">
                <div class="row mb-2">
                    <div class="col-md">
                        <div class="btn-group" role="group" aria-label="Basic example">                    
                            <a class="btn btn-outline-secondary py-0 p-1" href='{{url('fl')}}'><i class="fas fa-arrow-left"></i> Back</a>                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md" >
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md text-center">
                                    <h6 class='text-muted'>
                                        FEEDER UNIT LOCATION LIST
                                    </h6>
                                    <input id='mdl_id' type="hidden" name="" value="{{$model->id}}">
                                </div>                                                          
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Model Name:
                                            </div>
                                            <div class="col-md-6">
                                                {{$model->code}}
                                            </div>
                                            <div class="col-md"></div>
                                        </div>                                         
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Version:
                                            </div>
                                            <div class="col-md-5">
                                                {{$model->version}}
                                            </div>
                                        </div>                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Program Name:
                                            </div>
                                            <div class="col-md-6">
                                                {{$model->program_name}}
                                            </div>
                                            <div class="col-md"></div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Last Updated:
                                            </div>
                                            <div class="col-md-5">
                                                {{$model->updated_at}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Machine Name:
                                            </div>
                                            <div class="col-md-6">
                                                @if (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->count()>0)
                                                    <select name="" id="flviewmachine">
                                                        {{-- <option value="">- Select Machine -</option> --}}
                                                        @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->get() as $mach1)
                                                            <option value="{{$mach1->machine_type_id}}">{{$mach1->machinetype->name}}</option>
                                                        @endforeach                                                    
                                                    </select>  
                                                @endif                                                
                                                <button id='add_mach' style='font-size:.8rem' title="Add Machine"><i class="fas fa-plus"></i> Machine</button>
                                                <select style='display:none' name="" id="addmachlist">
                                                    <option value="">- Select Machine -</option>                                                    
                                                    @foreach ($machinetypes as $machinetype)
                                                        @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->get() as $mach2)
                                                            @if ($machinetype->id == $mach2->machine_type_id)
                                                                @php
                                                                    $chk = 1;
                                                                @endphp
                                                            @endif                                                            
                                                        @endforeach
                                                        @if ($chk == 0)
                                                            <option value="{{$machinetype->id}}">{{$machinetype->name}}</option>
                                                        @else
                                                            @php
                                                                $chk = 0;
                                                            @endphp
                                                        @endif
                                                    @endforeach                                                                                                       
                                                </select><br>
                                                <button id='insert_mach' style='color:green;font-size:.8rem;display:none'><i class="fas fa-plus"></i> ADD</button>
                                                <button id='cancel_mach' style='color:red;font-size:.8rem;display:none'><i class="fas fa-ban"></i> CANCEL</button>
                                            </div>
                                            <div class="col-md"></div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Updated by:
                                            </div>
                                            <div class="col-md-5">
                                                @if ($model->updated_by)
                                                    {{$model->updatedBy->USER_NAME}}
                                                @else
                                                    Error: No update user.
                                                @endif
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md">
                                        <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                  <a class="nav-link active" href="#">Active</a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" href="#">Link</a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link" href="#">Link</a>
                                                </li>
                                                <li class="nav-item">
                                                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                                                </li>
                                              </ul>
                                    </div>
                                </div> --}}
                                <div class="row mt-3">
                                    <div class="col-md">
                                        {{-- delete mounter form --}}
                                            <form class='form_to_submit' id='delmountform' method='POST' action='/1_smt/public/del_mount'>
                                                <input id='del_model_id' name='model_id' type="hidden" value="">
                                                <input id='del_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='del_table_id' name='table_id' type="hidden" value="">
                                                <input id='del_mounter_id' name='mounter_id' type="hidden" value="">
                                                <input id='del_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        {{-- change mounter form --}}
                                            <form class='form_to_submit' id='chngemountform' method='POST' action='/1_smt/public/change_mount'>
                                                <input id='exc_model_id' name='model_id' type="hidden" value="">
                                                <input id='exc_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='exc_table_id' name='table_id' type="hidden" value="">
                                                <input id='exc_mounter_id_from' name='mounter_id_from' type="hidden" value="">
                                                <input id='exc_mounter_id_to' name='mounter_id_to' type="hidden" value="">
                                                <input id='exc_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        {{-- transfer mounter form --}}
                                            <form class='form_to_submit' id='transfermountform' method='POST' action='/1_smt/public/transfer_mount'>
                                                <input id='trns_model_id' name='model_id' type="hidden" value="">
                                                <input id='trns_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='trns_table_id' name='table_id' type="hidden" value="">
                                                <input id='trns_table_id_to' name='table_id_to' type="hidden" value="">
                                                <input id='trns_mounter_id' name='mounter_id' type="hidden" value="">
                                                <input id='trns_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        <div id="fltable">
                                            {{-- <h5>No selected machine.</h5> --}}
                                            @include('mes.inc.messages')
                                            @include('mes.inc.table.mach')
                                        </div>
                                    </div>    
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div id="fdrmodl">
                    @include('mes.inc.modal.flModal')
                </div>                
            </div>
        </div>
    </div>
@endsection