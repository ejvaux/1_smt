@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- LEFT PANEL --}}
            <div class="col-md-5 mb-3 h-100">
                @include('pages.materials.panels.leftPanel')
            </div>
            {{-- RIGHT PANEL --}}
            <div class="col-md-7">
                <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-info-circle"></i> &nbspSCAN HISTORY</div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-lg-1 text-center vertical-center bold-text">DATE:</div>
                            <div class="col-lg-4">
                                <input type="date" id="mat_hist_date" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                    {{--   <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                    <select class="input-group-text" id="search_field">
                                                            <option value="">COMPONENT</option>
                                                            <option value="">MACHINE</option>
                                                            <option value="">MODEL</option>
                                                            <option value="">TABLE</option>
                                                            <option value="">MOUNTER</option>
                                                    </select>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Search here.." id="mat_hist_searchbox">
                                    </div> --}}
                            </div>
                            <div class="col-lg-5 vertical-center">
                                <button class="btn btn-sm btn-primary bold-text" type="button" onclick="loaddata_panel_right()"><i class="fas fa-sync"></i>&nbspLOAD</button>
                                <button class="btn btn-sm btn-danger bold-text" type="button" onclick="clear_date()"><i class="fas fa-times"></i>&nbspCLEAR</button>
                                <form  action = "{{ route('Matexport') }}" method = "POST" id="vsearchitem1" name="vsearch_form1" style="display:inline-block">
                                    @csrf
                                    <button class="btn btn-sm btn-success bold-text" type="submit"><i class="fas fa-file-excel"></i>&nbspEXPORT</button>
                                    <input hidden type="text" name="s_date" id="hidDateParam">
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive-xl" style="width: 100%;height: 410px;overflow:auto">
                                <table class="table table-bordered table-hover table-sm table-striped" id="datatable2">
                                        <thead class="thead-dark">
                                                <tr class="text-center">
                                                        <th scope="col">DATE</th>
                                                        <th scope="col">COMPONENT</th>
                                                        <th scope="col">VENDOR</th>
                                                        <th scope="col">MACHINE</th>
                                                        <th scope="col">MODEL</th>
                                                        <th scope="col">TABLE</th>
                                                        <th scope="col">MOUNTER</th>
                                                        <th scope="col">POSITION</th>
                                                        <th scope="col">EMPLOYEE</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <tr style='height:100px'>
                                                        <td colspan='9' class='text-center' style='font-size:1.5em'>
                                                        No data to display.
                                                        </td>
                                                </tr>
                                        </tbody>
                                </table>
                        </div>



                        </div>
                </div>
            </div>
        </div>
        {{-- Bottom Panel --}}
        {{-- <div class="row mt-3">
            <div class="col-md">
                <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-cogs"></i> &nbspCURRENTLY RUNNING IN MACHINES</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <p>
                                    The data below shows the <b>CURRENT</b> material running on a specific machine,table,feeder and tray. This data are generated based on the record saved through material checking scanning
                                    for the sole purpose of visual monitoring. Any data alterations must be scanned to the material checking to save data changes.
                                </p>
                            </div>
                        </div>                        
                        <div class="form-group row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-2 vertical-center"></div>
                            <div class="col-lg-3" style="margin-top: 10px">
                                <select id="goto_search" class="select2" onchange="gotosearch()">
                                        <option value="#">SELECT MACHINE</option>
                                        @foreach ($machine as $machine_item)
                                        <option value="M{{$machine_item->id}}">{{$machine_item->code}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3" style="margin-top: 10px"> 
                                <button class="btn btn-sm btn-primary bold-text" type="button" onclick="load_running_machine_tbl()"><i class="fas fa-sync"></i>&nbspLOAD TABLE</button> 
                                <button class="btn btn-sm btn-danger bold-text" type="button" onclick="clear_running()"><i class="fas fa-times"></i>&nbspCLEAR TABLE</button>         
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="table-responsive-xl" style="width:89vw;height: 400px;overflow:auto;overflow-x:visible">                                                    
                                    <table class="table table-bordered table-hover table-sm table-striped fixed_table" id="datatable3">
                                        <thead class="thead-dark">
                                            <tr class="text-center" id="theads">
                                                    <th scope="col" rowspan="2" nowrap>LINE</th>
                                                    <th scope="col" rowspan="2" nowrap>MACHINE</th>
                                                    <th scope="col" rowspan="2" nowrap>TABLE</th>
                                                    <th scope="col" rowspan="2" nowrap>POSITION</th>
                                            </tr>
                                            <tr id="FvsA"></tr>                                                
                                        </thead>
                                        <tbody>
                                            <tr style='height:100px'>
                                                <td colspan='32' class='text-center' style='font-size:1.5em'>
                                                    No data to display. Try to configure the date parameters to load data.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@include('modal.employeepin')
@include('modal.lineconfig')
@endsection