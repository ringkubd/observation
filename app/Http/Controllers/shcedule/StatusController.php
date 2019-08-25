<?php
namespace App\Http\Controllers\shcedule;
use App\Http\Controllers\Controller;

use App\Http\Controllers\shcedule\traits\UserTrait;
use App\Http\Controllers\shcedule\traits\BranchTrait;
use App\schedule\holyday;
use App\schedule\holydayasweekend;
use App\schedule\pass;
use App\schedule\shedulepass;
use App\schedule\weekend;
use App\schedule\manual_time_hour_compnay;
use App\Totalworkinghourrange;
use App\traits\CompanyTrait;


use App\User;
use Auth;
use Cache;

use Carbon\carbon;
use DateTime;
use Illuminate\Http\Request;
use Session;


class StatusController extends Controller {

	use  UserTrait,BranchTrait;



	public function __construct() {
		$this->middleware('has_permission');
		//$this->middleware('package:schema');

	}
public function set_branch(Request $request) {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		if (Session::has('schema_branch_id')) {
			Session::forget('schema_branch_id');

		}
		Session::put('schema_branch_id', $request->branch_id);
		return redirect()->back();

	}
	public function get_status(Request $request)
	{ 
		$now =Carbon::now('Europe/Bratislava');
		$current_year=$now->year;
		$current_month=$now->month;
		//return $current_month;
		$holyday_as_weekend=new holydayasweekend();
		$HolydayasWeekend=$holyday_as_weekend->retrive_holydayas_weekend($this->companyid(),$this->wherebranchid());
		$holyday=new holyday();
		$holyday_weekend=$holyday->holy_weekend($this->companyid(),$this->wherebranchid());
		$weekend=new	weekend();
		$weekend_period=$weekend->retrive_weekend($this->companyid(),$this->wherebranchid());

		$manul_time=new manual_time_hour_compnay();

		$manaul_working=$manul_time->GetManualTimeShiftinfo($this->companyid());
		$start_date=($request->year ?? $current_year).'-'.($request->month ?? $current_month).'-01';
		
		$enddate_date=($request->year ?? $current_year).'-'.($request->month ?? $current_month).'-31';
		$shedulepass=shedulepass::where('employee_id',Auth::id())->whereBetween('work_date',[$start_date,$enddate_date])->with('arb_pass')->orderBy('work_date','ASC')->get();
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		return view('schedule.status',compact('manaul_working','shedulepass','HolydayasWeekend','holyday_weekend','weekend_period'));







	}
	


	

}
