<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    private $rediskeys = "";
    private $data;

    private $modelWithRedis;

    public function __construct()
    {
        $this->rediskeys = env("APP_NAME").'_branches';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentBranch = $this->makeParentBranchOption();
        $allbranch = Branch::active()->with('parent')->get();
        $model = new Branch();
        return view("branch.index",compact('parentBranch','allbranch','model'));
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
        $request->validate([
            "branch_name" => "required|string"
        ]);
        $isgrand = 0;
        if ($request->has("parent_branch") && $request->parent_branch != null) {
            $parentbranch = Branch::find($request->parent_branch);
            $isgrand = $parentbranch->parent_branch != 0 ? 1:0;
        }
        $requestData = $request->all();
        $requestData['is_grand_child'] = $isgrand;
        //return dump($requestData);
        unset($requestData["_token"]);

        $create = Branch::insert($requestData);
        if ($create){
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
        $model = Branch::whereId($id)->with('parent')->first();
        $parentBranch = $this->makeParentBranchOption($model->parent_branch);
        return view("branch.edit",compact('model','parentBranch'));
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
        $abc = Branch::find($id)->update($request->all());
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
        Branch::find($id)->delete();
        $this->deleteCache();
        return back();
    }

    private function makeParentBranchOption($selected = null){
        $parentBranch = new Branch();
        $parentBranch->setParam("where is_grand_child = 0",true);
        $branches = $parentBranch->getFromRedis();
        $option = null;

        foreach ($branches as $b){
            $select = $selected == $b->id ? "selected" : null;
            $option.= "<option $select value='{$b->id}'>{$b->branch_name}</option>";
        }
        return $option;


    }

    public function deleteCache(){
        $br = new Branch();
        $key = env("APP_NAME")."_".$br->getTable();
        Redis::del($key);
    }

    //
    public function __getSubBranch(Request $req) {
        $company_id = $this->companyid();

        if ($req->ajax()) {
            $parent_branch_id = $req->parent_id;
            $suBranchranch = Branch::whereIsdelete("0")->whereParent_branch($parent_branch_id)->get()->toArray();

            return $suBranchranch;
        }
        return false;
    }

    public function getAllBranch() {
        // get all branch
        $branch = Branch::whereIsdelete("0")->get();
        return $branch;
    }

    public function __getAllBranch() {
        if (Auth::check()) {
            $branchArray = Auth::user()->branch->pluck("id")->toArray();
            $branch = Branch::whereParent_branch("0")->whereIsdelete("0")->whereIn('id', $branchArray)->get();
            if (count($branch) == 0) {

                $branch = Branch::where('Parent_branch', '!=', null)->whereIs_grand_child('0')->whereIsdelete("0")->whereIn('id', $branchArray)->get();
                if (count($branch) == 0) {

                    $branch = Branch::where('Parent_branch', '!=', null)->whereIs_grand_child('1')->whereIsdelete("0")->whereIn('id', $branchArray)->get();
                }
            }

            return $branch;
        }
    }

    //Selected branch

    public function selected_branch() {

        if (!session()->has('branch')) {
            $req = new Request();
            if ($req->defaultbranch == "") {
                $parent_branch = session()->put('parent_branch', 'all');
            }

        }
    }

    //return branch id

    public function branch_id() {
        if (Auth::check()) {
            $empdefbranch = Auth::user()->branch->pluck("id")->toArray();

            if (session()->has('branch')) {

                $value = session('branch');
                return $value;

            } elseif (is_array($empdefbranch) && count($empdefbranch) == 0) {

                return "0";

            } elseif (!empty($empdefbranch)) {

                return $empdefbranch[0];

            } else {
                return '0';
            }

        }
    }

    public function getSubBranch(Request $req) {
        if ($req->branch_id != null && $req->subbranch != null && $req->sub_sub_branch != null) {
            session()->forget('branch');
            session()->forget('subbranch');
            session()->forget('parent_branch');

            session()->put('branch', $req->sub_sub_branch);

            session()->put('subbranch', $req->subbranch);
            if (session()->get('parent_branch') != $req->branch_id) {
                session()->forget('gc_branch');
            }

            session()->put('parent_branch', $req->branch_id);

            session()->forget('gc_branch');

            session()->forget('sub_branch');

            $subbranchs = Branch::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (Auth::check()) {
                $branchstring = Auth::user()->branch->pluck("id")->toArray();
                $subbranchs = Branch::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            }

            session()->put('sub_branch', $subbranchs);

            if (session()->get('subbranch') != $req->subbranch) {

                $grand_child = Branch::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();

                if (Auth::check()) {
                    $branchstring = Auth::user()->branch->pluck("id")->toArray();
                    $grand_child = Branch::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
                }

                if (count($grand_child) > 0) {
                    session()->put('gc_branch', $grand_child);
                }
            }

            if (count($subbranchs) > 0) {
                //return $req->all();
                //session()->put('branch',$req->sub_sub_branch);
                session()->forget('sub_branch');
                session()->put('sub_branch', $subbranchs);
                session()->forget('gc_branch');

            } else {
                session()->forget('sub_branch');
            }
            //return session()->get('gcbranch') .'-'. $req->sub_sub_branch;

            if (session()->get('gcbranch') != $req->sub_sub_branch) {

                $grand_child = Branch::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
                if (count($grand_child) > 0) {
                    session()->put('gc_branch', $grand_child);
                    session()->put('gcbranch', $req->sub_sub_branch);
                }
            }

            return back();

        } elseif ($req->branch_id != null && $req->subbranch != null && $req->sub_sub_branch == null) {
            session()->forget('branch');
            session()->forget('subbranch');
            session()->forget('parent_branch');
            session()->forget('gc_branch');
            session()->forget('gcbranch');

            session()->forget('sub_branch');

            $subbranchs = Branch::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (count($subbranchs) > 0) {
                $grand_child = Branch::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
                if (count($grand_child) > 0) {
                    session()->put('gc_branch', $grand_child);
                }

            }

            session()->put('parent_branch', $req->branch_id);

            if (session()->get('parent_branch') != $req->branch_id) {
                session()->forget('branch');
                session()->put('branch', $req->branch_id);

            } else {

                session()->forget('branch');

                session()->put('branch', $req->subbranch);

            }

            session()->put('sub_branch', $subbranchs);

            session()->put('subbranch', $req->subbranch);

            return back();

        } elseif ($req->branch_id != null && $req->subbranch == null && $req->sub_sub_branch == null) {

            session()->forget('branch');
            session()->forget('subbranch');
            session()->forget('parent_branch');
            session()->forget('gc_branch');
            session()->forget('gcbranch');

            session()->put('branch', $req->branch_id);
            session()->put('parent_branch', $req->branch_id);

            session()->forget('gc_branch');

            session()->forget('sub_branch');

            $subbranchs = Branch::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            $subbranchs = Branch::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (Auth::check()) {
                $branchstring = Auth::user()->branch->pluck("id")->toArray();
                $subbranchs = Branch::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            }
            if (count($subbranchs) > 0) {
                session()->put('sub_branch', $subbranchs);
            }

            return back();

        } elseif ($req->branch_id != null && $req->branch_id != "" && $req->subbranch == null && $req->sub_sub_branch != null) { //new change && $req->branch_id != ""
            session()->put('branch', $req->branch_id);

            session()->forget('gc_branch');
            if (session()->has('gc_branch')) {
                return session()->get('gc_branch');
            }
            //return session()->get('gc_branch');
            return back();
        } elseif ($req->branch_id == null) {
            session()->forget('subbranch');
            session()->forget('sub_branch');
            session()->forget('parent_branch');
            session()->forget('gc_branch');
            session()->forget('gcbranch');
            session()->put('parent_branch', 'all');
            return back();
        } else {
            return back();
        }

    }

    /*all branch*/
    public function wherebranchid() {
        $parent_branch = session()->get('parent_branch');

        if ($parent_branch == 'all') {
            if (!Auth::guard('owner')->check()) {
                $eb = auth()->user()->branch()->pluck("id")->toArray();
                return ['whereIn', $eb];
            }
            return ['whereNotIn', []];

        } elseif ($parent_branch == "") {
            return ['whereNotIn', []];
        } else {
            $barray = [$this->branch_id()];
            return ['whereIn', $barray];
        }
    }

}
