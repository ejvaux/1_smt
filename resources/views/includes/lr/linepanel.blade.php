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
<form method="get" action="">
    <div class="row form-group">                                
        <div class="col-md-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="">Date :</div>
                </div>
                <input type="date" id="date" name="date" class="form-control" value="{{$date}}">
                <button type="button" class='' id="date-btn">{{-- <i class="fa fa-search"></i> --}}GO</button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-control" name="line" id="line">
                    <option value="">-SELECT LINE-</option>
                @foreach ($lines as $line)
                    <option value="{{$line->line_id}}">{{$line->line->name}}</option>
                @endforeach                                        
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md text-center">
            <div id="lr_div">
                @include('includes.table.lrTable')
            </div>
            {{-- @include('includes.lr.linepanel') --}}                                    
        </div>
    </div>
</form>