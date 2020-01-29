<div class='row mb-1'>
    <div class='col-lg table-responsive'>
        <table id="prTable" class="table no-wrap">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>DEPARTMENT</th>
                    <th>UPDATED BY</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @isset($processes)
                    @if (count($processes)>0)
                        @foreach($processes as $process)
                            <tr>
                                <th>{{ $loop->iteration + (($processes->currentPage() - 1) * 20) }}</th>
                                <td>{{$process->code}}</td>
                                <td>{{$process->name}}</td>
                                <td>{{$process->division->DIVISION_NAME}}</td>
                                <td>
                                    @if ($process->updatedBy)
                                        {{$process->updatedBy->USER_NAME}}
                                    @else
                                        - User not found -
                                    @endif                                    
                                </td>
                                <td>{{$process->created_at}}</td>
                                <td>{{$process->updated_at}}</td>
                                <th>
                                    <a class="text-info process-edit-btn" data-id="{{$process->id}}" href="#"> EDIT</a>
                                    @if (session('auth') == 'A')
                                        <a class="text-danger process-delete-btn" data-id="{{$process->id}}" href="#"> DELETE</a>
                                    @endif
                                    {{-- <div class="btn-group" role="group">
                                        <button class='btn btn-outline-info editProcess' 
                                            data-id="{{$linename->id}}"
                                            data-name="{{$linename->name}}"
                                        title="Edit Process"><i class="far fa-edit"></i></button>
                                        <button type='button' class='btn btn-outline-danger deleteLinename' data-id="{{$linename->id}}" type='button' title="Delete Line"><i class="far fa-trash-alt"></i></button>                                    
                                    </div>
                                    <button type='button' class='btn btn-outline-danger deleteProcess' data-id="{{$process->id}}" type='button' title="Delete Process"><i class="far fa-trash-alt"></i></button>
                                    <form id='del_linename_form_{{$linename->id}}' action="{{url('linenames/'.$linename->id)}}" method="post">
                                        @method('DELETE')                                        
                                    </form> --}} 
                                </th>
                            </tr>
                        @endforeach                
                    @else
                        <tr>
                            <td colspan="8" class='text-center'>
                                <h3>No Data</h3>
                            </td>
                        </tr>                    
                    @endif
                @else
                    <tr>
                        <td colspan="8" class='text-center'>
                            <h3>No Data</h3>
                        </td>
                    </tr>
                @endisset                 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        @isset($processes)
            {!! $processes->appends(\Request::except('page'))->render() !!}
        @endisset        
    </div>
</div>