<div class="row form-group">                                
    <div class="col-md-8">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" id="">Date :</div>
            </div>
            <input type="date" id="date" name="date" class="form-control" value="{{$date}}">                
            <div class="input-group-prepend">
                <div class="input-group-text" id="">Line :</div>
            </div>
            <select class="form-control" name="line" id="line">
                @foreach ($lines as $line)
                    <option value="{{$line->id}}">{{$line->name}}</option>                   
                @endforeach                                                
            </select>
            <button type="button" class='' id="lr-btn-submit">GO</button>
        </div>
    </div>
    <div class="col-md-2">
        <button type="button" id="export-lr-btn" class="form-control">EXPORT</button>
    </div>
</div>
<div class="row">
    <div class="col-md text-center">
        <div id="lr_div" style='transition:2s'>
            @include('includes.table.lrTable')
        </div>                               
    </div>
</div>
