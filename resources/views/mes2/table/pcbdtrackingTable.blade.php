<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
        <table class="table table-sm" id="">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>STATUS</th>
                    <th>S/N</th>
                    <th>DIVISION</th>
                    <th>LINE</th>
                    <th>MODEL</th>
                    <th>SHIFT</th>
                    <th>PROCESS</th>
                    <th>DEFECT</th>
                    <th>DEFECT TYPE</th>
                    <th>INSERTED BY</th>
                    <th>DEFECTED AT</th>
                    <th>REPAIRED BY</th>
                    <th>REPAIRED AT</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (isset($pcbds))
                    @foreach ($pcbds as $pcb)
                        <tr>
                            <td>
                                @if ($pcb->repair == 1)
                                    <span class='text-success font-weight-bold'>REPAIRED</span>
                                @else
                                    <span class='text-danger font-weight-bold'>FOR REPAIR</span>
                                @endif
                            </td>
                            <td>{{$pcb->pcb->serial_number}}</td>
                            <td>{{$pcb->defect->division->DIVISION_NAME}}</td>
                            <td>{{$pcb->line->name}}</td>
                            <td>
                                @php
                                    $joid = \App\Models\Pcb::where('id',$pcb->pcb_id)->pluck('jo_id')->first();
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
                            <td>
                                @if ($pcb->shift == 1)
                                    DAY
                                @else
                                    NIGHT
                                @endif                                    
                            </td>
                            <td>
                                @if ($pcb->process_id)
                                    {{$pcb->process->name}}
                                @else
                                    
                                @endif                                
                            </td>
                            <td>{{$pcb->defect->DEFECT_NAME}}</td>
                            <td>{{$pcb->defectType->name}}</td>
                            <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                            <td>{{$pcb->created_at}}</td>
                            <td>
                                @if ($pcb->repair_by)
                                    {{$pcb->repairby->fname}} {{$pcb->repairby->lname}}                                   
                                @else
                                    -
                                @endif                                    
                            </td>
                            <td>
                                @if ($pcb->repaired_at)
                                    {{$pcb->repaired_at}}
                                @else
                                    -
                                @endif                                    
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="13">
                            <h4>No data to display. </h4>
                        </th>
                    </tr>
                @endif            
            </tbody>
        </table>
    </div>
</div>