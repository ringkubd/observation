<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 1/21/19
 * Time: 10:51 PM
 */

if (!function_exists('branchid')){
    function branchid() {
        if (\Auth::check()) {
            return explode(',', \Auth::user()->branch_id);
        } elseif (\Auth::guard('owner')->check()) {
            return $defaultbranch = \App\branch::whereIsdelete("0")->whereCompany_id(coid())->pluck('id');
        }
    }
}


