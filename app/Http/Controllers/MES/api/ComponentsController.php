<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Component;

class ComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_number' => 'string|required',
            'authorized_vendor' => 'string|required',
            'vendor_pn' => 'string|required',
        ]);

        $c = new Component;
        $c->product_number = $request->input('product_number');
        $c->authorized_vendor = $request->input('authorized_vendor');
        $c->vendor_pn = $request->input('vendor_pn');
        $c->updated_by = $request->input('user_id');

        if($c->save()){
            return redirect()->back()->with('success','Component Saved Successfully.');
            /* return 'Data Saved Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Saving Failed.');
            /* return 'Saving Failed.'; */
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_number' => 'string|required',
            'authorized_vendor' => 'string|required',
            'vendor_pn' => 'string|required',
        ]);
        
        $c = Component::find($id);

        if($request->input('product_number') != ""){ $c->product_number = $request->input('product_number');}
        if($request->input('authorized_vendor') != ""){ $c->authorized_vendor = $request->input('authorized_vendor');}
        if($request->input('vendor_pn') != ""){ $c->vendor_pn = $request->input('vendor_pn');}
        if($request->input('user_id') != ""){ $c->updated_by = $request->input('user_id');}

        if($c->save()){
            return redirect()->back()->with('success','Component Updated Successfully.');
            /* return 'Component Updated Successfully.'; */
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
            /* return 'Update Failed.'; */
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Component::where('id',$id)->delete()) {
            return redirect()->back()->with('success','Component Deleted Successfully.');
        } 
        else {
            return redirect()->back()->with('error','Update Failed.');
        }        
    }
}
