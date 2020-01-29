<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('code','Line')</th>
                    <th>@sortablelink('machine_id','Machine')</th>
                    <th>@sortablelink('updated_at','Updated at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($lines)>0)
                    @foreach($lines as $line)
                        <tr>
                            <th>{{ $loop->iteration + (($lines->currentPage() - 1) * 10) }}</th>
                            <th>{{$line->linename->name}}</th>
                            <th>{{$line->machine->code}}</th>
                            <th>{{$line->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group">
                                    {{-- <button class='btn btn-outline-info editLine' 
                                        data-id="{{$line->id}}"
                                        data-code="{{$line->code}}"
                                        data-machine="{{$line->machine_id}}"
                                    title="Edit Line"><i class="far fa-edit"></i></button>
                                    <button type='button' class='btn btn-outline-danger deleteLine' data-id="{{$line->id}}" type='button' title="Delete Component"><i class="far fa-trash-alt"></i></button> --}}
                                    <a class='text-info editLine' 
                                        data-id="{{$line->id}}"
                                        data-code="{{$line->code}}"
                                        data-machine="{{$line->machine_id}}"
                                    title="Edit Line" href="#">EDIT</a>
                                    @if (session('auth') == 'A')
                                        &nbsp;|&nbsp;<a type='button' class='text-danger deleteLine' data-id="{{$line->id}}" title="Delete Component" href="#">DELETE</a>
                                    @endif                                                                     
                                </div>
                                <form id='del_line_form_{{$line->id}}' action="{{url('lines/'.$line->id)}}" method="post">
                                    @method('DELETE')                                        
                                </form>                              
                            </th>
                        </tr>
                    @endforeach                
                @else
                    <tr>
                        <td colspan="6" class='text-center'>
                            <h3>No Lines Found.</h3>
                        </td>
                    </tr>                    
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $lines->appends(\Request::except('page'))->render() !!}
    </div>
</div>