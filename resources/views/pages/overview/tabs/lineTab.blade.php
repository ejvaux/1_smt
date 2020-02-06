<div class="tab-pane container-fluid border border-top-0 active" id="linetab" style='height:100%' >
    <div class="row mt-2">
        <div class="col">
            <a class="text-primary font-weight-bold" href="#">REFRESH</a>
        </div>
        <div class="col"></div>
        <div class="col-3 text-right ml-auto">
            <span class="font-weight-bold" style="font-size: 1rem;">As of {{Date('Y-m-d H:i:s')}}</span>
        </div>
    </div>
    <div id="line-panel-div"></div>
    @for ($i = 0; $i < 12; $i++)
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    {{-- <div class="card-header">                        
                        LINE
                    </div> --}}
                    <div class="card-body">   
                        
                    </div>
                </div>
            </div>
        </div>
    @endfor
    
</div>