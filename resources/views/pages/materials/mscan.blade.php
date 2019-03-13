@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- LEFT PANEL --}}
            <div class="col-lg-5">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-barcode"></i> &nbspSCAN AREA</div>
                            <div class="card-body">
                                    <div class="row" style="height: 465px">
                                        <div class="col-lg-3 vertical-center text-center bold-text">EMPLOYEE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_employee">
                                                        <option value="">SELECT EMPLOYEE</option>
                                                        @foreach ($emp as $emp_item)
                                                         <option value="{{$emp_item->id}}">{{$emp_item->lname}}, {{$emp_item->fname}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MODEL NAME:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_model">
                                                        <option value="" selected>SELECT MODEL</option>
                                                        @foreach ($models as $models_item)
                                                        <option value="{{$models_item->id}}">{{$models_item->code}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        {{-- <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">TABLE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_table">
                                                        <option value="">SELECT TABLE</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div> --}}
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MACHINE CODE:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_machine" placeholder="INPUT MACHINE CODE" class="form-control" onkeypress="return event_mach(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">POSITION:</div>
                                         <div class="col-lg-7">
                                                <select class="select2" id="scan_pos">
                                                        <option value="" selected>SELECT POSITION</option>
                                                        @foreach ($position as $position_item)
                                                        <option value="{{$position_item->id}}">{{$position_item->name}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">FEEDER SLOT#:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_feed_slot">
                                                        <option value="" selected>SELECT FEEDER #</option>
                                                        @foreach ($mounter as $mounter_item)
                                                        <option value="{{$mounter_item->id}}">{{$mounter_item->code}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">FOR REPLENISHMENT? &nbsp</label>
                                                <input id="replenish" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO" data-offstyle="danger" onchange="IsReplenish()" checked>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will load the same reel component/partname. 
                                                                This will require you to scan both reel barcodes.</span>
                                        </div>
                                        {{-- <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">&nbsp&nbsp&nbsp&nbspUSE ALTERNATIVES? &nbsp</label>
                                                <input id="alt_items" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="mr-1" data-on="YES" data-offstyle="danger" data-off="NO">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will use alternative item components.</span>
                                        </div> --}}
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">LAST PRIMA PN:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_oldPN" placeholder="INPUT LAST PRIMA PN" class="form-control"  onkeypress="return event_lastPN(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">PRIMA PN TO LOAD:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_newPN" placeholder="INPUT PRIMA PN TO LOAD" class="form-control" onkeypress="return event_loadPN(event)" ></div>
                                        <div class="col-lg-2"></div>
                                    </div>
                            </div>
                    </div>
            </div>
            {{-- RIGHT PANEL --}}
            <div class="col-lg-7">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-info-circle"></i> &nbspSCAN HISTORY</div>
                            <div class="card-body">
                               

                                <div class="row">
                                        <div class="col-lg-1 text-center vertical-center bold-text">DATE:</div>
                                        <div class="col-lg-4">
                                               <input type="date" id="mat_hist_date" class="form-control" onchange="loaddata_panel_right()">
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
                                                <button class="btn btn-sm btn-danger bold-text" type="button" onclick="clear_date()"><i class="fas fa-ban"></i>&nbspCLEAR</button>
                                                <form  action = "{{ route('Matexport') }}" method = "POST" id="vsearchitem1" name="vsearch_form1" style="display:inline-block">
                                                        @csrf
                                                        <button class="btn btn-sm btn-success bold-text" type="submit"><i class="fas fa-file-excel"></i>&nbspEXPORT</button>
                                                        <input hidden type="text" name="s_date" id="hidDateParam">
                                                </form>
                                        </div>
                                </div>
                                <br>
                                <div class="table-responsive-xl" style="width: 100%;height: 400px;overflow:auto">
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
                                                                <th scope="col">POSITION</th><th scope="col">EMPLOYEE</th>
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

            <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>

            {{-- BOTTOM PANEL --}}
            <div class="col-lg-12">
                        <div class="card shadow-sm bg-white rounded">
                                        <div class="card-header bold-text"><i class="fas fa-cogs"></i> &nbspCURRENTLY RUNNING IN MACHINES</div>
                                        <div class="card-body">
                                                <p>The data below shows the current material running on a specific machine,table,feeder and tray. The data below are generated based on the record saved through material checking scanning.</p>
                                                 <div style="text-align: right">
                                                      
                                                       
                                                 </div>
                                                 <div class="row">
                                                         <div class="col-lg-3"></div>
                                                         <div class="col-lg-3"></div>
                                                         <div class="col-lg-3">
                                                                <select id="goto_search" class="select2" onchange="gotosearch()">
                                                                        <option value="#">SELECT MACHINE</option>
                                                                        @foreach ($machine as $machine_item)
                                                                        <option value="M{{$machine_item->id}}">{{$machine_item->code}}</option>
                                                                        @endforeach
                                                                        
                                                                </select>
                                                         </div>
                                                         <div class="col-lg-3"> 
                                                                <button class="btn btn-sm btn-primary bold-text" type="button" onclick="load_running_machine_tbl()"><i class="fas fa-sync"></i>&nbspLOAD TABLE</button> 
                                                                <button class="btn btn-sm btn-danger bold-text" type="button" onclick="clear_running()"><i class="fas fa-ban"></i>&nbspCLEAR TABLE</button>         
                                                        </div>
                                                 </div>
                                                 <br>
                                                        <div class="table-responsive-xl" style="width: 100%;height: 400px;overflow:auto;position: relative;">
                                                                        
                                                                        <table class="table table-bordered table-hover table-sm table-striped fixed_table" id="datatable3">
                                                                                <thead class="thead-dark">
                                                                                        <tr class="text-center">
                                                                                                <th scope="col">LINE</th>
                                                                                                <th scope="col">MACHINE</th>
                                                                                                <th scope="col">TABLE</th>
                                                                                                <th scope="col">POSITION</th>
                                                                                                
                                                                                                @foreach ($mounters as $mounters_item)
                                                                                                        <th scope="col" id="{{$mounters_item->id}}">{{$mounters_item->code}}</th>
                                                                                                @endforeach 
                                                                                        </tr>
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
@include('modal.employeepin')
@endsection
