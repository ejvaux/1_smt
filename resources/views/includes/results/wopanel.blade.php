<form method="get" class="form_to_submit" action="{{url('wor')}}">
    <div class="row form-group">                                
        <div class="col-md">
            <div class="input-group">
                {{-- <div class="input-group-prepend">
                    <div class="input-group-text" id="">Work Order :</div>
                </div> --}}
                <input value="{{$woi}}" class="form-control" type="text" name="wo" id="" placeholder="Enter Work Order Here . . .">
                <select class='form-control' name="pid" id="">
                    @if (isset($dprocs))
                        @foreach ($dprocs as $dproc)
                            @if ($dproc->id == 2)
                                <option value="{{$dproc->id}}" selected>{{$dproc->name}}</option>
                            @else
                                <option value="{{$dproc->id}}">{{$dproc->name}}</option>
                            @endif                        
                        @endforeach
                    @else
                        <option value="">No Data</option>
                    @endif                                            
                </select>
                <select class='form-control' name="type" id="">
                    <option value="1">OUT</option>
                    <option value="0">IN</option>
                </select>
                <button type="submit">GO</button>
            </div>
        </div>
    </div>
</form>
    <div class="row text-center">
        <div class="col-md">
            <div class="table-responsive-lg w-100 text-nowrap">
                <table class="table" id="">
                    <thead>
                        <tr class="text-center">
                            <th>WORK ORDER</th>
                            <th>TOTAL SCAN</th>
                        </tr>
                    </thead>
                    <tbody class='text-center'>
                        @if (isset($wts))
                            @foreach ($wts as $wo => $total)
                                <tr>
                                    <th>
                                        {{$wo}}                            
                                    </th>
                                    <th>
                                        {{$total}}
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr><th colspan="2">NO DATA</th></tr>
                        @endif                                                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
