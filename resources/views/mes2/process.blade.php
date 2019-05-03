@extends('mes.layouts.app')
@section('tabs')
    <script>
        $('#tb7').addClass('active');
    </script>
@endsection
@section('content')

<!-- Start add Modal -->
<div class="modal fade" id="addProcessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Process Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
<form method="POST" action='{{url('process')}}' >
@csrf
<div class="modal-body">

    <!-- Body of Modal Modal -->

            <div class="form-group">
                <label>CODE</label>
                <input type="text" class="form-control" name="code" placeholder="Enter Code" required>
            </div>

            <div class="form-group">
                <label>Process Name</label>
                <input type="text" class="form-control" name="name"  placeholder="Enter Process Name" required>
            </div>
            <div class="form-group">
                <label>Division ID</label>
                {{-- <input type="text" class="form-control" name="division_id"  placeholder="Enter  Division_id " required> --}}
                <select class ="form-control"name="division_id" id="" required>
                    <option value="">- SELECT DIVISION ID -</option>
                    @foreach($divisions as $division)
                    <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                    @endforeach
                </select>
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
<div class="modal fade" id="editProcessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Process Management</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
<form method="POST" action='{{url('process')}}' id="editFormProcessModal" >
         @csrf
         @method('PUT')
         <div class="modal-body">

        <!-- Body of Modal Modal -->


        <div class="form-group">
                <label>CODE</label>
                <input type="text" class="form-control"  id ="code" name="code" placeholder="Enter Code" required>
            </div>

            <div class="form-group">
                <label>Process Name</label>
                <input type="text" class="form-control" id ="name" name="name"  placeholder="Enter Process Name" required>
            </div>
            <div class="form-group">
                <label>Division ID</label>
               {{--  <input type="text" class="form-control" id ="division_id"name="division_id"  placeholder="Enter  Division_id " required> --}}

                <select class ="form-control"name="division_id" id="" required>
                        <option value="">- SELECT DIVISION ID -</option>
                        @foreach($divisions as $division)
                        <option value="{{$division->DIVISION_ID}}">{{$division->DIVISION_NAME}}</option>
                        @endforeach
                </select>
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
                                <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button>
                                {{-- <button type='button' class="btn btn-outline-success mb-1 editProcess1"><i class="fa fa-edit"></i>Update Data</button> --}}
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="myInput" onkeyup="myFunctionTableDtr()" placeholder="Search Data Here..." title="Type in a name">
                            </div>
                        </div>

                <table  id = "myTable" class="table table-hover table-reflow  table-bordered mt-1 mb-4 " style="overflow-x:auto;">
                        <thead class="thead-light" >

                            <tr>

                        <th >@sortablelink('code','Code')</th>
                        <th >@sortablelink('name','Name') </th>
                        <th >@sortablelink('division_id','Division Name') </th>
                        <th > Updated_by</th>
                        <th > Created_at</th>
                        <th > Updated_at</th>
                        <th > Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($processes) > 0)
                        @foreach($processes as $process)
                        <tr class="tableClick" id = "tablerowvalue" data-id1='{{$process->id}}'
                                data-code1='{{$process->code}}'
                                data-name1='{{$process->name}}'
                                data-division_id1='{{$process->division_id}}'>

                        <td><strong>{{$process->code}}</strong></td>
                        <td><strong>{{$process->name}}</strong></td>
                        <td><strong>{{$process->division->DIVISION_NAME}}</strong></td>
                        <td><strong>{{$process->updatedBy->USER_NAME}}</strong></td>
                        {{-- <td><strong>{{$process->updated_by}}</strong></td> --}}
                        <td><strong>{{$process->created_at}}</strong></td>
                        <td><strong>{{$process->updated_at}}</strong></td>
                        <!-- Button FOR ACTIONS -->
                        <td>
                            <form method="post" id="DeleteProcessForm_{{$process->id}}"  action='{{url('process/'.$process->id)}}'>
                                @csrf
                                @method('DELETE')
                                {{-- <div class="container-fluid" style="overflow-x:auto;" > --}}
                                <button type='button'  data-id='{{$process->id}}'
                                        data-code='{{$process->code}}'
                                        data-name='{{$process->name}}'
                                        data-division_id='{{$process->division_id}}'
                                        class="btn btn-outline-success editProcess"><i class="fa fa-edit"></i></button>
                                <button type='button' class="btn btn-outline-danger del_process_btn" data-id='{{$process->id}}'><i class="fa fa-trash"></i></button>
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
