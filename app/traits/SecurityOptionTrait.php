<?php
namespace App\Traits;

/**
 * @Author: anwar
 * @Date:   2017-11-14 09:30:03
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-22 01:32:29
 */
/**
 * Dependency class include
 */
 
 use App\Traits\CompanyTrait;
 use App\Compnay;
 use App\SecurityOption;
 
 /*
 *Dependency class End
 */
 
trait SecurityOptionTrait{
    use CompanyTrait;
    
    //const BROWSERAUTH = 1;
    
    public function isBrowserAuth()
    {
        $compnay =  SecurityOption::whereCompany_id($this->companyid())->whereOption('BROWSERAUTH')->first();
        if($compnay)
        {
            if($compnay->value == "1")
            {
                return true;
            }else{
                return false;
            }
        }else{
             SecurityOption::create(['company_id'=>$this->companyid(),'option'=>'BROWSERAUTH','value'=>'1']);
             return false;
        }
    }
}