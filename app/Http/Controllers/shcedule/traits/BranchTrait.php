<?php
namespace App\Http\Controllers\shcedule\traits;
use App\Branch;
use Auth;
use Cache;

trait BranchTrait {
    public $sc_user_branch;
    public function getallbranch_for_shedule() {

        return  Auth::user()->branch->toArray();

        $allbranch = Branch::whereIn('id', $userbranch)->whereCompany_id($this->companyid())->where('isdelete',0)->select('id', 'branch_name')->get()->toArray();

        return $allbranch;
    }


}
