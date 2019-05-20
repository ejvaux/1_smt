<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
        <table class="table" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>@sortablelink('defect_id','DIVISION')</th>
                    <th>@sortablelink('line_id','LINE')</th>
                    <th>@sortablelink('shift','SHIFT')</th>
                    <th>@sortablelink('process_id','PROCESS')</th>
                    <th>@sortablelink('pcb_id','S/N')</th>
                    <th>@sortablelink('defect_id','DEFECT')</th>
                    <th>@sortablelink('defect_type_id','DEFECT TYPE')</th>
                    <th>@sortablelink('employee_id','EMPLOYEE')</th>
                    <th>@sortablelink('defected_at','DEFECTED AT')</th>
                    {{-- <th>@sortablelink('created_at','INSERTED AT')</th> --}}
                    <th>@sortablelink('repair','Lead Time')</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (count($defect_mats)>0)
                    @foreach($defect_mats as $defect_mat)
                        <tr class='clickable-row'
                            @if ($defect_mat->repair)
                            data-repby='{{$defect_mat->repairby->fname}} {{$defect_mat->repairby->lname}}'
                            @endif
                            data-div='{{$defect_mat->defect->division->DIVISION_ID}}'
                            data-arr='{{$defect_mat}}' data-id='{{$defect_mat->id}}'
                            data-sn='{{$defect_mat->pcb->serial_number}}'
                            data-rep='{{$defect_mat->repair}}'>
                            {{-- Col1  --}}
                                @if ($defect_mat->repair != true)
                                    <th class='border-bottom-0 border-top-0 border-right border-danger p-0 m-0' style='border-width:6px !important'>
                                @else
                                    <th class='border-bottom-0 border-top-0 border-right border-success p-0 m-0' style='border-width:6px !important'>
                                @endif                                                       
                                    {{ $loop->iteration + (($defect_mats->currentPage() - 1) * 20) }}                                
                                    </th>
                            {{-- Col 2 --}}
                                <td>{{$defect_mat->defect->division->DIVISION_NAME}}</td>
                            {{-- Col 3 --}}
                                <td>{{$defect_mat->line->name}}</td>
                            {{-- Col 4 --}}                            
                                <td>{{$defect_mat->shift}}</td>
                            {{-- Col 5 --}}
                                <td>
                                    @if ($defect_mat->process_id)
                                        {{$defect_mat->process->name}}
                                    @else
                                        
                                    @endif                                
                                </td>
                            {{-- Col 6 --}}
                                <td>
                                    {{$defect_mat->pcb->serial_number}}
                                    {{-- <div class="btn-group dropright">
                                        <button class="btn btn-light p-0" data-toggle="dropdown">
                                            {{$defect_mat->pcb->serial_number}}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-sm">
                                            <ul class="nav justify-content-center">                                            
                                            @if ($defect_mat->repair != true)
                                                <li class="nav-item mr-1">
                                                    <a id='edit_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary nav-link btn-sm edit_defectmat_btn py-1 px-2' title='Edit' data-id='{{$defect_mat->id}}'><i class='fas fa-edit'></i> Edit</a>
                                                </li>
                                                <li class="nav-item">    
                                                    <a id='repair_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary nav-link btn-sm repair_defectmat_btn py-1 px-2' title='Repair' data-id='{{$defect_mat->id}}'><i class='fas fa-hammer'></i> Repair</a>                                            
                                                </li>
                                            @else 
                                                <li class="nav-item">
                                                    <a id='details_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary nav-link btn-sm details_defectmat_btn py-1 px-2' title='View Repair' data-id='{{$defect_mat->id}}'><i class='fas fa-eye'></i> Details</a>                                            
                                                </li>
                                            @endif
                                            </ul>
                                        </div>
                                    </div> --}}                             
                                </td>
                            {{-- Col 7 --}}
                                <td>{{$defect_mat->defect->DEFECT_NAME}}</td>
                            {{-- Col 8 --}}
                                <td>{{$defect_mat->defectType->name}}</td>
                            {{-- Col 9 --}}
                                <td>{{$defect_mat->employee->fname}} {{$defect_mat->employee->lname}}</td>
                            {{-- Col 10 --}}
                                {{-- <td>{{$defect_mat->defected_at}}</td> --}}
                                <td>{{$defect_mat->created_at}}</td>
                            {{-- Col 11 --}}
                                <th>
                                    @if ($defect_mat->repair)
                                        <span class='text-success'>{{CustomFunctions::datetimefinished($defect_mat->created_at,$defect_mat->repaired_at)}}</span>
                                    @else
                                        <span class='text-danger'>{{CustomFunctions::datetimelapse($defect_mat->created_at)}}</span>
                                    @endif    
                                </th>
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
<div class='row'>
    <div class='col-md'>
        {!! $defect_mats->appends(\Request::except('page'))->render() !!}
    </div>
</div>