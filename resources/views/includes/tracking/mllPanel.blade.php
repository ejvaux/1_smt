<div class="row mb-2">
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" id="">Line :</div>
            </div>
            <select class="form-control" name="line" id="line">
                <option value="">Please Select Line</option>
                @foreach ($lines as $line)
                    <option value="{{$line->id}}">{{$line->name}}</option>                   
                @endforeach                                                
            </select>
            <button type="button" class='' id="ml-btn-submit">GO</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md">
        <div id="ml_div">
            @include('includes.table.mlTable')
        </div>        
    </div>
</div>