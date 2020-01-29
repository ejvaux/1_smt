<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('code','Line')</th>
                    <th>@sortablelink('updated_at','Updated at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($linenames)>0)
                    @foreach($linenames as $linename)
                        <tr>
                            <th>{{ $loop->iteration + (($linenames->currentPage() - 1) * 10) }}</th>
                            <th>{{$linename->name}}</th>
                            <th>{{$linename->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group">
                                    {{-- <button class='btn btn-outline-info editLinename' 
                                        data-id="{{$linename->id}}"
                                        data-name="{{$linename->name}}"
                                    title="Edit Line"><i class="far fa-edit"></i></button>
                                    <button type='button' class='btn btn-outline-danger deleteLinename' data-id="{{$linename->id}}" type='button' title="Delete Line"><i class="far fa-trash-alt"></i></button> --}}
                                    <a class='text-info editLinename' 
                                        data-id="{{$linename->id}}"
                                        data-name="{{$linename->name}}"
                                    title="Edit Line" href="#">EDIT</a>
                                    @if (session('auth') == 'A')
                                        &nbsp;|&nbsp;<a class='text-danger deleteLinename' data-id="{{$linename->id}}" title="Delete Line" href="#">DELETE</a>
                                    @endif
                                </div>
                                <form id='del_linename_form_{{$linename->id}}' action="{{url('linenames/'.$linename->id)}}" method="post">
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
        {!! $linenames->appends(\Request::except('page'))->render() !!}
    </div>
</div>