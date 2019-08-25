<?php
namespace App\Traits;
/**
 * @Author: anwar
 * @Date:   2017-11-21 00:10:00
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-21 11:13:23
 */
use App\package;
use App\Traits\CompanyTrait;

trait CompanypermissionTrait {
    use CompanyTrait;

    private $compid;

    public function companypermission() {

        $this->compid = $this->companyid();

        $query = package::whereCompany_id($this->compid)->first();

        $expireddate = strtotime($query->end_date);

        if ($expireddate < strtotime(date("Y-m-d"))) {
            # code...

            return false;
        }


        return $query;


    }

    public function company_has_package(): bool{
        $package = $this->companypermission();

        if ($package) {
            return true;
        }
        return false;
    }

    public function company_has_permission($module): bool {
        if ($this->company_has_package()) {
            # code...
            $package = $this->company_has_package();

            if ($package->max_branch) {
                # code...
            }
        }
        return false;
    }

    public function crosslimit($string): bool {
        //$this->comid = $this->companyid();
        $model = strtoupper($string);

        $this->comid = $this->companyid();

        $companyallpermission = $this->companypermission();
//        return $companyallpermission;
        if (!$companyallpermission) {
            return false;
        }

        $totalemployer = \App\User::whereCompany_id($this->comid)->role('Employee')->count();

        switch ($model) {
            case 'EMPLOYEE':
                if ($companyallpermission->max_emp <= $totalemployer) {
                    return false;
                }
                return true;
                break;

            case 'SCHEMA':
                if ($companyallpermission->has_schema == 0) {

                    return false;
                }
                return true;
                break;
            case 'SCHEDULE':
                if ($companyallpermission->has_schema == 0) {

                    return false;
                }
                return true;
                break;

            case 'STAMPLING':
                if ($companyallpermission->has_stampling == 0) {

                    return false;
                }
                return true;
                break;

            case 'ACTIVITY':

                if ($companyallpermission->has_activity == 0) {
                    return false;
                }
                return true;
                break;

            case 'SMS':
                if ($companyallpermission->has_sms == 0) {
                    return false;
                }
                return true;
                break;

            case 'BANKID':
                if ($companyallpermission->has_bankid == 0) {
                    return false;
                }
                return true;
                break;
            case 'OTP':
                if ($companyallpermission->has_otp == 0) {
                    return false;
                }
                return true;
                break;

            case 'BACKUP':
                if ($companyallpermission->has_backup == 0) {
                    return false;
                }
                return true;
                break;

            case 'QUALITY':
                if ($companyallpermission->has_quality == 0) {
                    return false;
                }
                return true;
                break;

            default:
                return true;
                break;
        }

    }
}
