<?php

/**
 * @Author:Hasnat
 * @Date:   2017-10-23 22:51:25
 * @Last Modified by:   anwar
 * @Last Modified time: 2018-09-03 11:42:54
 */
namespace App\traits;
use App\ClientTask;
use App\Traits\branch as bdf;

trait ActivityTraits {
	use bdf;

	protected static $sday;

	public static function staticbranchid() {
		$return = new branchid_static_convert();
		return $return->branchid();
	}

	public static function brachQuery() {
		$return = new branchid_static_convert();
		return $return->branchQuery();
	}

	public static function companyidd() {
		$return = new branchid_static_convert();
		return $return->company_idd();
	}

#################################### retrive  todays priority activities start ##################################
	########################################It will be Display in Dashboard	#########################################
	public static function Employeeactivity($priority = null, $startDate, $paginate, $workDone = 0, $not_applicable = 0, $branch_id) {
		$condition = self::brachQuery()[0];

		$empactivity = ClientTask::where('priority', $priority)->whereCompany_id(self::companyidd())->$condition('branch_id', self::brachQuery()[1])->where('start_date', $startDate)->where('work_done', $workDone)->where('not_applicable', $not_applicable)->with('comment_tables')->orderBy('start_time')->paginate($paginate);
		//$links = $empactivity->links();

		return $empactivity;

	}

#################################### retrive  todays priority activities End ########################

#################################### retrive  todays All  activities start###########################
	#################################### retrive  todays All  activities start###########################
	public static function EmployeeactivityAll($startDate, $paginate = null, $workDone = 0, $not_applicable = 0, $branch_id, $clientIndex, $task_title, $shift_time, $category_index,$search_pass) {
		self::$sday = $startDate;
		if ($shift_time != null) {
			$dash_index = strpos($shift_time, "-");
			$start_time = substr($shift_time, 0, $dash_index);
			$end_time = trim(substr($shift_time, ($dash_index + 1)));
		}
		$condition = self::brachQuery()[0];
		$empactivity = ClientTask::select("client_tasks.*","br.branch_name")->where('start_date', $startDate)->where('client_tasks.company_id',self::companyidd())->$condition('client_tasks.branch_id', self::brachQuery()[1])->where('work_done', $workDone)->where('not_applicable', $not_applicable);
		if ($clientIndex != null) {
			$empactivity = $empactivity->where('client_id', $clientIndex);
		}
		if ($task_title != null) {
			$empactivity = $empactivity->where('task_body', 'LIKE', "%{$task_title}%");
		}
		if ($shift_time != null) {
			$empactivity = $empactivity->whereBetween('start_time', array($start_time, $end_time));
		}
		if ($category_index != null) {
			$empactivity = $empactivity->where('category', $category_index);
		}
		if($search_pass!=null)
		{
			$empactivity = $empactivity->whereRaw("FIND_IN_SET($search_pass,responsible_id)");
		}
		/*
		function ($join) {
			
        $join->on((\DB::raw("find_in_set(client_tasks.branch_id, users.branch_id)")),\DB::raw(""),\DB::raw(""));
    }
		*/

		$empactivity = $empactivity->with('comment_tables')
		// ->leftJoin('users',\DB::raw("find_in_set(client_tasks.branch_id, users.branch_id)"),"=",'client_tasks.branch_id')
			->with('Clients.ClientAttachment.fileType')

			->join("branches as br",'client_tasks.branch_id','=','br.id')
			->with('Clients.relatives.third_party')
			
			//->with('activity_responsibility')
			// ->with(['user_list_under_task'=>function($q){
			// 	$q->whereRaw(\DB::raw("find_in_set($q->branch_id,users.branch_id)"));
			// }])
			
			->orderBy('start_time')
			//->first();
			->paginate($paginate);
        $empactivity->load("branch_categories");
        $empactivity->load("branch_pass");
        
		return $empactivity;

	}

#################################### retrive  todays All  activities End ###########################

#################################### retrive  todays All  activities End ###########################

	public static function EmployeeactivityupComing($startDate, $paginate = 10, $workDone = 0, $not_applicable = 0, $branch_id) {
		$condition = self::brachQuery()[0];
		return $empactivity = ClientTask::whereDate('start_date', ">", $startDate)->whereCompany_id(self::companyidd())->$condition('branch_id', self::brachQuery()[1])->where('work_done', $workDone)->where('not_applicable', $not_applicable)->with('comment_tables')->orderBy('start_time')->paginate($paginate);

	}

/*
 ********************************************************************************************************
 ********************************************************************************************************
 *************** Share a task with Nurse , Doctor , Godeman and Relatives *******************************
 ********************************************************************************************************
 ********************************************************************************************************
 */
	public Static function shareactivity() {
		return 'share';
	}

}

/**
 * summary
 */
class branchid_static_convert {
	use bdf;

	public function branchid() {
		return $this->branch_id();
	}

	public function branchQuery() {
		return $this->wherebranchid();
	}

	public function company_idd() {
		return $this->companyid();
	}
}
