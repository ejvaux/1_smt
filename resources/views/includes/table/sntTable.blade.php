<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
    <table class="table" id="datatable2">        
            @isset ($reels)
                @if (count($reels)>0)
                    @foreach ($reels as $reel)
                            {{-- @if ($loop->iteration % 3 == 1)
                                <tr>
                                    <td>{{App\Http\Controllers\MES\model\Component::where('id',$reel)->pluck('product_number')->first()}}</td>
                                    <td class='border-right'>{{$prop['RID']}}</td>
                            @elseif($loop->iteration % 3 == 0)
                                    <td>{{App\Http\Controllers\MES\model\Component::where('id',$reel)->pluck('product_number')->first()}}</td>
                                    <td>{{$prop['RID']}}</td>
                                </tr>
                            @else
                                    <td>{{App\Http\Controllers\MES\model\Component::where('id',$reel)->pluck('product_number')->first()}}</td>
                                    <td class='border-right'>{{$prop['RID']}}</td>
                            @endif --}}
                            <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>P/N</th>
                                        <th class='border-right'>REEL ID</th>
                                        <th>P/N</th>
                                        <th class='border-right'>REEL ID</th>
                                        <th>P/N</th>
                                        <th>REEL ID</th>
                                    </tr>
                            </thead>
                            <tbody class='text-center'>
                            @foreach ($reel as $item => $prop)
                                @if ($loop->iteration % 3 == 1)
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
                                @endif
                            @endforeach
                    @endforeach
                @else
                    <tr>
                        <th colspan="6">
                            <h4>No data to display</h4>
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="6">
                        <h4>No data to display.</h4>
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div>