<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists('coid')) {
	function coid() {
		if (Auth::check()) {
			return Auth::user()->company_id;

		} elseif (Auth::guard('owner')->check()) {
			return Auth::guard('owner')->user()->company_id;
		} else {
			abort(419, $message = 'Sorry! You dont have right to access!');
		}
	}
}

if (!function_exists('orgtype')) {
	# code...
	function orgtype() {
		if (Auth::check()) {
			return $companyinfo = Auth::user()->company->organization_type_id;
			//return $companyinfo->organization_type_id;
		} elseif (Auth::guard('owner')->check()) {
			return Auth::guard('owner')->user()->organization_type_id;
		} else {
			abort(419, $message = 'Sorry! You dont have right to access!');
		}
	}
}

if (!function_exists('companyContact')) {
    function companyContact($option = "mobile") {
        if (Auth::check()) {
            $companyid = Auth::user()->company_id;
            $companyInfo = \App\Company::where("company_id",$companyid)->first();
            return $companyInfo->{$option};

        } elseif (Auth::guard('owner')->check()) {
            return Auth::guard('owner')->user()->{$option};
        } else {
            abort(419, $message = 'Sorry! You dont have right to access!');
        }
    }
}