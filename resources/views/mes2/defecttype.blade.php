@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb8').addClass('active');
    </script>
@endsection
@section('content')

<!-- Start add Modal -->
<div class="modal fade" id="addDefectTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Defect Type Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
<form method="POST" action='{{url('defecttype')}}' >
@csrf
<div class="modal-body">

    <!-- Body of Modal Modal -->

            <div class="form-group">
                <label>Code</label>
                <input type="text" class="form-control" name="code" placeholder="Enter Code" required>
            </div>
            <div class="form-group">
                <label>Defect Type</label>
                <input type="text" class="form-control" name="name"  placeholder="Enter Defect Type" required>
            </div>
            <div class="form-group">
            </div>
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save Data</button>
  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Close</button>

</div>
</form>
    <!-- End Body of Modal Modal -->

</div>
</div>
</div>
<!-- End add Modal -->


<!-- Start Edit Modal -->
<div class="modal fade" id="editDefectTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Defect Type Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
<form method="POST" action='{{url('defecttype')}}' id="editFormDefectTypeModal" >
     @csrf
     @method('PUT')
     <div class="modal-body">

    <!-- Body of Modal Modal -->


    <div class="form-group">
            <label>Code</label>
            <input type="text" class="form-control"  id ="code" name="code" placeholder="Enter Code" required>
        </div>

        <div class="form-group">
            <label>Defect Type</label>
            <input type="text" class="form-control" id ="name" name="name"  placeholder="Enter Defect Type" required>
        </div>

</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary"><i class="far fa-edit"></i> Update Data</button>
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Close</button>
</div>
</form>
<!-- End Body of Modal Modal -->

</div>
</div>
</div>
<!-- End Edit Modal -->

<div class="container-fluid mt-5" id="table_display" style="width: 100%;">
    <div class="row mb-2">
        <div class="col-md">
                    @include('inc.messages')
                  {{--   <h1>Hello World! -- Laravel TEST</h1> --}}
            {{--Start TABLE --}}
            <div class="container border-fluid p-0 mb-2">

            </div>


            <div class="container-fluid border " style="overflow-x:auto;">
             <div class="col p-0 border-fluid ">
                    <div class="row mt-2">
                            <div class="col-md-4 mr-auto">
                                <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addDefectTypeModal"><i class="far fa-plus-square"></i> New Data</button>
                                {{-- <button type='button' class="btn btn-outline-success mb-1 editProcess1"><i class="fa fa-edit"></i>Update Data</button> --}}
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="myInputTable" onkeyup="myFunctionTableDefect()" placeholder="Search Data Here..." title="Type in a name">
                            </div>
                        </div>

                <table  id = "myTableDefect" class="table table-hover table-reflow  table-bordered mt-1 mb-4 " style="overflow-x:auto;">
                        <thead class="thead-light" >

                            <tr>

                        <th >@sortablelink('code','Code')</th>
                        <th >@sortablelink('name','Name') </th>
                        <th > Created_at</th>
                        <th > Updated_at</th>
                        <th > Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($defects) > 0)
                        @foreach($defects as $defect)
                        <tr class="tableClick" id = "tablerowvalue">

                        <td><strong>{{$defect->code}}</strong></td>
                        <td><strong>{{$defect->name}}</strong></td>
                        <td><strong>{{$defect->created_at}}</strong></td>
                        <td><strong>{{$defect->updated_at}}</strong></td>
                        <!-- Button FOR ACTIONS -->
                        <td>
                            <form method="post" id="DeleteDefectTypeForm_{{$defect->id}}"  action='{{url('defecttype/'.$defect->id)}}'>
                                @csrf
                                @method('DELETE')
                                {{-- <div class="container-fluid" style="overflow-x:auto;" > --}}
                                <button type='button'  data-id='{{$defect->id}}'
                                        data-code='{{$defect->code}}'
                                        data-name='{{$defect->name}}'
                                        class="btn btn-outline-success editDefect"><i class="fa fa-edit"></i></button>
                                @if (session('auth') == 'A')
                                <button type='button' class="btn btn-outline-danger del_defect_btn" data-id='{{$defect->id}}'><i class="fa fa-trash"></i></button>
                                @endif                                
                                {{-- </div> --}}
                            </form>
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>

                        </div>
                        </div>

                        @else
                        <p>No Posts Found</p>
                        @endif
        {{--End TABLE  --}}
        </div>
    </div>
</div>
@endsection