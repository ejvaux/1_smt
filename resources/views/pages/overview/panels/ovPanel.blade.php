<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link bold-text active" href="#wotab" role="tab" data-toggle="tab">Line</a>
    </li>
    {{-- <li class="nav-item bold-text">
        <a class="nav-link" href="#serials" role="tab" data-toggle="tab">S/N</a>
    </li> --}}
</ul>

<!-- Tab panes -->
<div class="tab-content">
    {{-- Line --}}
    @include('pages.overview.tabs.lineTab')

    
    {{-- <div class="tab-pane container" id="serials" style='height:100%'>
        @include('includes.scan.sntab')
    </div> --}}                  
</div>