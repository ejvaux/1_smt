@isset($model_id)
    <h3>Program: {{App\Http\Controllers\MES\model\Modname::where('id',$model_id)->value('program_name')}}</h3>
@endisset
<ul class="nav nav-tabs mb-2 pt-0 " role="tablist">
    <li class="nav-item">
        <a class="nav-link bold-text active" href="#feederlist" role="tab" data-toggle="tab">Feeder List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link bold-text" href="#loaded" role="tab" data-toggle="tab">Materials</a>
    </li>        
</ul>        
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="feederlist" style='height:100%'>
        @include('includes.tracking.panel.feederPanel')
    </div>
    <div class="tab-pane" id="loaded" style='height:100%'>
        @include('includes.tracking.panel.materialPanel')
    </div>
</div>









{{-- <div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">
            <tr><th colspan="9"><h4>Mat Load</h4></th></tr>
            <tr>
                <th>#</th>
                <th>Component</th>
                <th>Machine</th>
                <th>Table</th>
                <th>Mounter</th>
                <th>Position</th>
                <th>Feed Time</th>
                <th>Reel ID</th>
                <th>Reel Q'ty</th>
            </tr>
        </thead>
        <tbody class='text-center'>
            @isset($mm)
                @if (count($mm) > 0)
                    @foreach ($mm as $m)                     
                        <tr>              
                            <td>{{$loop->iteration}}</td>                            
                            <td>{{$m->component_rel->product_number}}</td>
                            <td>{{$m->machine->code}}</td>
                            <td>{{$m->table_id}}</td>
                            <td>{{$m->mounter_id}}</td>
                            <td>{{$m->pos_id}}</td>
                            <td>{{$m->created_at}}</td>
                            <td>{{CustomFunctions::getQrData($m->ReelInfo,'RID')}}</td>
                            <td>{{CustomFunctions::getQrData($m->ReelInfo,'QTY')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="9">
                            <h3>NO DATA TO DISPLAY</h3>
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="9">
                        <h3>NO DATA TO DISPLAY</h3>
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div> --}}