@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/defect/ds.js')}}" defer></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <span class='bold-text'>Export Data</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Scan Records</h5>
                                        <a class='btn btn-primary' href="{{url('ep/sn')}}"><i class="fas fa-file-download"></i> Export</a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
{{-- @include('includes.modal.dsModal') --}}
@endsection