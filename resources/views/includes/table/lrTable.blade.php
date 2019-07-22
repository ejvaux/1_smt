@if($line)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <h5 class='text-center'>{{$line->line->name}}</h5>
                </div>
            </div>
            <div class="row mb-1">
                <div class="table-responsive-lg w-100 text-nowrap">
                    <table class="table" id="">
                        <thead>
                            <tr class="text-center">
                                <th>SHIFT</th>
                                <th>INPUT</th>
                                <th>OUTPUT</th>
                            </tr>
                        </thead>
                        <tbody class='text-center'>
                            <tr>
                                <th>DAY</th>
                                <td>{{$in1}}</td>
                                <td>{{$out1}}</td>
                            </tr>
                            <tr>
                                <th>NIGHT</th>
                                <td>{{$in2}}</td>
                                <td>{{$out2}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <h3>NO DATA</h3>
@endif
