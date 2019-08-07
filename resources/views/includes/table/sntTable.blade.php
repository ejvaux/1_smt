{{-- <div class="row">
    <div class="col-md text-center">
        <h2 id='snhead'>@isset($sn){{$sn}}@endisset</h2>
    </div>
</div> --}}
<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
    <input id='snhead' type="hidden" value="@isset($sn){{$sn}}@endisset" >    
    @isset ($reels)
        @if (count($reels)>0)
            @foreach ($reels as $reel)
                <table class="table table-sm" id="datatable2">
                    <thead >
                        <tr class="text-center">
                            <th>#</th>
                            <th>PN</th>
                            <th>RID</th>
                            <th>QTY / REEL</th>
                            <th>MACHINE</th>
                            <th>TABLE</th>
                            <th>POSITION</th>
                            <th>FEEDER</th>
                        </tr>
                    </thead>
                    <tbody class='text-center'>
                @foreach ($reel as $item => $prop)
                    {{-- @if ($loop->iteration % 3 == 1)
                        <tr>
                            <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                            <td class='border-right'>{{$prop['RID']}}</td>
                    @elseif($loop->iteration % 3 == 0)
                            <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                            <td>{{$prop['RID']}}</td>
                        </tr>
                    @else
                            <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                            <td class='border-right'>{{$prop['RID']}}</td>
                    @endif --}}
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                        <td>{{$prop['RID']}}</td>
                        <td>{{$prop['QTY']}}</td>
                        <td>{{CustomFunctions::getmachcode($prop['machine'])}}</td>
                        <td>{{CustomFunctions::getmachtable($prop['machine'])}}</td>
                        <td>{{App\Http\Controllers\MES\model\Position::where('id',$prop['position'])->pluck('name')->first()}}</td>
                        <td>{{$prop['feeder']}}</td>
                    </tr>
                @endforeach                    
                {{-- <tr>
                    @for ($i = 0; $i < 6; $i++)
                        <td></td>
                    @endfor
                </tr> --}}
                    </tbody>
                </table>
            @endforeach
        @else
            {{-- <tr>
                <th colspan="6">
                    <h4>No data to display</h4>
                </th>
            </tr> --}}
            <h4 class='text-center'>No data to display</h4>
        @endif
    @else
        {{-- <tr>
            <th colspan="6">
                <h4>No data to display.</h4>
            </th>
        </tr> --}}
        <h4 class='text-center'>No data to display</h4>
    @endisset    
</div>