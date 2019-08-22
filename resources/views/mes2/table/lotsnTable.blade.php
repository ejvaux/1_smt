<div class="row mb-1">
        <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
            <table class="table" id="datatable2">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>S/N</th>
                        <th>JO #</th>
                        <th>LINE</th>
                        <th>EMPLOYEE</th>
                        <th>CREATED_AT</th>
                    </tr>
                </thead>
                <tbody class='text-center' style="font-size:1rem">
                    @isset ($sns)
                        @if (count($sns)>0)
                            @foreach ($sns as $sn)
                                <tr>                                
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$sn->serial_number}}</td>
                                    <td>{{$sn->jo_number}}</td>
                                    <td>{{$sn->PDLINE_NAME}}</td>
                                    <td>{{$sn->employee->fname}} {{$sn->employee->lname}}</td>
                                    <td>{{$sn->created_at}}</td>                            
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th colspan="6">
                                    <h4>No data to display</h4>
                                </th>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <th colspan="6">
                                <h4>No data to display</h4>
                            </th>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>
    </div>