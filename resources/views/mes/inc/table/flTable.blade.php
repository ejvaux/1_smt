<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('code','Model Name')</th>
                    <th>@sortablelink('program_name','Program Name')</th>
                    <th>@sortablelink('revision','Version')</th>
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
                            <th>{{$model->version}}</th>
                            <th>{{$model->updatedBy->USER_NAME}}</th>
                            <th>{{$model->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ url('fld/'.$model->id)}}" class='btn btn-outline-info' title="View"><i class="fa fa-eye"></i></a>
                                    {{-- <button class='btn btn-outline-danger deleteModel' type='button' title="Delete" disabled><i class="far fa-trash-alt"></i></button> --}}
                                </div>                                
                            </th>
                        </tr>
                    @endforeach                
                @else
                    <p>No Models Found.</p>
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