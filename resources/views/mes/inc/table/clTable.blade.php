<div class='row mb-1'>
    <div class='col-lg table-responsive-lg'>
        <table class="table">
            <thead class="thead-light">
                <tr class="labelfontbold">
                    <th>#</th>
                    <th>@sortablelink('product_number','Product Number')</th>                    
                    <th>@sortablelink('authorized_vendor','Authorized Vendor')</th>
                    <th>@sortablelink('vendor_pn','Vendor P/N')</th>
                    <th>@sortablelink('updated_by','Updated by')</th>
                    <th>@sortablelink('updated_at','Updated at')</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($components)>0)
                    @foreach($components as $component)
                        <tr>
                            <th>{{ $loop->iteration + (($components->currentPage() - 1) * 100) }}</th>
                            <th>{{$component->product_number}}</th>
                            <th>{{$component->authorized_vendor}}</th>
                            <th>{{$component->vendor_pn}}</th>
                            <th>
                                @if ($component->updated_by)
                                    {{$component->updatedBy->USER_NAME}}
                                @else
                                    Error: No update user.
                                @endif                                
                            </th>
                            <th>{{$component->updated_at}}</th>
                            <th>
                                <div class="btn-group" role="group">
                                    <button class='btn btn-outline-info editComponent' 
                                        data-id="{{$component->id}}"
                                        data-pn="{{$component->product_number}}"
                                        data-av="{{$component->authorized_vendor}}"
                                        data-vpn="{{$component->vendor_pn}}"
                                    title="Edit Component"><i class="far fa-edit"></i></button>
                                    <button type='button' class='btn btn-outline-danger deleteComponent' data-id="{{$component->id}}" type='button' title="Delete Component"><i class="far fa-trash-alt"></i></button>                                    
                                </div>
                                <form id='del_comp_form_{{$component->id}}' action="{{url('components/'.$component->id)}}" method="post">
                                    @method('DELETE')                                        
                                </form>                              
                            </th>
                        </tr>
                    @endforeach                
                @else
                <tr>
                    <td colspan="7">
                        <h4>No Components Found.</h4>
                    </td>
                </tr>                    
                @endif 
            </tbody>
        </table>
    </div>
</div>
<div class='row'>
    <div class='col-md'>
        {!! $components->appends(\Request::except('page'))->render() !!}
    </div>
</div>