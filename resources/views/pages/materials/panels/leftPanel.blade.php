<div class="card shadow-sm bg-white rounded h-100">
    <div class="card-header bold-text">
        <div class="row">
            <div class="col">
                <i class="fas fa-barcode"></i> &nbspSCAN AREA
            </div>
            <div class="col text-right">
                <button id='line_mscan_button' class="btn btn-outline-secondary py-0">Line Config</button>
            </div>
        </div>                        
    </div>
    <div class="card-body pt-1">
        <ul class="nav nav-tabs mb-2 pt-0 " role="tablist">
            <li class="nav-item">
                <a class="nav-link bold-text active" href="#manual" role="tab" data-toggle="tab">Manual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link bold-text" href="#replenish" role="tab" data-toggle="tab">Replenish</a>
            </li>
            <li class="nav-item">
                <a class="nav-link bold-text" href="#compare" role="tab" data-toggle="tab">Compare</a>
            </li>         
        </ul>        
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="manual" style='height:100%'>
                @include('pages.materials.panels.manualPanel')
            </div>
            <div class="tab-pane" id="replenish" style='height:100%'>
                @include('pages.materials.panels.replenishPanel')
            </div>
            <div class="tab-pane" id="compare" style='height:100%'>
                @include('pages.materials.panels.comparePanel')
            </div>
        </div>                                   
    </div>
</div>