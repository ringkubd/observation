<?php

namespace App\Http\Controllers\shcedule;
use App\Http\Controllers\Controller;
use App\schedule\shedulepass;
use App\traits\ActivityTraits;
use App\traits\SmsTrait;
use App\traits\specialNoteTraits;
use App\traits\Upermissiontrait;
use App\traits\UserTrait;
use Illuminate\Http\Request;

class sub_ex_management extends Controller {

	use specialNoteTraits, ActivityTraits, UserTrait, Upermissiontrait, SmsTrait;

	public function __construct() {
		$this->middleware('browser');

		$this->middleware(['has_permission']);
		//$this->middleware('package');
	}

	public function index() {
		$condition = $this->wherebranchid()[0];
		shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->$condition('branch_id', $this->wherebranchid()[1])->update(['seen_status' => 0]);

		$ex_sub = shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->$condition('branch_id', $this->wherebranchid()[1])->with('arb_pass')->with('employee_name')
			->where(function($q){
				$q->where('is_substitute', 1)
				->orWhere('extra', 1);
			})->orderBy('work_date', 'Desc')->get();
		return view('schedule.view_subs_extra', compact('ex_sub'));

	}

	public function change_extra_type(Request $req) {
		
		$sh = shedulepass::find($req->schedule_id);
		if($req->type_of_extra=='Frivillig')
		{
		$sh->extra_type = $req->type_of_extra;
		$sh->enkel_hour = null;
		$sh->kvalificerad_hour = null;
		}
		else
		{
		$sh->extra_type = $req->type_of_extra;
		$sh->enkel_hour = $req->enkel_overtid;
		$sh->kvalificerad_hour = $req->kvalificerad_overtid;	
		}
		
		$sh->save();
		return redirect()->back();
	}

}
