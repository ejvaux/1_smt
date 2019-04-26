<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
        <table class="table table-sm" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>@sortablelink('pcb_id','S/N')</th>
                    <th>@sortablelink('division_id','DIVISION')</th>
                    <th>@sortablelink('defect_id','DEFECT')</th>
                    <th>@sortablelink('defected_at','DEFECTED AT')</th>
                    <th>@sortablelink('process_id','PROCESS')</th>
                    <th>@sortablelink('line_id','LINE')</th>
                    <th>@sortablelink('employee_id','EMPLOYEE')</th>
                    <th>@sortablelink('shift','SHIFT')</th>
                    <th>@sortablelink('created_at','INSERTED AT')</th>
                    <th>@sortablelink('repair','REPAIR')</th>
                    <th></th>
                    {{-- <th>@sortablelink('remarks','REMARKS')</th>
                    <th>@sortablelink('repair_by','REPAIRED BY')</th>
                    <th>@sortablelink('repaired_at','REPAIRED AT')</th> --}}
                    {{-- <th>ACTION</th> --}}
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (count($defect_mats)>0)
                    @foreach($defect_mats as $defect_mat)
                        <tr class='clickable-row' data-id='{{$defect_mat->id}}'>
                            
                            @if ($defect_mat->repair != true)
                                <th class='border-bottom-0 border-top-0 border-right border-danger p-0 m-0' style='border-width:4px !important'>
                            @else
                                <th class='border-bottom-0 border-top-0 border-right border-success p-0 m-0' style='border-width:4px !important'>
                            @endif                                                       
                                {{ $loop->iteration + (($defect_mats->currentPage() - 1) * 20) }}
                                {{-- <a id='edit_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-secondary btn-sm edit_defectmat_btn' data-id='{{$defect_mat->id}}'><i class="fas fa-edit"></i></a> --}}
                                {{-- <a id='repair_btn_{{$defect_mat->id}}' class='btn btn-outline-secondary btn-sm repair_btn' data-id='{{$defect_mat->id}}'><i class="fas fa-hammer"></i> Repair</a> --}}                                
                            <td>
                                {{-- {{$defect_mat->pcb->serial_number}} --}}
                                <a class="" data-container="body" data-toggle="popover" data-placement="top" title="ACTION" data-content="
                                <a id='edit_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary btn-sm edit_defectmat_btn' data-id='{{$defect_mat->id}}'><i class='fas fa-edit'></i></a>
                                        <a id='repair_btn_{{$defect_mat->id}}' class='btn btn-outline-primary btn-sm repair_btn' data-id='{{$defect_mat->id}}'><i class='fas fa-hammer'></i></a>                                                                                                                                    
                                ">
                                    {{$defect_mat->pcb->serial_number}}
                                </a>                                
                            </td>
                            <td>{{$defect_mat->defect->division->DIVISION_NAME}}</td>
                            <td>{{$defect_mat->defect->DEFECT_NAME}}</td>
                            <td>{{$defect_mat->defected_at}}</td>
                            <td>
                                @if ($defect_mat->process_id)
                                    {{$defect_mat->process->name}}
                                @else
                                    
                                @endif                                
                            </td>
                            <td>{{$defect_mat->line->code}}</td>
                            <td>{{$defect_mat->employee->fname}} {{$defect_mat->employee->lname}}</td>                            
                            <td>{{$defect_mat->shift}}</td>
                            <td>{{$defect_mat->created_at}}</td>
                            <td class='border-left'>
                                @if ($defect_mat->repair != true)
                                    <span class='text-danger'>NG</span>
                                    {{-- <div id="details_div_{{$defect_mat->id}}">
                                        NG
                                    </div> --}}
                                    <div id="action_div_{{$defect_mat->id}}" class='action_div' style='display:none'>
                                        <a id='edit_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary btn-sm edit_defectmat_btn' data-id='{{$defect_mat->id}}'><i class="fas fa-edit"></i></a>
                                        <a id='repair_btn_{{$defect_mat->id}}' class='btn btn-outline-primary btn-sm repair_btn' data-id='{{$defect_mat->id}}'><i class="fas fa-hammer"></i></a>
                                    </div>                                    
                                @else
                                    <span class='text-success'>GOOD</span>
                                    <div id="action_div_{{$defect_mat->id}}" class='action_div' style='display:none'>
                                        <a id='edit_defectmat_btn_{{$defect_mat->id}}' class='btn btn-outline-primary btn-sm edit_defectmat_btn' data-id='{{$defect_mat->id}}'><i class="fas fa-edit"></i></a>
                                        
                                    </div>
                                @endif                                
                            </td>
                            {{-- <td>
                                @if ($defect_mat->remarks)
                                    <button type="button" class="" data-toggle="popover" title="Remarks" data-content="{{$defect_mat->remarks}}">view</button>
                                @else
                                    
                                @endif                                                                
                            </td>                            
                            <td>
                                @if ($defect_mat->repair_by)
                                    {{$defect_mat->repairby->fname}} {{$defect_mat->repairby->lname}}
                                @else
                                    
                                @endif                                
                            </td>
                            <td>{{$defect_mat->repaired_at}}</td> --}}
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