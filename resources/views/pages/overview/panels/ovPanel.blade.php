<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link bold-text active" href="#linetab" role="tab" data-toggle="tab">Line</a>
    </li>
    <li class="nav-item bold-text">
        <a class="nav-link" href="#defecttab" role="tab" data-toggle="tab">Defect</a>
    </li>
    <li class="nav-item bold-text">
        <a class="nav-link" href="#jotab" role="tab" data-toggle="tab">Job Order</a>
    </li>
    {{-- <li class="nav-item bold-text">
        <a class="nav-link" href="#wotab" role="tab" data-toggle="tab">Work Order</a>
    </li> --}}
</ul>

<!-- Tab panes -->

<div class="tab-content" style="min-height: 500px">
    {{-- <div id='ludeng' class="border border-top-0" >
        <div class="row text-center h-100">
            <div class="col h-100" style='margin:15%;'>
                <h3>Loading Table . . . Please Wait . . .</h3><img src="{{asset('images/103.gif')}}" alt="">
            </div>
        </div>
    </div>  --}}   
    <div class="tab-pane container-fluid border border-top-0 active" id="linetab" style='height:100%' >
        <div id="line-table-div"></div>
    </div>
    <div class="tab-pane container-fluid border border-top-0" id="defecttab" style='height:100%' >
        <div id="defect-table-div"></div>
    </div>
    <div class="tab-pane container-fluid border border-top-0" id="jotab" style='height:100%' >
        <div id="jo-table-div"></div>
    </div>
    {{-- <div class="tab-pane container-fluid border border-top-0" id="wotab" style='height:100%' >
        <div id="wo-table-div"></div>
    </div> --}}
</div>