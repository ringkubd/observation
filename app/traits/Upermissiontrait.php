<?php
namespace App\traits;
use App\User;
use Cache;
/**
 * @Author: anwar
 * @Date:   2017-12-18 14:46:22
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-12-20 11:31:50
 */

trait Upermissiontrait {

    protected $userid;
    protected function hassManyPermission() {


    }
    /**
     * summary
     */
    public function uHasPermission($permission = array()):bool {
        if ($permission == 'upgrade_service'){
            return true;
        }
        $abc = "CompanyPackage.$permission";
        $module = config($abc);

        if (\Auth::guard('owner')->check()) {
            //return $permission;

            if ($permission == 'all' || $this->crosslimit($module)) {
                return true;
            }
            return false;
        }
        if (\Auth::check()) {
            $this->userid = \Auth::user()->id;
            $userpermission = User::find($this->userid)->upermission;
        }

        $user = new User();
        //$userpermission = $this->hassManyPermission();
        $permission_name = array();
        if (is_object($userpermission) && !is_null($userpermission)) {
            foreach ($userpermission as $value) {
                array_push($permission_name, $value->permission_name);
            }
        }

        if (is_array($permission)) {
            $matched = array_intersect($permission_name, $permission);
            if (!is_null($matched) && count($matched) > 0 && $this->crosslimit($module)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (in_array($permission, $permission_name)  && $this->crosslimit($module)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
