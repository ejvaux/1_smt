<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('code','Model Name')</th>
                    <th>@sortablelink('program_name','Program Name')</th>
                    {{-- <th>@sortablelink('revision','Version')</th> --}}
                    <th>@sortablelink('updated_by','Updated by')</th>
                    <th>@sortablelink('updated_at','Updated at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($models)>0)
                    @foreach($models as $model)
                        <tr>
                            <th>{{ $loop->iteration + (($models->currentPage() - 1) * 10) }}</th>
                            <th>{{$model->code}}</th>
                            <th>{{$model->program_name}}</th>
                            {{-- <th>{{$model->version}}</th> --}}
                            <th>
                                @if ($model->updated_by)
                                    {{$model->updatedBy->USER_NAME}}
                                @else
                                    Error: No update user.
                                @endif                                
                            </th>
                            <th>{{$model->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ url('fld/'.$model->id.'/0/0')}}" title="View">VIEW</a>                                    
                                    @if (session('auth') == 'A' || session('userid') == 128)
                                    &nbsp;|&nbsp;<a class="text-danger delete-model-btn" title="Delete" href="#" data-id='{{$model->id}}'>DELETE</a>                                       
                                    @endif
                                </div>                                
                            </th>
                        </tr>
                    @endforeach                
                @else
                    <tr>
                        <td colspan="6" class='text-center'>
                            <h3>No Models Found.</h3>
                        </td>
                    </tr>                    
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $models->appends(\Request::except('page'))->render() !!}
    </div>
</div>