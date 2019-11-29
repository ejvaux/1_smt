<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>LINE</th>
                    <th>MODEL</th>
                </tr>
            </thead>
            <tbody>
                @isset($lines)
                    @if (count($lines) > 0)
                        @foreach ($lines as $line)
                            <tr>
                                <th class="text-center">
                                    {{$line->name}}
                                </th>
                                <td>
                                    <select class="sel" name="line_id_{{$line->id}}" id="line_id_{{$line->id}}">
                                        <option value="0">NONE</option>
                                        @foreach ($mods as $model)                                            
                                            <option value="{{$model->id}}"
                                                @foreach ($model->lines as $lin)
                                                    @if ($lin == $line->id)
                                                        selected
                                                    @endif
                                                @endforeach                                                    
                                            >{{$model->program_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach                        
                    @else
                        <tr>
                            <th>
                                <h3>NO DATA TO DISPLAY</h3>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th>
                            <h3>NO DATA TO DISPLAY</h3>
                        </th>
                    </tr>
                @endisset 
            </tbody>
        </table>
    </div>
</div>