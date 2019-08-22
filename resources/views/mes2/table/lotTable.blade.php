<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
        <table class="table" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>JUDGEMENT</th>
                    <th>LOT #</th>
                    <th>JO #</th>
                    <th>CREATED_BY</th>
                    <th>CREATED_AT</th>
                    <th>CLOSED_BY</th>
                    <th>CLOSED_AT</th>
                    <th>CHECKED_BY</th>
                    <th>CHECKED_AT</th>
                </tr>
            </thead>
            <tbody class='text-center' style="font-size:1rem">
                @isset ($lots)
                    @if (count($lots)>0)
                        @foreach ($lots as $lot)
                            <tr>                                
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($lot->status == 0)
                                        <span class="text-warning font-weight-bold">OPEN</span>
                                    @else
                                        @if ($lot->qc_status == 1)
                                            <span class="text-success font-weight-bold">GOOD</span>
                                        @elseif ($lot->qc_status == 2)
                                            <span class="text-danger font-weight-bold">NO GOOD</span>
                                        @else 
                                            <form method="POST" id="qcGood{{$lot->id}}" action='{{url('qcgood')}}'>
                                                @csrf
                                                @method('GET')  
                                                {{-- <button type='button'  data-idqc='{{$Qc->id}}' class="btn btn-outline-success gbtn ml-5 btn-sm"><i class="far fa-check-circle"></i> Good</button> --}}
                                                <input id="lot{{$lot->id}}" type="hidden" class="text" value='{{$lot->id}}' name='id1'>
                                                <input id="userg{{$lot->id}}" type="hidden" name="userid" value="">
                                            </form>
                                            <form method="POST" id="qcnoGood{{$lot->id}}"  action='{{url('qcnogood')}}'>
                                                @csrf
                                                @method('GET')
                                                {{-- <button type='button' data-idqc='{{$Qc->id}}' class="btn btn-outline-danger ngbtn ml-0 mr-10 btn-sm" ><i class="far fa-times-circle"></i> No Good</button> --}}
                                                <input id="lot{{$lot->id}}" type="hidden" class="text" value='{{$lot->id}}' name='id2'>
                                                <input id="userng{{$lot->id}}" type="hidden" name="userid" value="">
                                            </form>                                         
                                            <div class="btn-group" role="group">
                                                <button type='button' data-idqc='{{$lot->id}}' class="btn btn-outline-success gbtn btn-sm"><i class="far fa-check-circle"></i> Good</button>
                                                <button type='button' data-idqc='{{$lot->id}}' class="btn btn-outline-danger ngbtn btn-sm"><i class="far fa-times-circle"></i> No Good</button>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td><a href="#" title="Click to View Details" data-lot_id='{{$lot->id}}' class="showlot"><span class="font-weight-bold">{{$lot->number}}</span></a></td>
                                <td>{{$lot->jo->JOB_ORDER_NO}}</td>
                                <td>
                                    {{$lot->employee_rel_create->fname}} {{$lot->employee_rel_create->lname}}
                                </td>
                                <td>{{$lot->created_at}}</td>
                                <td>
                                    @if ($lot->closed_by)
                                        {{$lot->employee_rel_close->fname}} {{$lot->employee_rel_close->lname}}
                                    @endif
                                    
                                </td>
                                <td>{{$lot->closed_at}}</td>
                                <td>
                                    @if ($lot->checked_by)
                                        {{$lot->employee_rel_check->USER_NAME}}
                                    @endif                                    
                                </td>                                          
                                <td>{{$lot->date}}</td>                               
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="10">
                                <h4>No data to display</h4>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th colspan="10">
                            <h4>No data to display</h4>
                        </th>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>