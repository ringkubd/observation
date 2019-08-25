<?php
namespace App\Http\Controllers\shcedule\traits;

use Auth;

trait UserTrait
{
   public function user_id()
   {
       if(Auth::guard('owner')->check())
       {
           return Auth::guard('owner')->user()->company_id;
       }else{
           return Auth::user()->id;
       }
   }
}