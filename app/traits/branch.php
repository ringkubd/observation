<?php

/**
 * @Author: anwar
 * @Date:   2017-10-22 12:59:54
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-21 19:06:09
 */
namespace App\Traits;
use App\branch as bb;
use App\Traits\CompanyTrait;
use App\User;
use Auth;
use Illuminate\Http\Request;

trait branch {

    use CompanyTrait;

    public function __getSubBranch(Request $req) {
        $company_id = $this->companyid();

        if ($req->ajax()) {
            $parent_branch_id = $req->parent_id;
            $subbranch = bb::whereIsdelete("0")->whereCompany_id($company_id)->whereParent_branch($parent_branch_id)->get()->toArray();

            return $subbranch;
        }
        return false;
    }

    public function getSubBranch(Request $req) {
        \Cache::forget('index_today_schedule');

        $company_id = $this->companyid();

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

            $subbranchs = bb::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (Auth::check()) {
                $branchstring = explode(',', Auth::user()->branch_id);
                $subbranchs = bb::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            }

            session()->put('sub_branch', $subbranchs);

            if (session()->get('subbranch') != $req->subbranch) {

                $grand_child = bb::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();

                if (Auth::check()) {
                    $branchstring = explode(',', Auth::user()->branch_id);
                    $grand_child = bb::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
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

                $grand_child = bb::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
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

            $subbranchs = bb::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (count($subbranchs) > 0) {
                $grand_child = bb::whereIsdelete("0")->whereParent_branch($req->subbranch)->pluck('branch_name', 'id')->toarray();
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

            $subbranchs = bb::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            $subbranchs = bb::whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
            if (Auth::check()) {
                $branchstring = explode(',', Auth::user()->branch_id);
                $subbranchs = bb::whereIn('id', $branchstring)->whereIsdelete("0")->whereParent_branch($req->branch_id)->pluck('branch_name', 'id')->toarray();
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

    public function getAllBranch() {
        // get all branch
        $branch = bb::whereIsdelete("0")->whereCompany_id($this->companyid())->get();
        return $branch;
    }

    // for header

    public function __getAllBranch() {
        if (Auth::guard('owner')->check()) {
            $branch = bb::whereParent_branch("0")->whereIsdelete("0")->whereCompany_id($this->companyid())->get();
            return $branch;
        } elseif (Auth::check()) {
            $branchArray = explode(",", Auth::user()->branch_id);
            $branch = bb::whereParent_branch("0")->whereIsdelete("0")->whereCompany_id($this->companyid())->whereIn('id', $branchArray)->get();
            if (count($branch) == 0) {

                $branch = bb::where('Parent_branch', '!=', null)->whereIs_grand_child('0')->whereIsdelete("0")->whereCompany_id($this->companyid())->whereIn('id', $branchArray)->get();
                if (count($branch) == 0) {

                    $branch = bb::where('Parent_branch', '!=', null)->whereIs_grand_child('1')->whereIsdelete("0")->whereCompany_id($this->companyid())->whereIn('id', $branchArray)->get();
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

        $defaultbranch = bb::whereIsdelete("0")->whereCompany_id($this->companyid())->first();

        if (Auth::check()) {
            $empdefbranch = explode(',', Auth::user()->branch_id);

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

        } elseif (Auth::guard('owner')->check()) {
            if (session()->has('branch') && session()->get('parent_branhc') != 'all') {
                $value = session('branch');
                return $value;

            } elseif (is_array($defaultbranch) && count($defaultbranch) == 0) {
                return "0";
            } elseif (isset($defaultbranch)) {

                return $defaultbranch->id;
            } else {
                return '0';
            }
        }
    }

    //all sub branch for a organization
    public function subbrachforaorganization() {
        $company_id = $this->companyid();

        $subbranch = bb::whereIsdelete("0")->whereCompany_id($company_id)->where('parent_branch', '!=', 0)->get()->toArray();

        return $subbranch;
    }

    /*
        *
        * branch array for multiple branch employee
    */
    public function allBranchForEmploye() {
        $company_id = $this->companyid();
        if (Auth::check()) {
            $branch = Auth::user()->branch_id;
            return $branchArray = explode(',', $branch);
        } elseif (Auth::guard('owner')->check()) {
            return $branch = bb::whereCompany_id($company_id)->get()->toArray();
        }
    }
    public function allBranchForEmploye_insert() {
        $company_id = $this->companyid();
        if (Auth::check()) {
            $branch = Auth::user()->branch_id;
            return $branchArray = explode(',', $branch);
        } elseif (Auth::guard('owner')->check()) {
            $branch = bb::whereCompany_id($company_id)->get();
            $br=[];
            foreach($branch as $b)
            {
                array_push($br, $b->id);
            }
            return $br;
        }
        return false;
    }

    public function get_branch_name() {
        $all_branch = bb::where('isdelete','0')->get();

        $branch_name = [];
        foreach ($all_branch as $b) {
            $branch_name[$b->id] = $b->branch_name;
        }
        return $branch_name;
    }

    /*backup
        /*all branch*//*
	public function wherebranchid()
	{
	$parent_branch = session()->get('parent_branch');

	if($parent_branch  == 'all')
	{
	return ['!=',''];
	}elseif($parent_branch == "")
	{
	return ['!=',''];
	}
	else{
	return ['=',$this->branch_id()];
	}
	}*/

    /*all branch*/
    public function wherebranchid() {
        $parent_branch = session()->get('parent_branch');

        if ($parent_branch == 'all') {
            if (!Auth::guard('owner')->check()) {
                $employeebranch = User::select('branch_id')->whereId(Auth::user()->id)->whereCompany_id($this->companyid())->first();

                $eb = explode(',', $employeebranch->branch_id);
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

    /*
        *client branch id
    */

    public function client_branch_id($clientid) {
        $clinetifo = \App\client::find($clientid);
        return $clinetifo->branch_id;
    }


    public function allBranchIdofLoggedinUser() {
        $company_id = $this->companyid();
        $branch= $this->wherebranchid();
        if(empty($branch[1]))
        {
            return  bb::whereCompany_id($company_id)->pluck('id')->implode(',');

        }
        else{
            return implode(',',$branch[1]);
        }


    }



}
