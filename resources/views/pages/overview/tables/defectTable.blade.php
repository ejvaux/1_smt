<div class="row pt-2 mb-2">
    <div class="col">
        <button id="refresh-defecttable-btn" class="btn btn-secondary py-0 load-defect-btn">RELOAD TABLE</button>
    </div>
    <div class="col text-right ml-auto">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">From</div>
            </div>
            <input type="date" name="from" id="from" value="{{date('Y-m-d',strtotime($from))}}">
            <div class="input-group-prepend">
                <div class="input-group-text py-0">To</div>
            </div>
            <input type="date" name="to" id="to" value="{{date('Y-m-d',strtotime($to))}}">
            <button class="load-defect-btn" id="defect-search-btn">GO</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Defects</th>
                    <th>Repaired</th>
                    {{-- <th>Types</th> --}}
                </tr>
            </thead>
            <tbody>
                @isset($defects)
                    @if (count($defects)> 0)
                        @foreach ($defects as $defect)
                            <tr>
                                <td>
                                    {{$defect['date']}}
                                </td>
                                <td>
                                    {{$defect['defect']}}
                                </td>
                                <td>
                                    {{$defect['repair']}}
                                </td>
                                {{-- <td>
                                    
                                </td> --}}
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="3">No data</td>
                        </tr>
                    @endif
                @endisset
            </tbody>
        </table>
    </div>
</div>