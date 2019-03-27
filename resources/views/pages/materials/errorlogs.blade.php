@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
            <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-times-circle"></i> &nbspERROR MATERIAL SCANNING CHECKING</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3"></div>
                            <div class="col-lg-3">
                                <input type="date" name="date_name" class="form-control" id="date_error">
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-sm btn-primary bold-text" type="button" onclick="LoadErrorTbl()"><i class="fas fa-sync"></i>&nbspLOAD</button>
                                <form  action = "#" method = "POST" id="vsearchitem1" name="vsearch_form1" style="display:inline-block">
                                        @csrf
                                        <button class="btn btn-sm btn-success bold-text" type="submit"><i class="fas fa-file-excel"></i>&nbspEXPORT</button>
                                        <input hidden type="text" name="s_date" id="hidDateParam">
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive-xl" style="width: 100%;height: 410px;overflow:auto">
                                <table class="table table-bordered table-hover table-sm table-striped" id="datatable2">
                                        <thead class="thead-dark">
                                                <tr class="text-center">
                                                        <th scope="col">DATE</th>
                                                        <th scope="col">COMPONENT</th>
                                                        <th scope="col">VENDOR</th>
                                                        <th scope="col">MACHINE</th>
                                                        <th scope="col">MODEL</th>
                                                        <th scope="col">TABLE</th>
                                                        <th scope="col">MOUNTER</th>
                                                        <th scope="col">POSITION</th>
                                                        <th scope="col">EMPLOYEE</th>
                                                        <th scope="col">ERROR TEXT</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <tr style='height:100px'>
                                                        <td colspan='10' class='text-center' style='font-size:1.5em'>
                                                        No data to display.
                                                        </td>
                                                </tr>
                                        </tbody>
                                </table>
                        </div>


                    </div>
            </div>

    </div>
</div>

@endsection