<div class="row pt-2 mb-2">
    <div class="col">
        <button id="refresh-linetable-btn" class="btn btn-secondary py-0 load-line-btn">RELOAD TABLE</button>
    </div>
    <div class="col text-right ml-auto">
        <span class="font-weight-bold" style="font-size: 1.2rem;">As of {{Date('Y-m-d H:i:s')}}</span>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th>Line</th>
                    <th>Work Order</th>
                    <th>Job Order</th>
                    <th>Item Code</th>
                    <th>Process</th>
                    <th>Last Scan Out</th>
                </tr>
            </thead>
            <tbody>
                @isset($scans)
                    @if (count($scans)> 0)
                        @foreach ($scans as $scan)
                            <tr>
                                <td>{{$scan->line->description}}</td>
                                <td>{{$scan->workorder->SALES_ORDER}}</td>
                                <td>{{$scan->jo_number}}</td>
                                <td>{{$scan->workorder->ITEM_CODE}}</td>
                                <td>{{$scan->divprocess->name}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col mr-0 pr-0">
                                            {{$scan->created_at}}
                                        </div>
                                        <div class="col ml-0 pl-0">
                                            {{$scan->employee->fname . ' ' . $scan->employee->lname}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">No data</td>
                        </tr>
                    @endif
                @endisset
            </tbody>
        </table>
    </div>
</div>


