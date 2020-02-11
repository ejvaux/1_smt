<div class="row mt-2 mb-2">
    <div class="col">
        <button id="refresh-jotable-btn" class="btn btn-secondary py-0 load-jo-btn">RELOAD TABLE</button>
    </div>
    <div class="col text-right ml-auto">
        <span class="font-weight-bold" style="font-size: 1.2rem;">{{Date('l, F d, Y')}}</span>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table">
            <thead>
                <tr class="text-center">
                    {{-- <th>Date</th> --}}
                    <th>Job Order #</th>
                    <th>Work Order</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Line</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @isset($jos)
                    @if (count($jos)> 0)
                        @foreach ($jos as $jo)
                            <tr>
                                {{-- <td>{{$jo->DATE_}}</td> --}}
                                <td>{{$jo->JOB_ORDER_NO}}</td>
                                <td>{{$jo->SALES_ORDER}}</td>
                                <td>{{$jo->ITEM_CODE}}</td>
                                <td>{{$jo->ITEM_NAME}}</td>
                                <td>{{$jo->MACHINE_CODE}}</td>
                                <td>{{$jo->PLAN_QTY}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="6">No data</td>
                        </tr>
                    @endif
                @endisset
            </tbody>
        </table>
    </div>
</div>


