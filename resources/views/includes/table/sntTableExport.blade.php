@foreach ($reels as $reel)
    <table class="table table-sm">
            <thead >
                <tr class="text-center">
                    <th>PN</th>
                    <th>RID</th>
                    <th>MACHINE</th>
                    <th>TABLE</th>
                    <th>POSITION</th>
                    <th>FEEDER</th>
                </tr>
            </thead>                        
            <tbody class='text-center'>
        @foreach ($reel as $item => $prop)
        <tr>
            <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
            <td class='border-right'>{{$prop['RID']}}</td>
            <td>{{CustomFunctions::getmachcode($prop['machine'])}}</td>
            <td>{{CustomFunctions::getmachtable($prop['machine'])}}</td>
            <td>{{App\Http\Controllers\MES\model\Position::where('id',$prop['position'])->pluck('name')->first()}}</td>
            <td>{{$prop['feeder']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
