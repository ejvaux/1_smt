<div class="tab-content">
@for ($i = 1; $i <= \App\Http\Controllers\MES\model\MachineType::where('id',$machid)->pluck('table_count')->first(); $i++)
    @if ($i == 1)
        <div class="tab-pane active" id="tab{{$i}}">
    @else
        <div class="tab-pane" id="tab{{$i}}">
    @endif
    {{-- @if (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('machine_type_id',$machid)->where('line_id',$lin)->where('table_id',$i)->count()) --}}
        <div class="row">
            <div class="col-md">
                {{-- <span class='font-weight-bold text-muted'>Table {{$i}}</span> --}}
            {{-- TOOLBAR --}}
                <div id="fl_toolbar_{{$i}}" class='mb-2'>
                    <button class='addCmp'  style='font-size:.8rem' title="Add Component"
                        data-model='{{$model->id}}'
                        data-mach='{{$machid}}'
                        data-line='{{$lin}}'
                        data-table='{{$i}}'
                    ><i class="fas fa-plus text-success"></i> Component</button>
                    <button class='label_mounter' id='label_mounter_{{$i}}' data-id='{{$i}}' style='font-size:.8rem' title="Delete Feeder and its components."><i class="fas fa-minus text-danger"></i> Feeder</button>
                    <button class='change_mounter_button' id='change_mounter_button_{{$i}}' data-id='{{$i}}' style='font-size:.8rem;' title="Change Feeder into another Feeder"><i class="fas fa-exchange-alt"></i> Change Feeder</button>
                    <button class='transfer_mounter_button' id='transfer_mounter_button_{{$i}}' data-id='{{$i}}' style='font-size:.8rem;' title="Transfer Feeder into another table"><i class="fas fa-long-arrow-alt-right"></i><i class="fas fa-table"></i> Transfer Feeder</button>
                </div>
            {{-- FORMS --}}
                <div id="fl_toolbar_inputs" class='mb-2'>
                    {{-- Deleting mounter --}}
                        <div id="list_mounter_inputs_{{$i}}" style='display:none;'>
                            <select id="list_mounter_{{$i}}" class="list_mounter" placeholder="" required>
                                    <option value="">- Please select -</option>
                                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->groupBy('mounter_id')->get() as $mntr)
                                    <option value="{{$mntr->mounter_id}}" >{{$mntr->mounter->code}}</option>
                                @endforeach
                            </select>
                            <button class='del_mounter form_submit_button' id='del_mounter_{{$i}}' 
                                data-model='{{$model->id}}'
                                data-mach='{{$machid}}'
                                data-line='{{$lin}}'
                                data-table='{{$i}}'
                            style='color:green;font-size:.8rem;'><i class="far fa-trash-alt"></i> DELETE</button>                                
                            <button class='cancel_del_mounter' id='cancel_del_mounter_{{$i}}' data-id='{{$i}}' style='color:red;font-size:.8rem'><i class="fas fa-ban"></i> CANCEL</button>
                        </div>
                    {{-- changing mounter --}}
                        <div id="change_mounter_inputs_{{$i}}"  style='display:none;'>
                            <select id="change_list_mounterfrom_{{$i}}" class="change_list_mounterfrom" placeholder="" required>
                                    <option value="">From Feeder</option>
                                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->groupBy('mounter_id')->get() as $mntr)
                                    <option value="{{$mntr->mounter_id}}" >{{$mntr->mounter->code}}</option>
                                @endforeach
                            </select>
                            <select id="change_list_mounterto_{{$i}}" class="change_list_mounterto sel2" placeholder="" required>
                                    <option value="">To Feeder</option>
                                @foreach ($mounters as $mntr)
                                    <option value="{{$mntr->id}}" >{{$mntr->code}}</option>
                                @endforeach
                            </select>
                            <button class='change_mounter form_submit_button' id='change_mounter_{{$i}}' 
                                data-model='{{$model->id}}'
                                data-line='{{$lin}}'
                                data-mach='{{$machid}}'
                                data-table='{{$i}}'
                            style='color:green;font-size:.8rem'><i class="fas fa-exchange-alt"></i> CHANGE</button>                                
                            <button class='cancel_change_mounter' id='cancel_change_mounter_{{$i}}' data-id='{{$i}}' style='color:red;font-size:.8rem'><i class="fas fa-ban"></i> CANCEL</button>
                        </div>
                    {{-- transferring mounter --}}
                        <div id="transfer_mounter_inputs_{{$i}}" style='display:none;'>
                            <select id="transfer_list_mounter_{{$i}}" class="transfer_list_mounter" placeholder="" required>
                                    <option value="">Select Feeder</option>
                                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->groupBy('mounter_id')->get() as $mntr)
                                    <option value="{{$mntr->mounter_id}}" >{{$mntr->mounter->code}}</option>
                                @endforeach
                            </select>
                            <select id="transfer_list_table_{{$i}}" class="transfer_list_table" placeholder="" required>
                                    <option value="">Select Table</option>
                                    @for ($a = 1; $a <= \App\Http\Controllers\MES\model\MachineType::where('id',$machid)->pluck('table_count')->first(); $a++)
                                    <option value="{{$a}}">Table {{$a}}</option>
                                    @endfor
                            </select>
                            <button class='transfer_mounter form_submit_button' id='transfer_mounter_{{$i}}' 
                                data-model='{{$model->id}}'
                                data-line='{{$lin}}'
                                data-mach='{{$machid}}'
                                data-table='{{$i}}'
                            style='color:green;font-size:.8rem;'><i class="fas fa-long-arrow-alt-right"></i><i class="fas fa-table"></i> TRANSFER</button>                                
                            <button class='cancel_transfer_mounter' id='cancel_transfer_mounter_{{$i}}' data-id='{{$i}}' style='color:red;font-size:.8rem;'><i class="fas fa-ban"></i> CANCEL</button>
                        </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class='text-muted' scope="col">Feeder</th>
                    <th class='text-muted' scope="col">Position</th>
                    <th class='text-muted' scope="col">Usage</th>
                    <th class='text-muted' scope="col">Preference</th>
                    <th class='text-muted' scope="col">Product Number</th>
                    <th class='text-muted' scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->orderBy('mounter_id')->orderBy('pos_id')->orderBy('order_id')->get() as $feeder)
                    <tr>
                        @php
                            if($tb != $i){
                                $mt = 0;
                                $ps = 0;
                                $us = 0;
                                $tb = $i;
                            }
                            if($mt != $feeder->mounter_id && $ps == $feeder->pos_id){
                                $ps = 0;
                            }
                            if ($mt != $feeder->mounter_id) {
                                echo "<td rowspan='".\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->where('mounter_id',$feeder->mounter_id)->count()."'>".$feeder->mounter->code."</td>";
                                $mt = $feeder->mounter_id;
                            }
                            if($ps != $feeder->pos_id){
                                $rs = \App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->where('mounter_id',$feeder->mounter_id)->where('pos_id',$feeder->pos_id)->count();
                                echo "<td rowspan='".$rs."'>".$feeder->position->name."</td>";
                                echo "<td rowspan='".$rs."'><div class='row'><div class='col-md'>".$feeder->usage."</div><div class='col-md'><button class='cmp_usage '
                                data-model='{$model->id}'
                                data-line_id='{$lin}'
                                data-mach='{$machid}'
                                data-table='{$i}'
                                data-mounter_id='{$feeder->mounter_id}'
                                data-pos_id='{$feeder->pos_id}'
                                data-usage='{$feeder->usage}'
                                >Edit Usage</button></div></div></td>";
                                $ps = $feeder->pos_id;
                            }
                            /* if($us != $feeder->pos_id){
                                echo "<td rowspan='".\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->where('line_id',$lin)->where('machine_type_id',$machid)->where('table_id',$i)->where('mounter_id',$feeder->mounter_id)->where('pos_id',$feeder->pos_id)->count()."'>".$feeder->position->name."</td>";
                                $ps = $feeder->pos_id;
                            } */
                        @endphp
                        {{-- <td>0</td> --}}
                        <td>{{$feeder->preference->name}}</td>
                        <td>{{$feeder->component->product_number}}</td>
                        <td>                            
                            <button class='cmp_edit'
                                data-id='{{$feeder->id}}'
                                data-model='{{$model->id}}'
                                data-mach='{{$machid}}'
                                data-table='{{$i}}'
                                data-mount='{{$feeder->mounter_id}}'
                                data-pos='{{$feeder->pos_id}}'
                                data-pref='{{$feeder->order_id}}'
                                data-cmp='{{$feeder->component_id}}'
                            >Edit</button>                            
                            <button class='cmp_delete form_submit_button' type='button' data-id='{{$feeder->id}}'>Delete</button>                            
                            {{-- @if ($feeder->order_id == 1)
                                <button class='cmp_usage'
                                data-model='{{$model->id}}'
                                data-line_id='{{$lin}}'
                                data-mach='{{$machid}}'
                                data-table='{{$i}}'
                                data-mounter_id='{{$feeder->mounter_id}}'
                                data-pos_id='{{$feeder->pos_id}}'
                                data-usage='{{$feeder->usage}}'
                                >Update Usage</button>
                            @endif  --}}                           
                        </td>
                    </tr>                    
                @endforeach                                                                                                     
            </td>
        </table>
        </div>
    {{-- @endif --}}
@endfor
</div>