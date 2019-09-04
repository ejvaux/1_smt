<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
        <table class="table table-sm" id="">
            <thead class="thead-light">
                <tr class="text-center">    
                    <th>S/N</th>
                    <th>PART NAME</th>
                    <th>WORK ORDER</th>
                    <th>JOB ORDER</th>
                    <th>DIVISION</th>
                    <th>LINE</th>
                    <th>PROCESS</th>
                    <th>TYPE</th>
                    <th>DEFECT</th>
                    <th>EMPLOYEE</th>
                    <th>SHIFT</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (isset($Pcbs))
                    @foreach ($Pcbs as $pcb)
                        <tr {{-- class='wo-clickable-row' --}} data-wodata='{{$pcb}}'>
                            {{-- <td>{{ $loop->iteration + (($pcbs->currentPage() - 1) * 100) }}</td> --}}
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{$pcb->serial_number}}</td>
                            <td>
                                @php
                                    $model = \App\Models\WorkOrder::where('ID', $pcb->jo_id)->pluck('ITEM_NAME')->first();
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
                            <td>{{$pcb->work_order}}</td>
                            <td>{{$pcb->jo_number}}</td>
                            <td>{{$pcb->division->DIVISION_NAME}}</td>
                            <td>{{$pcb->line->name}}</td>
                            <td>{{$pcb->divprocess->name}}</td>
                            <td>
                                @if ($pcb->type == 0)
                                    IN
                                @else
                                    OUT
                                @endif
                            </td>
                            <td>
                                @if ($pcb->defect == 1)
                                    <span class='text-danger font-weight-bold'>NG</span>
                                @else
                                <span class='text-success font-weight-bold'>GOOD</span>
                                @endif
                            </td>
                            <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                            <td>
                                {{-- {{$pcb->shift}} --}}
                                @if ($pcb->shift == 1)
                                    DAY
                                @else
                                    NIGHT
                                @endif
                            </td>
                            <td>{{$pcb->created_at}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="12">
                            <h4>No data to display. </h4>
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>