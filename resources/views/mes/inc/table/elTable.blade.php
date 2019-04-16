<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('fname','First Name')</th>                    
                    <th>@sortablelink('lname','Last Name')</th>
                    <th>@sortablelink('repair','Repair')</th>
                    <th>@sortablelink('created_at','Created at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($employees)>0)
                    @foreach($employees as $employee)
                        <tr>
                            <th>{{ $loop->iteration + (($employees->currentPage() - 1) * 20) }}</th>
                            <th>{{$employee->fname}}</th>
                            <th>{{$employee->lname}}</th>
                            <th>{{-- {{$employee->repair}} --}}
                                @if ($employee->repair == 1)
                                    &#x2714;
                                @else
                                    &#x2716;
                                @endif
                            </th>
                            <th>{{$employee->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group">
                                    <button class='btn btn-outline-info editEmployee' 
                                        data-id="{{$employee->id}}"
                                        data-fn="{{$employee->fname}}"
                                        data-ln="{{$employee->lname}}"
                                        data-rp="{{$employee->repair}}"
                                    title="Edit Employee details"><i class="far fa-edit"></i></button>
                                    {{-- <button type='button' class='btn btn-outline-danger deleteComponent' data-id="{{$employee->id}}" type='button' title="Delete Component"><i class="far fa-trash-alt"></i></button> --}}                                    
                                </div>
                                <form id='del_emp_form_{{$employee->id}}' action="{{url('components/'.$employee->id)}}" method="post">
                                    @method('DELETE')                                        
                                </form>
                            </th>
                        </tr>
                    @endforeach                
                @else
                <tr>
                    <td colspan="5">
                        <h4 class='text-center'>No Employees Found.</h4>
                    </td>
                </tr>                    
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $employees->appends(\Request::except('page'))->render() !!}
    </div>
</div>