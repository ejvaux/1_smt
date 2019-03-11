@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        Feeder List
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="model_name">Model Name:</label>
                                <input class="form-control" type="text" name="model_name" id="model_name" required>
                            </div>
                            <div class="form-group">
                                <label for="machine_type_id">Machine Type:</label>
                                <select type="text" class="form-control select2" id="machine_type_id" name="machine_type_id" placeholder="" required>
                                    <option value="">- Select Machine Type -</option>
                                    @foreach($machine_types as $machine_type)
                                        <option value="{{$machine_type->id}}">{{$machine_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="table_id">Table:</label>
                                <select type="text" class="form-control select2" id="table_id" name="table_id" placeholder="" required>
                                    <option value="">- Select Table -</option>
                                    @foreach($tables as $table)
                                        <option value="{{$table->id}}">{{$table->id}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
