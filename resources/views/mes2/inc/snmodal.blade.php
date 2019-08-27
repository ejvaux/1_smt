<div id='modalqc' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Lot Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="container modal-body text-center">
            <div id="lotmodalcontent">            
                @include('mes2.inc.lotmodalcontent')
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
        </div>
    </div>
</div>

<div class="modal fade  bd-example-modal-lg" id="modalqc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Quality Management - SMT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

<div class="modal-body">


    <!-- Body of Modal Modal -->
    <h6>Lot Number:</h6> <strong><h6 ><input type="text" id="idlot" class="text" disabled style=" text-align: center;" ></h6></strong>

      {{--Start TABLE --}}
      <div class="container border-fluid p-0 mb-2 border-secondary"  style="overflow-x:auto;">
        
    </div>
    <div class="container-fluid p-0" style="overflow-x:auto;">
     <div class="col p-0 border-fluid">
            <div class="row ">
                    <div class="col-md-6 mr-auto mt">
                       
                        <form class="formGetPcb" method="POST" action='{{url('tracking/')}}'>
                            @csrf
                            @method('GET')
                            
                            {{-- <input type="Text" class="form-control mb-2" name="myInputPCB" placeholder="Search PCB Here" autocomplete="off"> --}}
                            
                            {{-- <button type="submit">Get User</button><br> --}}
                        </form>
                      
                    </div>
                    <div class="col-md-4">
                        {{-- <input type="text" class="form-control" id="myInput" onkeyup="myFunctionTableDtr()" placeholder="Search Data Here..." title="Type in a name"> --}}
                        
                    </div>
            </div>

            <div class="row mb-1">
                    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
                        <table class="table table-sm" id="">
                            <thead class="thead-light">
                                <tr class="text-center">
                                   
                                    <th>S/N</th>
                                    <th>WORK ORDER</th>
                                    <th>DIVISION</th>
                                    <th>LOT_ID</th>
                                    <th>LINE</th>
                                    <th>PROCESS</th>
                                    <th>TYPE</th>
                                    <th>EMPLOYEE</th>
                                    <th>SHIFT</th>
                                    <th>CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class='text-center'>
                                @isset ($Pcbs)
                                    @if (count($Pcbs)>0)
                                        @foreach ($Pcbs as $pcb)
                                            <tr {{-- class='wo-clickable-row' --}} data-wodata='{{$pcb}}'>
                                                {{-- <td>{{ $loop->iteration + (($pcbs->currentPage() - 1) * 100) }}</td> --}}
                                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                                <td>{{$pcb->serial_number}}</td>
                                                <td>{{$pcb->jo_number}}</td>
                                                <td>{{$pcb->division->DIVISION_NAME}}</td>
                                                <td>{{$pcb->lot_id}}</td>
                                                <td>{{$pcb->line->name}}</td>
                                                <td>{{$pcb->divprocess->name}}</td>
                                                <td>
                                                    @if ($pcb->type == 0)
                                                        IN
                                                    @else
                                                        OUT
                                                    @endif
                                                </td>
                                                <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                                                <td>{{$pcb->shift}}</td>
                                                <td>{{$pcb->created_at}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th colspan="10">
                                                <h4>No data to display. </h4>
                                            </th>
                                        </tr>
                                    @endif
                                
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</div>
{{-- End Table --}}


    <!-- End Body of Modal Modal -->

</div>
</div>
</div>
</div>