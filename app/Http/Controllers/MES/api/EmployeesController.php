<?php

namespace App\Http\Controllers\MES\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MES\model\Employee;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;

class EmployeesController extends Controller
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
        $a =  new Employee;
        $a->fname = $request->input('fname');
        $a->lname = $request->input('lname');
        if($request->input('repair') != null){
            $a->repair = 1;
        }
        else{
            $a->repair = 0;
        }        
        $a->pin = 0;
        if($a->save()){
            $p = $a->id;
            $a->pin = sprintf("%u", crc32($p));
            if($a->save()){
                return redirect()->back()->with('success','Employee Added Successfully.');
            }
            else{
                return redirect()->back()->with('error','Saving Employee Details Failed.');
            }
        }
        else{
            return redirect()->back()->with('error','Saving Employee Details Failed.');
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
        $x = Employee::find($id);

        if($request->input('fname') != ""){ $x->fname = $request->input('fname');}
        if($request->input('lname') != ""){ $x->lname = $request->input('lname');}
        if($request->input('repair') != null){
            $x->repair = 1;
        }
        else{
            $x->repair = 0;
        }
        /* if($request->input('repair') != ""){ $x->repair = $request->input('repair');} */

        if($x->save()){
            return redirect()->back()->with('success','Employee Details Updated Successfully.');
        }
        else{
            return redirect()->back()->with('error','Update Failed.');
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
        //
    }

    public function exportemployee(Request $request)
    {
        $employees = $request->input('employees');
        $filename = 'smt_employees_'. Date('Y-m-d_his');
        
        return Excel::download(new EmployeeExport(
            $employees
        ), $filename.'.xlsx');

        /* $employees = $request->input('employees');
        return $employees; */
    }
}
