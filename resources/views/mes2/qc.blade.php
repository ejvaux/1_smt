@extends('mes2.layouts.app')
@section('tabs')
    <script>
        $('#tab1').addClass('active');
    </script>
@endsection
@section('content')
@include('inc.messages')
<div class="container-fluid border mt-5 border-dark">
    <div class='row '>
        <div class="col-md">
                {{-- Start of code --}}

                <div class="card border-dark mt-3 mb-3 "  >
                    <div class="card-header">
                        <h5>Quality Management - SMT</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                      {{-- Code HERE --}}
                    </ul>
                </div>
        </div>
    </div>    
</div>
@endsection