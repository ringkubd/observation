<?php

/**
 * @Author: anwar
 * @Date:   2017-10-23 16:46:25
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-10-28 11:50:25
 */
namespace App\traits;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;

trait UserTrait{

	/*
    //user edit form info return by ajax
    */
public function hoops($a){
    return $a;
}
    public function userInfoEditData(Request $request)
    {

        if ($request->ajax()) 
        {
            if (Auth::check()) {
                $roles     = Role::whereNotIn('name',['Admin','Owner'])->get()->toArray();
            }elseif (Auth::guard('owner')->check() || Auth::user()->hasRole('Owner')) {
                $roles     = Role::all()->toArray();
            }
        	

            $userinf[]  = User::whereId($request->userid)->get()->toArray();
            

            array_push($userinf, $roles);

            return response($userinf);
        }else{
            return back()->with('msg','You dont have access on this page..');
        }

    }
public function is_company(){
     if (Auth::check()) 
                    {
                        return false;

                    }else
                    {
                        return true;
                    }
}

    public function userRoleUpdate(Request $request)
    {
    	$userid = $request->userid;
    	$user = User::findOrFail($userid); 
        $this->validate($request, [
            'full_name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$userid,
        ]);

        //$user->password   = bcrypt($request->password);
        
        $user->full_name  = $request->full_name;
        $user->email      = $request->email;

        // $input = $request->except('roles');->fill($input)

        if ($request->assign_role <> '') {
            $user->roles()->sync($request->assign_role);        
        }        
        else {
            $user->roles()->detach(); 
        }
        return redirect()->route('users.index')->with('success',
             'User successfully updated.');
    }


    // retrun user name user id ,user mail , user contact number , user adress

    public function user_data($user_data = array())
    {
         $userifo = $this->userdataprivate();
        

        if (!is_array($user_data)) 
        {

            switch ($user_data) {
                case 'full_name':
                    if (Auth::check()) 
                    {
                        return $userifo->full_name;

                    }else
                    {
                        return $userifo->company_name;
                    }
                    break;
                     case 'user_image':
                    if (Auth::check()) 
                    {
                        return $userifo->employee_image;

                    }else
                    {
                        return $userifo->company_name;
                    }
                    break;
                   case 'id':
                     if (Auth::check()) 
                    {
                        return $userifo->id;

                    }else
                    {
                        return $userifo->company_id;
                    }
                 
                    break;
                case 'email':
                     return $userifo->email;
                    break;
                case 'mobile':
                    return $userifo->mobile;
                    break;

                case 'personal_number':
                    return $userifo->personal_number;
                    break;
                
                default:
                    // code...
                    break;
            }
            
        }else{
            $arryuserinfo = [];

            foreach ($user_data as $value) 
            {
                array_push($arryuserinfo, $userifo->$value);
                
            }
            return $arryuserinfo;
        }
    }


    private function userdataprivate()
    {
        if (Auth::check()) 
        {
            return Auth::user();

        }elseif(Auth::guard('owner')->check())
        {
            return Auth::guard('owner')->user();
        }
    }
// public function get_assign_task(){
//     if(Auth::id!=null){
//         return \App\task_assign::where('user_id',Auth::id)->orderBy('id', 'desc')->get();
//     }
//     else{
//         return 'false';
//     }
// }

}