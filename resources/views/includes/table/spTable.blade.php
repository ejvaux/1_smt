<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
        <table class="table table-sm" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    {{-- <th>Plan date</th> --}}
                    {{-- <th>@sortablelink('JOB_ORDER_NO','WORK ORDER')</th>
                    <th>@sortablelink('','PLAN QTY')</th>
                    <th>@sortablelink('ITEM_CODE','PART CODE')</th>
                    <th>@sortablelink('ITEM_NAME','PART NAME')</th>
                    <th>@sortablelink('MACHINE_CODE','LINE')</th> --}}
                    <th>WORK ORDER</th>
                    <th>PLAN QTY</th>
                    <th>PART CODE</th>
                    <th>PART NAME</th>
                    <th>LINE</th>
                    {{-- <th>@sortablelink('','RESULT')</th> --}}
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (count($workorders)>0)
                    @foreach ($workorders as $workorder)
                        <tr class='wo-clickable-row' data-wodata='{{$workorder}}'>
                            {{-- <td>{{$workorder->DATE_}}</td> --}}
                            <td>{{ $loop->iteration + (($workorders->currentPage() - 1) * 100) }}</td>
                            <td>{{$workorder->JOB_ORDER_NO}}</td>
                            <td>{{$workorder->PLAN_QTY}}</td>
                            <td>{{$workorder->ITEM_CODE}}</td>
                            <td>{{$workorder->ITEM_NAME}}</td>
                            <td>{{$workorder->MACHINE_CODE}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="6">
                            <h4>No data to display.</h4>
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $workorders->appends(\Request::except('page'))->render() !!}
    </div>
</div>