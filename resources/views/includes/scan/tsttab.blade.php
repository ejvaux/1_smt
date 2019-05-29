<div class="row">
    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 100%;overflow:auto' {{-- style='max-height: 350px;overflow:auto' --}}>
        <table class="table table-sm" id="">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>EMPLOYEE</th>
                    <th>IN</th>
                    <th>OUT</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @isset ($emptotals)
                    @if (count($emptotals)>0)
                        @foreach ($emptotals as $emptotal)
                            <tr class=''>                                    
                                <th class='text-left'>{{$emptotal->employee->fname}} {{$emptotal->employee->lname}}</th>
                                <td>{{\App\Models\Pcb::where('jo_id',$joid)->where('employee_id',$emptotal->employee_id)->where('type',0)->groupBy('employee_id')->count()}}</td>
                                <td>{{\App\Models\Pcb::where('jo_id',$joid)->where('employee_id',$emptotal->employee_id)->where('type',1)->groupBy('employee_id')->count()}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="3">
                                <h4>No data to display.</h4>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th colspan="3">
                            <h4>No data to display.</h4>
                        </th>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>