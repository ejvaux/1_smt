<div class='row mb-1'>
    <div class='col-lg table-responsive'>
        <table id="prTable" class="table no-wrap">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @isset($defect_types)
                    @if (count($defect_types)>0)
                        @foreach($defect_types as $defect_type)
                            <tr>
                                <th>{{ $loop->iteration + (($defect_types->currentPage() - 1) * 20) }}</th>
                                <td>{{$defect_type->code}}</td>
                                <td>{{$defect_type->name}}</td>
                                <td>{{$defect_type->created_at}}</td>
                                <td>{{$defect_type->updated_at}}</td>
                                <th>
                                    <a class="text-info defecttype-edit-btn" data-id="{{$defect_type->id}}" href="#"> EDIT</a>
                                    @if (session('auth') == 'A')
                                        <a class="text-danger defecttype-delete-btn" data-id="{{$defect_type->id}}" href="#"> DELETE</a>
                                    @endif
                                </th>
                            </tr>
                        @endforeach                
                    @else
                        <tr>
                            <td colspan="4" class='text-center'>
                                <h3>No Data</h3>
                            </td>
                        </tr>                    
                    @endif
                @else
                    <tr>
                        <td colspan="4" class='text-center'>
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
        @isset($defect_types)
            {!! $defect_types->appends(\Request::except('page'))->render() !!}
        @endisset        
    </div>
</div>