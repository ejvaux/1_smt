@foreach ($lines as $line)
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
@endforeach