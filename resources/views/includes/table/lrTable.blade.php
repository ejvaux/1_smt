@if(isset($linename))
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <h5 class='text-center'>{{$linename->name}}</h5>
                </div>
            </div>
            <div class="row mb-1">
                <div class="table-responsive-lg w-100 text-nowrap">
                    <table class="table" id="">
                        <thead>
                            <tr class="text-center">
                                <th>SHIFT</th>
                                <th>INPUT</th>
                                <th>OUTPUT</th>
                            </tr>
                        </thead>
                        <tbody class='text-center'>
                            <tr>
                                <th>DAY</th>
                                <td>{{$in1}}</td>
                                <td>{{$out1}}</td>
                                {{-- <td>
                                    {{ App\Models\Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$line->line_id)->where('shift',1)->where('type',0)->count() }}
                                </td>
                                <td>
                                    {{ App\Models\Pcb::select('type')->whereDate('created_at',$date)->where('line_id',$line->line_id)->where('shift',1)->where('type',1)->count() }}
                                </td> --}}
                            </tr>
                            <tr>
                                <th>NIGHT</th>
                                <td>{{$in2}}</td>
                                <td>{{$out2}}</td>
                                {{-- <td>
                                    {{
                                    App\Models\Pcb::select('id')
                                    ->whereDate('created_at', $date)
                                    ->whereTime('created_at', '>=', '18:00:00')
                                    ->where('line_id',$line->line_id)
                                    ->where('shift',2)
                                    ->where('type',0)->count() +
                                    App\Models\Pcb::select('id')
                                    ->whereDate('created_at', $date2)
                                    ->whereTime('created_at', '<', '06:00:00')
                                    ->where('line_id',$line->line_id)
                                    ->where('shift',2)
                                    ->where('type',0)->count()
                                    }}
                                </td>
                                <td>
                                    {{ App\Models\Pcb::select('id')
                                    ->whereDate('created_at', $date)
                                    ->whereTime('created_at', '>=', '18:00:00')
                                    ->where('line_id',$line->line_id)
                                    ->where('shift',2)
                                    ->where('type',1)->count() +
                                    App\Models\Pcb::select('id')
                                    ->whereDate('created_at', $date2)
                                    ->whereTime('created_at', '<', '06:00:00')
                                    ->where('line_id',$line->line_id)
                                    ->where('shift',2)
                                    ->where('type',1)->count()}}
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <h3>NO DATA OR SELECT LINE.</h3>
@endif
