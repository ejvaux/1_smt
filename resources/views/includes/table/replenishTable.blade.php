<div class="table table-responsive text-nowrap">
    <table class="table table-sm w-100" id="">
        <thead class="text-center">
            <tr>
                <th colspan="4">LOCATION</th>
                <th>QUANTITY</th>
                <th></th>
            </tr>
        </thead>
        <tbody class='text-center'>
            @isset($reps)
                @if (count($reps) > 0)
                    @foreach ($reps as $rep)                        
                        <tr class="border-left
                            @if ($rep['rqty'] < $rep['qty'] * -1)
                                border-danger
                            @else
                                border-warning
                            @endif
                            "
                            style="border: 2px"               
                        >
                            <td>{{$rep['machine']}}</td>
                            <td>Tbl {{$rep['table']}}</td>
                            <td>{{$rep['feeder']}}</td>
                            <td>{{$rep['position']}}</td>
                            <td>{{$rep['rqty']}}</td>
                            <td width="30%">
                                <input  class="qr-scan w-100" type="text" name="" id="" data-id='{{$rep['feeder_id']}}' placeholder=" SCAN HERE"  autocomplete="off">
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="6">
                            NO DATA
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="6">
                        NO DATA
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div>