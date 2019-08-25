<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(){
        $userBranch = where_branch_id();
        $data = User::whereHas("branch",function ($q)use($userBranch){
            $q->{$userBranch[0]}("id",$userBranch[1]);
        })->with('branch')->get();
        $model = new User();
        $branch = $this->makeBranchOption();
        return view("employee.index",compact('model','branch','data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("branch.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqData = $request->all();
        $branch = $reqData["branch_id"];
        unset($reqData["branch_id"]);
        $reqData["password"] =  Hash::make($reqData["password"]);
        $user =  User::create($reqData);
        $user->branch()->attach($branch);
        $user->sendEmailVerificationNotification();
        return back();
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
        $model = User::whereId($id)->with('branch')->first();
        $selected = $model->branch->pluck("branch_name","id")->toArray();
        $branch = $this->makeBranchOption($selected);
        return view("employee.edit",compact('model','branch'));
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
        $reqData = $request->all();
        if ($reqData["password"] != ""){
            $reqData["password"] = Hash::make($reqData["password"]);
        }else{
            unset($reqData["password"]);
        }
        $checkbox = ["code_converter" => "0", "employee_access" => "0", "branch_access" => "0", "client_access" => "0", "observer_man_access" => "0"];
        $reqData = array_merge($checkbox,$reqData);
        $branch = $reqData["branch_id"];
        unset($reqData["branch_id"]);
        $abc = User::find($id);
        $abc->update($reqData);
        $abc->branch()->sync($branch);
        $this->deleteCache();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        $this->deleteCache();
        return back();
    }

    private function makeBranchOption($selected = []){
        $branches =  Branch::where("isdelete",0)->get();
        $option = null;
        foreach ($branches as $b){
            $select = array_key_exists($b->id,$selected) ? "selected" : null;
            $option.= "<option $select value='{$b->id}'>{$b->branch_name}</option>";
        }
        return $option;
    }

    /**
     *
     */

    public function deleteCache(){
        $br = new Employee();
        $key = env("APP_NAME")."_".$br->getTable();
        //Redis::del($key);
    }
}
