<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('code','Machine Code')</th>
                    <th>@sortablelink('machine_type_id','Machine Type')</th>
                    <th>@sortablelink('line_id','Line')</th>
                    <th>@sortablelink('updated_at','Updated at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($machines)>0)
                    @foreach($machines as $machine)
                        <tr>
                            <th>{{ $loop->iteration + (($machines->currentPage() - 1) * 20) }}</th>
                            <th>{{$machine->code}}</th>
                            <th>{{$machine->type->name}}</th>
                            <th>
                                @if ($machine->line_id == 0)
                                   <span>No Line</span> 
                                @else
                                    {{$machine->line->linename->name}}
                                @endif                                
                            </th>
                            <th>{{$machine->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group">
                                    {{-- <button class='btn btn-outline-info editLine' 
                                        data-id="{{$machine->id}}"
                                        data-code="{{$machine->code}}"
                                        data-machine="{{$machine->machine_id}}"
                                    title="Edit Line"><i class="far fa-edit"></i></button> --}}
                                    <button type='button' class='btn btn-outline-danger deleteMach' data-id="{{$machine->id}}" type='button' title="Delete Machine"><i class="far fa-trash-alt"></i></button>                                    
                                </div>
                                <form id='del_mach_form_{{$machine->id}}' action="{{url('machines/'.$machine->id)}}" method="POST">
                                    @method('DELETE')                                        
                                </form>                              
                            </th>
                        </tr>
                    @endforeach                
                @else
                    <tr>
                        <td colspan="6" class='text-center'>
                            <h3>No Machines Found.</h3>
                        </td>
                    </tr>                    
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $machines->appends(\Request::except('page'))->render() !!}
    </div>
</div>