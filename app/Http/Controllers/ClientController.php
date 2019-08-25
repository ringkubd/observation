<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Client();
        $userBranch = where_branch_id();
        $data = Client::with("branch")->{$userBranch[0]}("branch_id",$userBranch[1])->get();
        $branchOption = $this->makeBranchOption();
        return view("client.index",compact('model','data','branchOption'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            "client_name"=>"required",
            "branch_id"=>"required",
        ]);
        $rqstData = $request->all();
        unset($rqstData['_token']);
        $cln = Client::insert($rqstData);
        if ($cln){
            $this->deleteCache();
            return back();
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
        $model = Client::find($id);
        $branch = $this->makeBranchOption($model->branch_id);
        return view("client.edit",compact('branch','model'));
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
        $cl = Client::find($id)->update($request->all());
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
        $dlt = Client::find($id)->delete();
        $this->deleteCache();
        return Client::find($id);
    }

    private function makeBranchOption($selected = null){
        $parentBranch = new Branch();
        $parentBranch->setParam("where isdelete = 0");
        $branches = $parentBranch->getFromRedis();
        $option = null;
        foreach ($branches as $b){
            $select = $selected == $b->id ? "selected" : null;
            $option.= "<option $select value='{$b->id}'>{$b->branch_name}</option>";
        }
        return $option;
    }

    /**
     *
     */

    public function deleteCache(){
        $br = new Client();
        $key = env("APP_NAME")."_".$br->getTable();
        Redis::del($key);
    }
}
