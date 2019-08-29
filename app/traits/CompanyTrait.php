<?php

/**
 * @Author: anwar
 * @Date:   2017-10-26 15:05:05
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-19 12:43:49
 */
namespace App\Traits;
use Auth;
use App\Company;
/**
*
 * all information about a compnay 
 *
 */

trait CompanyTrait
{
    /**
     * return compnay id
     */
    public function companyid()
    {
        if (Auth::check()) 
    	{
        	return Auth::user()->company_id;

        }
    }

    /*
    *
    *
    *return package information 
    *
    *
    */

  
}
