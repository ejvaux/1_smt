@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">SMT System</div>

                <div class="card-body center-text">
                        <img src="{{ asset('images/prima.jpg')}}" class="home-image"><br>
                        
                    {{-- <h1>PRIMA TECH PHILS., INC.</h1>  --}}
                    <br>
                    <br>
                    <a href="/1_smt/public/login" class="btn btn-primary"><i class="fas fa-key"></i> &nbsp&nbspLOGIN</a>
                    &nbsp&nbsp
                    <a href="/1_smt/public/register" class="btn btn-success"><i class="fas fa-user-plus"></i> &nbsp&nbspSIGNUP</a>
                    &nbsp&nbsp
                    <a href="#" class="btn btn-danger"><i class="fas fa-undo-alt"></i> &nbsp&nbspRETURN</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
