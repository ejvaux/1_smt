<div class="row mb-1">
    <div class="col-md">
        <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
            <table class="table" id="datatable2">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Lead Time</th>
                        <th>S/N</th>
                        <th>DIVISION</th>
                        <th>LINE</th>
                        <th>MODEL</th>
                        <th>SHIFT</th>
                        <th>PROCESS</th>
                        <th>DEFECT</th>
                        <th>LOCATION</th>
                        <th>DEFECT TYPE</th>
                        <th>INSERTED BY</th>
                        <th>DEFECTED AT</th>
                        <th>REPAIRED BY</th>
                        <th>REPAIRED AT</th>
                        {{-- <th>@sortablelink('created_at','INSERTED AT')</th> --}}                    
                    </tr>
                </thead>
                <tbody class='text-center'>
                    @if (count($defect_mats)>0)
                        @foreach($defect_mats as $defect_mat)
                            <tr 
                                @if ($defect_mat->repair)
                                    data-repby='{{$defect_mat->repairby->fname}} {{$defect_mat->repairby->lname}}'
                                    class='clickable-row border-left border-success'
                                @else
                                    class='clickable-row border-left border-danger'
                                @endif
                                data-div='{{$defect_mat->defect->division->DIVISION_ID}}'
                                data-arr='{{$defect_mat}}' data-id='{{$defect_mat->id}}'
                                data-sn='{{$defect_mat->pcb->serial_number}}'
                                data-rep='{{$defect_mat->repair}}'
                                style='border-width:10px !important'>                            
                                {{-- Col --}}
                                    {{-- @if ($defect_mat->repair != true)
                                        <th class='border-bottom-0 border-top-0 border-right border-danger p-0 m-0' style='border-width:6px !important'>
                                    @else
                                        <th class='border-bottom-0 border-top-0 border-right border-success p-0 m-0' style='border-width:6px !important'>
                                    @endif  --}}
                                        <th>                                                  
                                            {{ $loop->iteration + (($defect_mats->currentPage() - 1) * 20) }}                                
                                        </th>                                
                                {{-- Col --}}
                                    <th>
                                        @if ($defect_mat->repair)
                                            <span class='text-success'>{{CustomFunctions::datefinished($defect_mat->created_at,$defect_mat->repaired_at)}}</span>
                                        @else
                                            <span class='text-danger'>{{CustomFunctions::datelapse($defect_mat->created_at)}}</span>
                                        @endif
                                    </th>
                                {{-- Col --}}
                                    <td>
                                        {{$defect_mat->pcb->serial_number}}                            
                                    </td>                             
                                {{-- Col --}}
                                    {{-- <td>{{$defect_mat->defect->division->DIVISION_NAME}}</td> --}}
                                    <td>{{$defect_mat->division->DIVISION_NAME}}</td>
                                {{-- Col --}}
                                    <td>{{$defect_mat->line->name}}</td>
                                {{-- Col --}}
                                    <td>
                                        @php
                                            $joid = \App\Models\Pcb::where('id',$defect_mat->pcb_id)->pluck('jo_id')->first();
                                            $model = \App\Models\WorkOrder::where('ID', $joid)->pluck('ITEM_NAME')->first();
                                            if (strpos($model, ',') !== false) {
                                                $m = explode(",", $model);
                                                if($m[1] == 'Secure'){
                                                    $mod = 'Main Board';
                                                }
                                                else{
                                                    $mod = $m[1];
                                                }
                                            }
                                            else{
                                                $mod = $model;
                                            }
                                            echo $mod;
                                        @endphp
                                    </td>
                                {{-- Col --}}                            
                                    <td>
                                        @if ($defect_mat->shift == 1)
                                            DAY
                                        @else
                                            NIGHT
                                        @endif                                    
                                    </td>
                                {{-- Col --}}
                                    <td>
                                        @if ($defect_mat->process_id)
                                            {{$defect_mat->process->name}}
                                        @else
                                            
                                        @endif                                
                                    </td>                                
                                {{-- Col --}}
                                    <td>{{$defect_mat->defect->DEFECT_NAME}}</td>
                                {{-- Col --}}
                                    <td>
                                        @isset ($defect_mat->d_locations)
                                            @foreach ($defect_mat->d_locations as $key => $loc)
                                                @isset($loc['location_id'])
                                                    {{App\Models\Location::where('id',$loc['location_id'])->first()->name}}
                                                @else
                                                    {{App\Models\Location::where('id',$loc)->first()->name}}
                                                @endisset
                                                @if ($key != count($defect_mat->d_locations) - 1)
                                                    ,                                                                       
                                                @endif
                                            @endforeach
                                        @else
                                            
                                        @endif                                        
                                    </td>
                                {{-- Col --}}
                                    <td>{{$defect_mat->defectType->name}}</td>
                                {{-- Col --}}
                                    <td>{{$defect_mat->employee->fname}} {{$defect_mat->employee->lname}}</td>
                                {{-- Col --}}
                                    {{-- <td>{{$defect_mat->defected_at}}</td> --}}
                                    <td>{{$defect_mat->created_at}}</td>
                                {{-- Col --}}
                                    <td>
                                        @if ($defect_mat->repair_by)
                                            {{$defect_mat->repairby->fname}} {{$defect_mat->repairby->lname}}                                   
                                        @else
                                            -
                                        @endif                                    
                                    </td>
                                {{-- Col --}}
                                    <td>
                                        @if ($defect_mat->repaired_at)
                                            {{$defect_mat->repaired_at}}
                                        @else
                                            -
                                        @endif                                    
                                    </td>                                
                            </tr>
                        @endforeach                
                    @else
                    <tr>
                        <td colspan="14">
                            <h4>No data to display.</h4>
                        </td>
                    </tr>                    
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $defect_mats->appends(\Request::except('page'))->render() !!}
    </div>
</div>