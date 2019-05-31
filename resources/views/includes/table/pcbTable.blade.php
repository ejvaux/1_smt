<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
        <table class="table table-sm" id="">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    {{-- <th>@sortablelink('','')</th> --}}
                    <th>S/N</th>
                    <th>WORK ORDER</th>
                    <th>DIVISION</th>
                    <th>LINE</th>
                    <th>PROCESS</th>
                    <th>TYPE</th>
                    <th>EMPLOYEE</th>
                    <th>SHIFT</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @isset ($pcbs)
                    @if (count($pcbs)>0)
                        @foreach ($pcbs as $pcb)
                            <tr {{-- class='wo-clickable-row' --}} data-wodata='{{$pcb}}'>
                                <td>{{ $loop->iteration + (($pcbs->currentPage() - 1) * 200) }}</td>
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                <td>{{$pcb->serial_number}}</td>
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
                                <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                                <td>{{$pcb->shift}}</td>
                                <td>{{$pcb->created_at}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="10">
                                <h4>No data to display. Try to set the Work Order and then reload the table.</h4>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th colspan="10">
                            <h4>No data to display. Try to set the Work Order and then reload the table.</h4>
                        </th>
                    </tr>
                @endisset                  
            </tbody>
        </table>
    </div>
</div>
@isset($pcbs)
    <div class='row'>
        <div class='col-md'>
            {!! $pcbs->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
@endisset
    