@for ($i = 1; $i <= \App\Http\Controllers\MES\model\MachineType::where('id',3)->pluck('table_count')->first(); $i++)
    @if (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('machine_type_id',3)->where('table_id',$i)->count())
        <div class="row">
            <div class="col-md">
                <span class='font-weight-bold text-muted'>Table {{$i}}</span> <button>Add Component</button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class='text-muted' scope="col">Mounter</th>
                    <th class='text-muted' scope="col">Position</th>
                    <th class='text-muted' scope="col">Preference</th>
                    <th class='text-muted' scope="col">Product Number</th>
                    <th class='text-muted' scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('machine_type_id',3)->where('table_id',$i)->get() as $feeder)
                    <tr>
                        @php
                            if($tb != $i){
                                $mt = 0;
                                $ps = 0;
                                $tb = $i;
                            }
                            if($mt != $feeder->mounter_id && $ps == $feeder->pos_id){
                                $ps = 0;
                            }
                            if ($mt != $feeder->mounter_id) {
                                echo "<td rowspan='".\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('machine_type_id',3)->where('table_id',$i)->where('mounter_id',$feeder->mounter_id)->count()."'>".$feeder->mounter->code."</td>";
                                $mt = $feeder->mounter_id;
                            }
                            if($ps != $feeder->pos_id){
                                echo "<td rowspan='".\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('machine_type_id',3)->where('table_id',$i)->where('mounter_id',$feeder->mounter_id)->where('pos_id',$feeder->pos_id)->count()."'>".$feeder->position->name."</td>";
                                $ps = $feeder->pos_id;
                            }
                        @endphp
                        <td>{{$feeder->preference->name}}</td>
                        <td>{{$feeder->component->product_number}}</td>
                        <td>
                            <button>edit</button> 
                            <button>Delete</button>   
                        </td>
                    </tr> 
                @endforeach                                                                                                     
            </tbody>
        </table>
    @endif
@endfor