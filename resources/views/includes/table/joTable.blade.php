<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
        <table class="table" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>DATE</th>
                    <th>JOB ORDER</th>
                    <th>WORK ORDER</th>
                    <th>LINE</th>
                    <th>QTY</th>
                    <th>PART CODE</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @isset ($jos)
                    @if (count($jos)>0)
                        @foreach ($jos as $jo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $jo->DATE_ }}</th>
                                <td>{{ $jo->JOB_ORDER_NO }}</td>
                                <td>{{ $jo->SALES_ORDER }}</td>
                                <td>{{ $jo->MACHINE_CODE }}</td>
                                <td>{{ $jo->PLAN_QTY }}</td>
                                <td>{{ $jo->ITEM_CODE }}</td>                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="7">
                                <h4>No data to display. Try to set the Work Order and then reload the table.</h4>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th colspan="7">
                            <h4>No data to display. Try to set the Work Order and then reload the table.</h4>
                        </th>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>
{{-- @isset($jos)
    <div class='row'>
        <div class='col-md'>
            {!! $jos->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
@endisset --}}
