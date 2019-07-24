{{-- @foreach ($lines as $line)
    @if ($loop->iteration % 4 == 1)
        <div class="row form-group">
            <div class="col-md-3">
                    @include('includes.table.lrTable')
            </div>
    @elseif($loop->iteration % 4 == 0)
            <div class="col-md-3">
                @include('includes.table.lrTable')
            </div>
        </div>
    @else
        <div class="col-md-3">
            @include('includes.table.lrTable')
        </div>
    @endif
@endforeach --}}
{{-- @include('includes.table.lrTable') --}}
<form method="get" class="form_to_submit" action="{{url('lr')}}">
    <div class="row form-group">                                
        <div class="col-md-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="">Date :</div>
                </div>
                <input type="date" id="date" name="date" class="form-control" value="{{$date}}">                
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="">Line :</div>
                </div>
                <select class="form-control" name="line" id="line">
                        {{-- <option value="">-SELECT LINE-</option> --}}
                    @foreach ($lines as $line)
                        @if ($line->line_id == $lid)
                            <option value="{{$line->line_id}}" selected='selected'>{{$line->line->name}}</option>
                        @else
                            <option value="{{$line->line_id}}">{{$line->line->name}}</option>
                        @endif                    
                    @endforeach                                        
                </select>
            </div>            
        </div>
        <div class="col-md">
            <button type="submit" class='btn btn-outline-secondary form-control form_submit_button' id="date-btn">{{-- <i class="fa fa-search"></i> --}}GO</button>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col-md text-center">
            <div id="lr_div">
                @include('includes.table.lrTable')
            </div>
            {{-- @include('includes.lr.linepanel') --}}                                    
        </div>
    </div>
