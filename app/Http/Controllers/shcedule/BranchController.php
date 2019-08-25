<?php

namespace App\Http\Controllers\shcedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\branch;
use App\traits\CompanyTrait;
use Auth;

class BranchController extends Controller
{
    use CompanyTrait;
    
    // public function getallbranch()
    // {
    //     if(Auth::guard('owner')->check())
    //     {
    //         $allbranch = branch::whereCompany_id($this->companyid())->get();
    //         return $allbranch;
    //     }
        
    // }
    
    
}
