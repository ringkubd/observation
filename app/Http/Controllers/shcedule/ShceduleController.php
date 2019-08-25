<?php
namespace App\Http\Controllers\shcedule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\shcedule\traits\BranchTrait;
use App\Http\Controllers\shcedule\traits\UserTrait;
use App\Salary\SalaryStatus;
use App\schedule\holyday;
use App\schedule\holydayasweekend;
use App\schedule\manual_time_hour_compnay;
use App\schedule\pass;
use App\schedule\shedulepass;
use App\schedule\weekend;
use App\Totalworkinghourrange;
use App\traits\CompanyTrait;
use App\traits\SmsTrait;
use App\User;
use Auth;
use Cache;
use Calendar;
use Carbon\carbon;
use Carbon\CarbonPeriod;
use DateTime;
use DB;
use Hash;
use Illuminate\Http\Request;
use Session;

class ShceduleController extends Controller {

	use BranchTrait, CompanyTrait, UserTrait, SmsTrait;

	private $shcedule_branch;

	public function __construct() {

		$this->middleware('has_permission');

	}
	private $paper_size = [1 => 'A4', 2 => 'A4', 3 => 'A3', 4 => 'A3', 5 => 'A2', 6 => 'A2', 7 => 'A1', 8 => 'A1', 9 => 'A1', 10 => 'A1', 11 => 'A0', 12 => 'A0'];
	private $paper_orientation = [1 => 'portrait', 2 => 'landscape', 3 => 'landscape', 4 => 'landscape', 5 => 'landscape', 6 => 'landscape', 7 => 'landscape', 8 => 'landscape', 9 => 'landscape', 10 => 'landscape', 11 => 'landscape', 12 => 'landscape'];

	public function index(Request $request, $pdf = null) {
		//calculate schema starting point
		$request->validate([
			'date' => 'nullable|date',
		]);

		if ($request->date != null) {
			$today_without_string = new carbon($request->date);
		} else {
			$today_without_string = carbon::today('Europe/Bratislava');
		}
		$today_day_number = $today_without_string->dayOfWeek;
		if ($today_day_number == 1) {
			$today_date = $today_without_string->toDateString();
		} elseif ($today_day_number > 1) {
			$deduct_day = $today_day_number - 1;
			$today_date = $today_without_string->subDays($deduct_day)->toDateString();
		} elseif ($today_day_number < 1) {
			$today_date = $today_without_string->subDays(6)->toDateString();
		}

		//calculate schema starting point

		//$today_without_string = new carbon('2018-11-25');
		//$today_date = carbon::today('Europe/Bratislava')->toDateTimeString();

		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$branch_id = $primarey_id;
		$schedule_pass = new shedulepass();
		$checkdefault_week = $schedule_pass->CheckDefaultVecca($this->companyid(), $primarey_id, $today_date);
		if (!empty($checkdefault_week)) {
			$loop = $checkdefault_week->interval_week_num ?? 4;
			$have_vecca = $checkdefault_week->interval_week_num ?? 4;
		} else {
			$loop = 4;
			if ($request->num_of_week != null) {
				$loop = $request->num_of_week;
			}

			$have_vecca = 0;
		}

		//calculate schema ending point
		$total_days_schema = $loop * 7;
		$ending_day_without_string = new carbon($today_date);
		$ending_date = $ending_day_without_string->addDays($total_days_schema)->toDateString();
		$all_date_in_range = [];
		$period = CarbonPeriod::create($today_date, $ending_date);
		foreach ($period as $time) {

			array_push($all_date_in_range, $time->format('Y-m-d'));
		}
		//return dump($all_date_in_range);

		//calculate schema_ending point

		$schedule_start_date = $today_date;

		$employee_name = User::where('is_delete', 0)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->whereRaw("FIND_IN_SET($primarey_id,schedule_permission)")->select('full_name', 'id', 'is_substitute', 'arbetstid_vecka')->get();

		$pass_select_object = shedulepass::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->whereBetween('work_date', [$today_date, $ending_date])->where('interval_week_num', $loop)->select('pass_id', 'employee_id', 'week_id', 'day_id', 'work_date')->get();
		//return $pass_select_object;
		$pass_select = [];

		foreach ($pass_select_object as $data) {
			$pass_select[$data->employee_id . '_' . $data->pass_id . '_' . $data->work_date] = $data->employee_id . '_' . $data->pass_id . '_' . $data->work_date;
		}
		//return $pass_select;

		$arb_pass = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->get();
		$arb_pass2 = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('night_pass_2', null)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->get();

		//$arb_pass_with_night_pass_2 = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working',"night_pass_unique_id")->get();

		$working_total_hour = new Totalworkinghourrange();
		$get_total_ranges = $working_total_hour->GetemployeewiseTotalhourrange($this->companyid(), $primarey_id, $loop);
		$get_total_range = [];
		if (count($get_total_ranges) > 0) {
			foreach ($get_total_ranges as $get_total_hour) {
				$get_total_range[$get_total_hour->employee_id] = $get_total_hour->total_work_range;
			}
		}
		if ($pdf == 'pdf') {
			$branch_name = \App\branch::where('id', $primarey_id)->first();
			$pdf = \PDF::loadView('schedule.schemaDownload', compact('arb_pass2', 'have_vecca', 'loop', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range', 'branch_name', 'branch_id'))->setPaper($this->paper_size[$loop], $this->paper_orientation[$loop]);
			return $pdf->download('employee_shedule.pdf');

		} else {

			return view('schedule.schedule', compact('arb_pass2', 'branch_id', 'have_vecca', 'loop', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range'));

			//return view('schedule.schedule', compact('branch_id', 'have_vecca', 'loop', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range','arb_pass_with_night_pass_2'));

		}

	}

	public function NextSchema(Request $request, $pdf = null) {
		//calculate schema starting point
		$today_without_string = carbon::today('Europe/Bratislava');
		$today_day_number = $today_without_string->dayOfWeek;
		if ($today_day_number == 1) {
			$today_date = $today_without_string->toDateString();
		} elseif ($today_day_number > 1) {
			$deduct_day = $today_day_number - 1;
			$today_date = $today_without_string->subDays($deduct_day)->toDateString();
		} elseif ($today_day_number < 1) {
			$today_date = $today_without_string->subDays(6)->toDateString();
		}
		//return $today_date ;

		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$branch_id = $primarey_id;
		//return $primarey_id;
		$schedule_pass = new shedulepass();
		$checkdefault_week = $schedule_pass->CheckDefaultVecca($this->companyid(), $primarey_id, $today_date);
		if (!empty($checkdefault_week)) {
			$loop = $checkdefault_week->interval_week_num ?? 4;
			$have_vecca = $checkdefault_week->interval_week_num ?? 4;
		} else {

			$loop = 4;
			if ($request->num_of_week != null) {
				$loop = $request->num_of_week;
			}
			$have_vecca = 0;
		}

		$next_req = (int) (is_numeric($request->next) ? $request->next : 1);
		//calculate schema starting point
		$adddays = (int) ($next_req * $loop * 7);
		$nextdate = (int) ($adddays * 2);
		$starting_date_without_string = new carbon($today_date);
		$starting_date = $starting_date_without_string->addDays($adddays)->toDateString();
		$ending_date_without_string = new carbon($today_date);
		$ending_date = $ending_date_without_string->addDays($nextdate)->toDateString();
		$schedule_start_date = $starting_date;
		//return $today_date ;
		//
		$all_date_in_range = [];
		$period = CarbonPeriod::create($starting_date, $ending_date);
		foreach ($period as $time) {

			array_push($all_date_in_range, $time->format('Y-m-d'));
		}

		$employee_name = User::where('is_delete', 0)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->whereRaw("FIND_IN_SET($primarey_id,schedule_permission)")->select('full_name', 'id', 'is_substitute', 'arbetstid_vecka')->get();

		$pass_select_object = shedulepass::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->whereBetween('work_date', [$starting_date, $ending_date])->where('interval_week_num', $loop)->select('pass_id', 'employee_id', 'week_id', 'day_id', 'work_date')->get();
		//return $pass_select_object;
		$pass_select = [];

		foreach ($pass_select_object as $data) {
			$pass_select[$data->employee_id . '_' . $data->pass_id . '_' . $data->work_date] = $data->employee_id . '_' . $data->pass_id . '_' . $data->work_date;
		}
		//return $pass_select;
		$arb_pass = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->where('night_pass_2', null)->get();
		$arb_pass2 = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('night_pass_2', null)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->get();

		$working_total_hour = new Totalworkinghourrange();
		$get_total_ranges = $working_total_hour->GetemployeewiseTotalhourrange($this->companyid(), $primarey_id, $loop);
		$get_total_range = [];
		if (count($get_total_ranges) > 0) {
			foreach ($get_total_ranges as $get_total_hour) {
				$get_total_range[$get_total_hour->employee_id] = $get_total_hour->total_work_range;
			}
		}
		if ($pdf == 'pdf') {
			$branch_name = \App\branch::where('id', $primarey_id)->first();
			$pdf = \PDF::loadView('schedule.schemaDownload', compact('arb_pass2', 'have_vecca', 'loop', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range', 'branch_name'))->setPaper($this->paper_size[$loop], $this->paper_orientation[$loop]);
			return $pdf->download('employee_shedule.pdf');

		} else {

			return view('schedule.schedule', compact('arb_pass2', 'branch_id', 'have_vecca', 'work_date', 'loop', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range'));
		}

	}

	public function deleteSchedule(Request $req) {
		if (Auth::guard('owner')->check()) {
			$password = Auth::guard('owner')->user()->password;
			$user_id = Auth::guard('owner')->user()->company_id;
		} else {
			$password = Auth::user()->password;
			$user_id = Auth::user()->id;
		}

		if (Hash::check($req->pass, $password)) {
			$today_date = carbon::today('Europe/Bratislava')->toDateString();
			$datakey = "data" . coid();
			Cache::forget($datakey);
			$all_branch_of_login_user = $this->getallbranch_for_shedule();
			if (Session::has('schema_branch_id')) {
				$primarey_id = Session::get('schema_branch_id');
			} else {
				$primarey_id = $all_branch_of_login_user[0]['id'];
			}
			$company_id = $this->companyid();
			$employee_id = $req->client_id;

			//return $today_date;
			$schedule_delete = shedulepass::where('company_id', $company_id)
				->where('branch_id', $primarey_id)
				->where('employee_id', $employee_id)
				->where('work_date', '>=', $today_date)
				->update(['is_delete' => 1, 'deleted_by' => $user_id]);
			// DB::raw("delete from schedulepasses where company_id=$company_id AND branch_id=$primarey_id AND employee_id=$employee_id AND work_date>=$today_date");
			if ($schedule_delete == true) {
				return 'ok';
			} else {
				return 'no';
			}

		} else {
			return 'not_match';

		}

	}

	public function schema_calculation(Request $req) {

		$today_date = carbon::today('Europe/Bratislava')->toDateString();
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$primarey_id;
		$company_id = $this->companyid();
		$pass_schedule = new shedulepass();
		$checkdefault_week = $pass_schedule->CheckDefaultVecca($this->companyid(), $primarey_id, $today_date);
		if (!empty($checkdefault_week)) {
			$have_default_week = $checkdefault_week->interval_week_num;
		} else {
			$have_default_week = null;
		}
		//$req->number_of_week;

		switch ($req->action) {
		case 'total_working_range':
			if ($have_default_week == null || $have_default_week == $req->number_of_week) {
				$working_total_hour = new Totalworkinghourrange();
				$working_total_hour->InsertTotalhour($req, $company_id, $primarey_id);
				$haveTotalhour = $working_total_hour->checkTotalhour($req, $company_id, $primarey_id);
			} else {
				return 'not_default_vecca';
			}
			break;
		case 'actual_hour':

			if ($have_default_week == null || $have_default_week == $req->number_of_week) {
				DB::beginTransaction();
				try {

					if ($req->id != null) {
						$arb_pass = pass::where('is_delete', 0)->where('id', $req->id)->where('company_id', $this->companyid())->with("nightpass2")->where('branch_id', $primarey_id)->first();
						$abc = explode(',', $arb_pass->hour);
						$arb_pass_hour = implode('.', $abc);
						$night_pass_id = $arb_pass->nightpass2->id ?? 0;
						$night_pass_id_hour = $arb_pass->nightpass2->hour ?? 0;
					} else {
						$arb_pass = null;

						$arb_pass_hour = '0';
						$night_pass_id = 0;
						$night_pass_id_hour = 0;
					}
					if ($req->start_week == null) {
						$start_week = 0;
					} else {
						$stweekArray = explode(' ', $req->start_week);
						$start_week1 = $stweekArray['1'];
						$start_week = $start_week1 - 1;

					}

					//$start_vecca = $start_week * 0;
					$date_actual = new carbon($req->start_date);
					$start_date = $date_actual->toDateString();
					$date = new DateTime($start_date);
					$futureDate = date('Y-m-d', strtotime('+1 year', strtotime($req->start_date)));
					$start_day_number = (int) $req->start_day_number;
					$day_id = $req->day_id;
					$week_id = $req->week_id;
					$number_of_week = $req->number_of_week;
					$actual_start_date = ($week_id + 1) * 7 - (7 - $day_id);
					$actual_date_result = $actual_start_date - $start_day_number;
					$asmaul = new carbon($start_date);
					$insertabledate = $asmaul->addDays($actual_date_result)->toDateString();
					//$increment = 7 * $number_of_week * 24 * 3600;
					$increment2 = 7 * $number_of_week;
					$insertvalues = [];
					//$start = strtotime($insertabledate);
					//$end = strtotime($futureDate);
					$j = 1;
					//transaction start

					for ($i = 0; $i < 365; $i = $i + $increment2) {

						$farhad = new carbon($insertabledate);
						$insert_date = $farhad->addDays($i)->toDateString();

						//if ($start_date <= $insert_date && $insert_date >= $today_date)  it is change by arif vai
						if ($start_date <= $insert_date) {
							$schedule_check = $pass_schedule->check_update_schedule_date($req, $company_id, $primarey_id, $arb_pass_hour, $insert_date, $arb_pass);

							if ($i == 365) {
								$insert_date = $farhad->addDays($i + $increment2)->toDateString();
								$schedule_check = $pass_schedule->check_update_schedule_date($req, $company_id, $primarey_id, $arb_pass_hour, $insert_date, $arb_pass, true);

							}
							if ($schedule_check == 'no_old_value') {
								$night_pass_vlaue = $pass_schedule->insert_schedule_date($req, $company_id, $primarey_id, $arb_pass_hour, $insert_date, $j);
								if ($night_pass_id != 0) {
									$night_date = new carbon($insert_date);
									$night_date2 = $farhad->addDays(1)->toDateString();
									$pass_schedule->insert_schedule_dateNight($night_pass_id, $this->dayId($req->day_id), $req, $company_id, $primarey_id, $night_pass_id_hour, $night_date2, $j, $night_pass_vlaue->id);
								}

							}
							Totalworkinghourrange::updateOrCreate(['company_id' => $company_id, 'employee_id' => $req->client_id, 'branch_id' => $primarey_id, 'interval_week_num' => $req->number_of_week], ['company_id' => $company_id, 'employee_id' => $req->client_id, 'branch_id' => $primarey_id, 'interval_week_num' => $req->number_of_week, 'total_work_range' => $req->total_work_range ?? 0]);
							$j++;
						}

					}

					//transaction end

					//fclose($myfile);
					DB::commit();
					return $arb_pass_hour + ($night_pass_id_hour ?? 0);
				} catch (\Exception $e) {
					DB::rollback();

				}

			} else {
				return 'not_default_vecca';
			}
			break;
		}
	}

	public function store_schedule(Request $req) {
		$datakey = "data" . coid();
		Cache::forget($datakey);

		$index_today_schedule = "index_today_schedule" . coid();

		Cache::forget($index_today_schedule);
		$date = new DateTime($req->start_date);
		return $futureDate = date('Y-m-d', strtotime('+1 year', strtotime($req->start_date)));
		if ($date->format('D') != 'Mon') {
			$date->modify('next monday');
			return $start_date = $date->format('Y-m-d');
		} else {
			return $start_date = $req->start_date;
		}

	}

	public function get_num_of_week(Request $request) {
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$loop = $request->week;
		$employee_name = User::where('is_delete', 0)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->whereRaw("FIND_IN_SET($primarey_id,schedule_permission)")->select('full_name', 'id', 'is_substitute', 'arbetstid_vecka')->get();
		$arb_pass = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->where('night_pass_2', null)->get();
		$arb_pass2 = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('night_pass_2', null)->with("nightpass2")->select('id', 'name', 'hour', 'colour', 'start_time', 'end_time', 'rest_start_time', 'rest_end_time', 'rest', 'sleep_hour', 'sleep_as_working', "night_pass_unique_id")->get();
		$pass_select = [];
		//return dd($schedule_start_date_vekka);

		$today_without_string = carbon::today('Europe/Bratislava');
		$today_day_number = $today_without_string->dayOfWeek;
		if ($today_day_number == 1) {
			$today_date = $today_without_string->toDateString();
		} elseif ($today_day_number > 1) {
			$deduct_day = $today_day_number - 1;
			$today_date = $today_without_string->subDays($deduct_day)->toDateString();
		} elseif ($today_day_number < 1) {
			$today_date = $today_without_string->subDays(6)->toDateString();
		}

		$schedule_start_date = $today_date;
		//calculate schema ending point
		$total_days_schema = $loop * 7;
		$ending_day_without_string = new carbon($today_date);
		$ending_date = $ending_day_without_string->addDays($total_days_schema)->toDateString();
		$all_date_in_range = [];
		$period = CarbonPeriod::create($today_date, $ending_date);
		foreach ($period as $time) {

			array_push($all_date_in_range, $time->format('Y-m-d'));
		}
		//return dump($all_date_in_range);

		$working_total_hour = new Totalworkinghourrange();
		$get_total_range = $working_total_hour->GetemployeewiseTotalhourrange($this->companyid(), $primarey_id, $loop);
		$data = view('schedule.schema', compact('loop', 'arb_pass2', 'employee_name', 'arb_pass', 'pass_select', 'schedule_start_date', 'get_total_range', 'all_date_in_range'));

		return $data;

	}
	public function arb_pass_add(Request $request) {

		//Cache::forget('index_today_schedule');
		$pass = new pass();
		$pass->insert_pass($request, $this->companyid());

		session::flash('success_message', 'Arb-pass har lagts till');
		return redirect()->back();
	}
	public function edit_arab_pass(Request $request) {
		$edit_data = pass::find($request->edit_id);
		$modal_form = view('schedule.shedule_edit_modal', compact('edit_data'));
		return $modal_form;
	}

	public function arb_pass_update(Request $request) {
		//return $request->all();
		//Cache::forget('index_today_schedule');

		if ($request->have_rest_edit == 'on') {
			$rest_start_time = $request->rast_start_time_add_edit;
			$rest_end_time = $request->rast_end_time_add_edit;
			$rest_time = $request->rast_add_edit;
		} else {
			$rest_start_time = null;
			$rest_end_time = null;
			$rest_time = 0;
		}
		$rest_time = str_replace(',', '.', $rest_time ?? '');

		$pass = pass::find($request->arb_pass_edit_id);
		$pass->name = $request->arb_pass_edit;
		$pass->start_time = $request->start_time_end_edit;
		$pass->end_time = $request->end_time_end_edit;
		$pass->rest_start_time = $rest_start_time;
		$pass->rest_end_time = $rest_end_time;

		$pass->hour = str_replace(',', '.', $request->arb_tid_edit ?? '');
		$pass->rest = $rest_time;
		$pass->sleep_hour = str_replace(',', '.', $request->sleep_hour_edit ?? null);
		$pass->sleep_as_working = str_replace(',', '.', $request->sleep_as_working_edit ?? '');
		$pass->colour = $request->chosen_values;
		$pass->save();
		session()->flash('success_message', 'Arb-passet har uppdaterats');
		return redirect()->back();

	}
	public function delete_arab_pass(Request $request) {
		if (Auth::guard('owner')->check()) {
			$password = Auth::guard('owner')->user()->password;
			$user_id = Auth::guard('owner')->user()->company_id;
		} else {
			$password = Auth::user()->password;
			$user_id = Auth::user()->id;
		}
		//Cache::forget('index_today_schedule');
		$today_date = carbon::today('Europe/Bratislava')->toDateString();

		$pass = pass::find($request->del_id);
		$branch_id = $pass->branch_id;
		$company_id = $pass->company_id;
		\App\schedule\shedulepass::where('work_date', '>=', $today_date)->where('pass_id', $request->del_id)->where('branch_id', $branch_id)->where('company_id', $company_id)->update(['is_delete' => 1, 'deleted_by' => $user_id]);
		$pass->is_delete = 1;

		$pass->save();

		return "Arb-passet har raderats";

	}

	public function shedule_calendar(Request $request) {

		$all_branch_of_login_user = $this->getallbranch_for_shedule();

		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
			$this->shcedule_branch = Session::get('schema_branch_id');
		} else {
			$datakey = "data" . coid();
			Cache::forget($datakey);
			$primarey_id = $all_branch_of_login_user[0]['id'];
			$this->shcedule_branch = $all_branch_of_login_user[0]['id'];
		}

		$events = [];
		$weekend = weekend::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->first();

		$holy_day = json_encode(holyday::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->get());
		$off_pass = json_encode(\App\schedule\off_pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->get());

		if ($weekend != null) {

			$week_start_day = $weekend->start_day;

			$week_end_day = $weekend->end_day;
			$branch_wise_weekend_colour = json_encode($weekend->color_code);
			$day = ['sun', 'mon', 'tue', 'wed', 'thi', 'fri', 'sat'];
			$start_day = array_search($weekend->start_day, $day);
			$end_day = array_search($weekend->end_day, $day);
			$new_array = [];
			if ($start_day > $end_day) {
				$length = count($day);
				for ($i = $start_day; $i < $length; $i++) {
					array_push($new_array, $day[$i]);
					if ($i == count($day) - 1) {
						//echo $week_end_day;
						for ($j = 0; $j <= $end_day; $j++) {
							array_push($new_array, $day[$j]);

						}

					}

				}
				$weekend_day_rang = $new_array;
			} else {
				$new_array = [];

				$length = count($day);
				for ($i = $start_day; $i <= $end_day; $i++) {
					array_push($new_array, $day[$i]);

				}
				$weekend_day_rang = $new_array;
			}

			$js_array = json_encode($weekend_day_rang);

		} else {
			$js_array = json_encode([]);
			$branch_wise_weekend_colour = json_encode('000000');
		}

		$holy_day_as_weekend = json_encode(holydayasweekend::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->get());
		//$datakey = "data" . coid();
		//$dade = Cache::remember($datakey, 240, function () {
		//return shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $this->shcedule_branch)->with('arb_pass')->with('employee_name')->with('employee_ids')->get();
		//});
		//$raw = shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $primarey_id)->with('arb_pass')->with('employee_name')->with('employee_ids')->get();
		//Cache::forget('data');
		//$data = Cache::get($datakey);

		$query = shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $this->shcedule_branch)->with('arb_pass')->with('employee_name')->with('employee_ids');
		if ($request->has('employee_id') && $request->employee_id != "") {
			$query->where('employee_id', $request->employee_id);
		}
		$data = $query->get();

		if ($data->count()) {

			// $reas=[];
			// $empid = [];
			foreach ($data as $key => $value) {
				$start_date = $value->work_date;
				$start_timess = $value->book_for_substitute_start_time ?? $value->change_start_time ?? $value->arb_pass->start_time;
				$start_times_extra = $value->extra_time_start ?? $value->arb_pass->start_time;
				$desired = strtotime($start_date . ' ' . $start_timess);
				$desired_extra = strtotime($start_date . ' ' . $start_times_extra);

				$now = strtotime(now('Europe/Bratislava'));
				if ($value->book_for_substitute == 1 && $desired > $now) {
					$substitute = '<br><span class="blink">Ingen ersättare tillagd ännu</span>';

				} else {
					$substitute = null;

				}
				if ($value->change_start_time != null && $value->change_end_time != null) {
					$employee_name = $value->employee_name->full_name . '(' . $value->reason_for_change_time . ')' . $substitute;
				} elseif ($value->reason_for_hold_off != null) {

					$employee_name = '<strike style="color:black"><b style="color:white">' . $value->employee_name->full_name . '</b></strike>(' . $value->reason_for_hold_off . ')' . $substitute;
				} else {
					if ($value->book_for_extra == 1 && $desired_extra > $now) {
						$employee_name = '<span class="blink">Extra tillgängligt</span>';
					} elseif ($value->book_for_extra == 1 && $desired_extra < $now) {
						$employee_name = __('label.no_one_taken_this_extra');
					} elseif ($value->extra == 1 && $value->book_for_extra != 1) {
						$employee_name = $value->employee_name->full_name . '(extra)';
					} elseif ($value->is_substitute == 1) {
						$employee_name = $value->employee_name->full_name . '(substitute)';
					} else {
						$employee_name = $value->employee_name->full_name;
					}

				}

				$employee_id = $value->employee_id;

				if ($value->arb_pass != null) {
					$arb_pass_color = $value->arb_pass->colour;
				} else {
					$arb_pass_color = '000';
				}

				if ($value->change_start_time != null && $value->change_end_time != null) {
					$start_time = $value->change_start_time;
					$end_time = $value->change_end_time;
				} else {
					if ($value->arb_pass != null) {
						$start_time = $value->arb_pass->start_time;
						$end_time = $value->arb_pass->end_time;
					} elseif ($value->is_substitute == 1) {
						$start_time = $value->substitute_start_time;
						$end_time = $value->substitute_end_time;
					} else {
						$start_time = $value->extra_time_start;
						$end_time = $value->extra_time_end;
					}

				}

				$is_multiday = $value->is_multiday;
				$task_id = $value->task_id;
				$start_date = $value->work_date;
				$end_date = $value->work_date;

				$working_day = explode(',', $value->working_day);

				$events[] = Calendar::event(

					$employee_name, //event title
					false, //full day event?
					$start_date . 'T' . $start_time, //start time (you can also use Carbon instead of DateTime)
					$end_date . 'T' . $end_time, //end time (you can also use Carbon instead of DateTime)

					$value->id,
					['color' => '#' . $arb_pass_color,
						'description' => $employee_name,
						'start_date' => $start_date,
						'end_date' => $end_date,
						'start_time' => $start_time,
						'end_time' => $end_time,
						'task_id' => $task_id,
						'local' => 'sv',

					]
				);
			}
			//return dump($reas);

		}
		//return dump($datelis);

		$calendar = Calendar::addEvents($events);
		$calendar = Calendar::setOptions([
			'timeFormat' => 'H:mm',
			'firstDay' => 1,

		]);

		$calendar = Calendar::setCallbacks(
			[
				'eventClick' => 'function(calEvent,event, jsEvent, view,date)
    {


        if($("#up").val()=="Yes"){


            $(".showing_item").html(calEvent.title)
            var today = new Date().toJSON().slice(0,10).replace(/-/g,"-");
            url = $("#ajax_task_edit").attr("href");


            taskid = calEvent.id
            console.log(taskid);
            $.ajax({
                url: url,
                type: "get",
                data: {taskid: taskid},
                })
                .done(function(data) {
                  console.log(data);
                  $("#change_arb_pass_time_form").html(data);
                  script();

                  $("#myModal").modal("show");
                  $("#myModal").on("hidden.bs.modal", function () {

                    window.location.reload(true);
                    });
                    })
                    .fail(function() {
                        console.log("error");
                        })




                    }
                    else{
                       var title=calEvent.title;

                       if(title.match(/No substitute added yet/))
                       {
                           $(".showing_item").html(calEvent.title)
                           var today = new Date().toJSON().slice(0,10).replace(/-/g,"-");
                           url = $("#ajax_task_edit").attr("href");


                           taskid = calEvent.id
                           console.log(taskid);
                           $.ajax({
                            url: url,
                            type: "get",
                            data: {taskid: taskid,action:"employee"},
                            })
                            .done(function(data) {
                              console.log(data);
                              $("#change_arb_pass_time_form").html(data);


                              $("#myModal").modal("show");

                              })
                              .fail(function() {
                                console.log("error");
                                })



                                $("#start_dates").val();
                            }
                            else if(calEvent.title.match(/Extra available/)){
                               url = $("#ajax_task_edit").attr("href");


                               taskid = calEvent.id
                               console.log(taskid);
                               $.ajax({
                                url: url,
                                type: "get",
                                data: {taskid: taskid,action:"extra"},
                                })
                                .done(function(data) {
                                  console.log(data);
                                  $("#change_arb_pass_time_form").html(data);


                                  $("#myModal").modal("show");

                                  })
                                  .fail(function() {
                                    console.log("error");
                                    })

                                }
                                else
                                return false;

                            }
                        }',

				"eventRender" => "function(event,element,view) {
                           if (view.name === 'month') {

                              element.find('span.fc-title').html(element.find('span.fc-title').text())

                          }
                          else if (view.name === 'agendaWeek' || view.name === 'agendaDay') {
                              element.find('div.fc-title').html(element.find('div.fc-title').text())
                          }


                          event.timeFormat= 'H(:mm)'
                      }",
				'eventAfterRender' => "function(event,element,eventElement) {

                       if(event.title!=undefined){
                           if(event.title.match(/blink/))
                           {

                             $('.fc-day-top[data-date=\"' + event.start_date + '\"]').append('<i class=\'fa fa-bell faa-ring animated fa-1x\'></i>');

                         }
                     }
//                    console.log(event.title);
//                  $( '.fc-day' ).each(function( index ) {


// })





                 }",
				'dayClick' => 'function(date, jsEvent, view)
                 {

        //var today = new Date().toJSON().slice(0,10).replace(/-/g,"-");

         //if(today <= date.format("YYYY-MM-DD")){

                   $.ajax({
                    url: $("#day_click_modal_form").attr("form_url"),
                    type: "get",
                    data:{branch_id:$("#shedule_branch_id").val(),
                    date:date.format("YYYY-MM-DD")
                }

                })
                .done(function(data) {

                  $("#day_click_modal_form").html(data);
                  // $(".hasTimePicker").timepicker();
                  $("#extra_date").val(date.format("YYYY-MM-DD"));
                  $("#extra_multiselect_emp").multiselect({
                    placeholder: "Välj",
                    selectAll: true,
                    });
                    $(".ms-selectall").html("Välj alla (Extra)");


                    $("#dayclick").modal("show");


                    })
                    .fail(function(){
                        console.log("error");
                        })


        // }





                    }',

				'dayRender' => "function(date, cell)
                    {

                     var js_array=$js_array;
                     var color_code='#'+$branch_wise_weekend_colour;
                     var holy_day_length=js_array.length
                     for(i=0;i<holy_day_length;i++){
                       $('td.fc-'+js_array[i]+':not(fc-day-number)').css('background-color',color_code);


                   }

                   var holy_day=$holy_day;

                   holy_day.forEach(function(entry) {
                       var dateList=entry.datelist.split(',');
                       dateList.forEach(function(singleEntry){

                         $('.fc-day[data-date=\"'+singleEntry+'\"]').css('background-color','#'+entry.color_code);

                         })

                         });

                         var holy_day_as_weekend=$holy_day_as_weekend;

                         holy_day_as_weekend.forEach(function(entrys) {
                           var dateLists=entrys.datelist.split(',');
                           dateLists.forEach(function(singleEntrys){

                             $('.fc-day[data-date=\"'+singleEntrys+'\"]').css('background-color','#'+entrys.color_code);
                             })

                             });

                         }",
				'eventAfterAllRender' => 'function() {


                         }',

			]

		);

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}

		$reasones = \App\Reasone::all();
		$employee_name = User::where('is_delete', 0)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->select('full_name', 'id')->get();

		return view('schedule.schedule_calendar', compact('events', 'calendar', 'reasones', 'employee_name'));
	}

	public function set_branch(Request $request) {

		$datakey = "data" . coid();
		Cache::forget($datakey);
		if (Session::has('schema_branch_id')) {
			Session::forget('schema_branch_id');
			//return dd(Session::get('schema_branch_id'));

		}
		Session::put('schema_branch_id', $request->branch_id);
		//return dd(Session::get('schema_branch_id'));
		return redirect()->back();

	}

	public function get_schedule(Request $taskid) {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		if ($taskid->has('action') && $taskid->action == 'employee') {
			$schedule_pass = shedulepass::with('arb_pass')->find($taskid->taskid);
			$data = view('schedule.substitute_book_form', compact('schedule_pass'));
			return $data;
		} elseif ($taskid->has('action') && $taskid->action == 'extra') {
			$schedule_pass = shedulepass::with('arb_pass')->find($taskid->taskid);
			$data = view('schedule.extra_book_form', compact('schedule_pass'));
			return $data;
		} else {
			$schedule_pass = shedulepass::with('arb_pass')->with('employee_name')->find($taskid->taskid);

			$reasones = \App\Reasone::all();
			$employee_name = User::where('is_delete', 0)->where('company_id', $schedule_pass->company_id)->whereRaw("FIND_IN_SET($schedule_pass->branch_id,branch_id)")->select('full_name', 'id', 'is_substitute', 'arbetstid_vecka')->orderBy('is_substitute', 'DESC')->get();

			//view extras on select box start
			$TimeCalculation = new \App\helper\TimeCalculation;
			$working_total_hour = new Totalworkinghourrange();
			$employee_wh_im = [];
			$company_id = $schedule_pass->company_id;
			$branch_id = $schedule_pass->branch_id;
			$date = $schedule_pass->work_date;
			//default vecca for substitute
			$schedule_passes = new shedulepass();
			$checkdefault_week = $schedule_passes->CheckDefaultVeccaForCalender($company_id, $branch_id, $date);
			if (!empty($checkdefault_week)) {
				$week_no = $checkdefault_week->interval_week_num;
			} else {
				$week_no = 4;
			}

			if (count($employee_name) > 0) {
				foreach ($employee_name as $employee) {
					if ($employee->is_substitute == '0') {
						$employee_wh_im[$employee->id]['total_hour'] = $TimeCalculation->CalculationActualHourForextra($date, $employee->id, $branch_id, 0);

						$total_working_range = $working_total_hour->checkTotalhourF_extra($employee->id, $company_id, $branch_id);
						if (!empty($total_working_range)) {
							$employee_wh_im[$employee->id]['total_hour_range'] = $total_working_range;
						}
						$extra_work = $TimeCalculation->CalculationOfTotalExtraInRangeFemployee($date, $employee->id, $branch_id, 0);
						if (!empty($extra_work)) {
							$employee_wh_im[$employee->id]['extra'] = $extra_work;
						}

					} elseif ($employee->is_substitute == '1') {
						$extra_work = $TimeCalculation->CalculationOfTotalExtraInDateARange($date, $employee->id, $branch_id, 1);
						if (!empty($extra_work)) {
							$employee_wh_im[$employee->id]['extra'] = $extra_work;
						}
					}

				}

			}
			//view extra on select box end

			$data = view('schedule.schedule_change_form', compact('reasones', 'employee_name', 'schedule_pass', 'employee_wh_im', 'week_no'));

			return $data;

			//sweet2
		}
	}

	public function arb_pass_off(Request $request) {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		Cache::forget($index_today_schedule);

		if ($request->change_type == 'hold_off') {
			$holdoffreasone = $request->reasone;
			$date_list = $this->getDatesFromRange($request->start_date, $request->end_date);
			$off_pass_id = shedulepass::where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->where('employee_id', $request->employee_id)->whereIN('work_date', $date_list)
				->update(['reason_for_hold_off' => $holdoffreasone]);

			return "passet har varit borta från den här arbetstagaren på grund av $request->reasone";
		} elseif ($request->change_type == 'change_time') {
			$shedulepass = shedulepass::find($request->task_id);

			$shedulepass->change_start_time = $request->slider_time_start;
			$shedulepass->change_end_time = $request->slider_time_end;
			$shedulepass->reason_for_change_time = $request->reasone;
			$shedulepass->save();
			return "Denna arbetsgivarpasstid har minskat på grund av $request->reasone";
		}

	}

	public function arb_pass_off_extra_cancel(Request $request) {

		$datakey = "data" . coid();
		Cache::forget($datakey);
		Cache::forget($index_today_schedule);

		if ($request->has('avbryta_ledighet') && $request->avbryta_ledighet == 'avbryta ledighet') {
			$date_list = $this->getDatesFromRange($request->cancel_start_time, $request->cancel_end_time);
			$off_pass_id = shedulepass::where('id', $request->task_id)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->where('employee_id', $request->employee_id)->whereIN('work_date', $date_list)
				->update(['reason_for_hold_off' => null]);

			return "passet har varit borta från den här arbetstagaren på grund av $request->avbryta_ledighet";
		} elseif ($request->has('avbryta_extras') && $request->avbryta_extras = 'avbryta extra') {
			$date_list = $this->getDatesFromRange($request->cancel_start_time, $request->cancel_end_time);
			$off_pass_id = shedulepass::where('id', $request->task_id)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->where('employee_id', $request->employee_id)->whereIN('work_date', $date_list)
				->where('extra', 1)->delete();

			return "passet har varit borta från den här arbetstagaren på grund av $request->avbryta_extras";
		} elseif ($request->has('avbryta_ersättning') && $request->avbryta_ersättning = 'avbryta ersättning extra') {
			$date_list = $this->getDatesFromRange($request->cancel_start_time, $request->cancel_end_time);
			$off_pass_id = shedulepass::where('id', $request->task_id)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->where('employee_id', $request->employee_id)->whereIN('work_date', $date_list)
				->where('is_substitute', 1)->delete();

			return "passet har varit borta från den här arbetstagaren på grund av $request->avbryta_ersättning";
		}

	}

	function getDatesFromRange($start, $end) {
		$dates = array($start);
		while (end($dates) < $end) {
			$dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
		}
		return $dates;

	}

	public function notifyemploye(Request $req) {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$index_today_schedule = "index_today_schedule" . coid();
		Cache::forget($index_today_schedule);

		if (!empty($req->employee)) {
			foreach ($req->employee as $employe) {
				$user = User::find($employe);
				$mobile = $user->mobile;
				// $message = "Vill du jobba den $req->sub_start_date från $req->start_time till $req->end_time ? svara inte sms. Boka pass i Digiplan!";
				//$message = "Vill du jobba  $req->sub_start_date från kl $req->start_time till $req->end_time ? OBS! Svara inte via detta sms. Svara genom att boka ditt pass i Digiplan.
				//Hälsningar från Digiplan";
				$message = "Vill du jobba  $req->sub_start_date från kl  $req->start_time  till  $req->end_time ? Svara genom att boka ditt pass i Digiplan. Hälsningar från Digiplan";

				$sendstatus = $this->sms($mobile, env('APP_NAME'), $message);
			}
			$substitute = shedulepass::find($req->schedule_pass);

			$substitute->book_for_substitute = 1;
			if ($req->full_pass == 'yes') {

				$substitute->book_for_substitute_pass_id = $req->substittue_pass_id;
			} else {
				$substitute->book_for_substitute_start_time = $req->start_time;
				$substitute->book_for_substitute_end_time = $req->end_time;
				$substitute->book_for_substitute_rest = str_replace(',', '.', $request->rest ?? '');

			}
			$substitute->save();
		}






		$sendstatus = $this->sms($mobile, env('APP_NAME'), $message);
	}
	public function notifyemploye_for_extra(Request $req) {

		$substitute_new = new shedulepass();
		//$substitute_new->is_extra = 1;
		//$substitute_new->extra = 1;
		$substitute_new->work_date = $req->date;
		$substitute_new->branch_id = $req->branch_id;
		$substitute_new->company_id = $req->company_id;
		$substitute_new->book_for_extra = 1;
		//$substitute_new->employee_id = $req->employee[0];

		if ($req->extra_type == 'time') {
			$substitute_new->extra_time_start = $req->extra_start_time;
			$substitute_new->extra_time_end = $req->extra_end_time;
			$substitute_new->extra_time_rest = str_replace(',', '.', $req->extra_rest ?? '');

			if (!empty($req->employee)) {
				foreach ($req->employee as $employe) {
					$user = User::find($employe);
					$mobile = $user->mobile;
					$message = "Vill du jobba  $req->date från kl $req->extra_start_time till $req->extra_end_time ? Svara genom att boka ditt pass i Digiplan.
Hälsningar från Digiplan";

					$sendstatus = $this->sms($mobile, env('APP_NAME'), $message);

				}

			}
		} else {

			$substitute_new->pass_id = $req->arb_pass_id;
			$arb_pass = pass::find($req->arb_pass_id);
			$start_time = $arb_pass->start_time;
			$endtime = $arb_pass->end_time;
			if (!empty($req->employee)) {
				foreach ($req->employee as $employe) {
					$user = User::find($employe);

					$mobile = $user->mobile;

					$message = "Vill du jobba   $req->date från kl $start_time  till  $endtime ?  Svara genom att boka ditt pass i Digiplan. Hälsningar från Digiplan";

					$sendstatus = $this->sms($mobile, env('APP_NAME'), $message);
					//return $sendstatus;
				}

			}
			$substitute_new->save();
			return __('schedule_calendar.sms_sent_successfully');
		}

		//$sendstatus = $this->sms($mobile,env('APP_NAME'),$message);
	}

	public function extra_form(Request $req) {
		$datakey = "data" . coid();
		Cache::forget($datakey);

		$index_today_schedule = "index_today_schedule" . coid();
		Cache::forget($index_today_schedule);

		$branch_id = $req->branch_id;
		$company_id = $this->companyid();
		$date = $req->date;
		$helper = new \App\helper\helper;

		$employee_name = User::where('is_delete', 0)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($req->branch_id,branch_id)")->select('full_name', 'id', 'is_substitute', 'arbetstid_vecka')->orderBy('is_substitute', 'DESC')->get();
		//view extras on select box start
		$TimeCalculation = new \App\helper\TimeCalculation;
		$working_total_hour = new Totalworkinghourrange();
		$employee_wh_im = [];
		//default vecca for substitute
		$schedule_pass = new shedulepass();
		$checkdefault_week = $schedule_pass->CheckDefaultVeccaForCalender($company_id, $branch_id, $date);
		if (!empty($checkdefault_week)) {
			$week_no = $checkdefault_week->interval_week_num;
		} else {
			$week_no = 4;
		}
		//default vecca for substitute
		//
		//
		if (count($employee_name) > 0) {
			foreach ($employee_name as $employee) {
				if ($employee->is_substitute == '0') {
					$employee_wh_im[$employee->id]['total_hour'] = $TimeCalculation->CalculationActualHourForextra($date, $employee->id, $branch_id, 0);

					$total_working_range = $working_total_hour->checkTotalhourF_extra($employee->id, $this->companyid(), $branch_id);
					if (!empty($total_working_range)) {
						$employee_wh_im[$employee->id]['total_hour_range'] = $total_working_range;
					}
					$extra_work = $TimeCalculation->CalculationOfTotalExtraInRangeFemployee($date, $employee->id, $branch_id, 0);
					if (!empty($extra_work)) {
						$employee_wh_im[$employee->id]['extra'] = $extra_work;
					}

				} elseif ($employee->is_substitute == '1') {
					$extra_work = $TimeCalculation->CalculationOfTotalExtraInDateARange($date, $employee->id, $branch_id, 1);
					if (!empty($extra_work)) {
						$employee_wh_im[$employee->id]['extra'] = $extra_work;
					}
				}

			}

		}
		//view extras on select box end
		//dump($$employee_wh_im);
		$arb_pass = pass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $req->branch_id)->whereNull('night_pass_2')->get();
		$data = view('schedule.day_click_modal', compact('employee_name', 'arb_pass', 'branch_id', 'company_id', 'date', 'employee_wh_im', 'week_no'));
		return $data;
	}
	// public function add_extra(Request $req) {

	// 	shedulepass::create([
	// 		'company_id' => $req->company_id,
	// 		'employee_id' => $req->employee_id,
	// 		'branch_id' => $req->branch_id,
	// 		'pass_id' => $req->arb_pass_id,
	// 		'work_date' => $req->date,
	// 		'extra' => 1,
	// 		'extra_time_start' => $req->extra_start_time,
	// 		'extra_time_end' => $req->extra_end_time,
	// 	]);
	// 	session::flash("success", "Extra has been added");
	// 	return redirect()->back();

	// }

	public function get_all_employee_of_that_day(Request $request) {
		$design = $request->design;
		$task_id = $request->task_id;
		$today_schedule = shedulepass::where('is_delete', 0)->where('company_id', $this->companyid())->where('branch_id', $request->branch_id)->where('work_date', $request->date)->where('book_for_substitute', '!=', 1)->with('arb_pass')->with('employee_name')->get();
		$data = view('dashboard.activity.tagging_modal', compact('today_schedule', 'design', 'task_id'));
		return $data;
	}

	public function apply_for_leave_view() {
		$reasones = \App\Reasone::all();
		$leaves = \App\apply_for_leave::where('employee_id', \Auth::id())->get();
		return view('schedule.leave_management.apply_for_leave', compact('reasones', 'leaves'));
	}
	public function store_apply_for_leave(Request $req) {
		$index_today_schedule = "index_today_schedule" . coid();
		Cache::forget($index_today_schedule);
		$datakey = "data" . coid();
		Cache::forget($datakey);
		if (\Auth::id() != null) {

			$employee_info = User::find(\Auth::id());
			$comapny_id = $employee_info->company_id;

			$branch_id = $employee_info->branch_id;
			$apply_for_leave = new \App\apply_for_leave();

			$apply_for_leave->insert_leave(\Auth::id(), $req, $comapny_id, $branch_id);
			return redirect()->back();

		} else {
			return "Sorry you are the owner";
		}

	}

	public function open_to_book(Request $request) {

		$substitute = shedulepass::find($request->schedule_pass);
		$substitute->book_for_substitute = 1;
		if ($request->full_pass == 'yes') {

			$substitute->book_for_substitute_pass_id = $request->substittue_pass_id;

			$substitute->save();
			return "This  pass is open to book";
		} elseif ($request->full_pass == 'No') {
			$substitute->book_for_substitute_start_time = $request->start_time;
			$substitute->book_for_substitute_end_time = $request->end_time;
			$substitute->book_for_substitute_rest = str_replace(',', '.', $request->rest ?? '');

			$substitute->save();
			return "This  pass is open to book";

		}

	}

	public function substitute_register(Request $request) {

		$datakey = "data" . coid();
		Cache::forget($datakey);
		$index_today_schedule = "index_today_schedule" . coid();
		Cache::forget($index_today_schedule);
		$substitute = shedulepass::find($request->schedule_pass);

		$substitute->book_for_substitute = 2;
		$substitute->save();
		$substitute_new = new shedulepass();
		$substitute_new->is_substitute = 1;
		$substitute_new->work_date = $request->sub_start_date;
		$substitute_new->branch_id = $request->branch_id;
		$substitute_new->company_id = $request->company_id;
		$substitute_new->seen_status = 1;

		if ($request->full_pass == 'yes') {
			//sweet

			$substitute_new->pass_id = $request->substittue_pass_id;
			$substitute_new->employee_id = $request->employee[0];

			$substitute->pass_id = $request->substittue_pass_id;
		} else {
			$substitute_new->employee_id = $request->employee[0];
			$substitute_new->substitute_start_time = $request->start_time;
			$substitute_new->substitute_end_time = $request->end_time;
			$substitute_new->substitute_rest = str_replace(',', '.', $request->rest ?? '');

			$substitute_new->substitute_rest_start_time = $request->subs_rest_start_time;
			$substitute_new->substitute_rest_end_time = $request->subs_rest_end_time;

		}
		$substitute_new->save();
		return "Substitue has been added";

	}
	public function employee_book(Request $request) {

		if (Auth::id() != null) {
			$substitute = shedulepass::find($request->shedule_pass_id);

			$all_user_id = DB::table('upermission_user')->where('upermission_id', 25)->pluck('user_id');
			$real_mobile_number = [];
			if (!empty($all_user_id)) {
				foreach ($all_user_id as $ui) {

					$mb = User::where('id', $ui)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($substitute->branch_id,branch_id)")->select('mobile')->get();
					if ($mb[0]->mobile != null) {
						array_push($real_mobile_number, $mb[0]->mobile);
					}

				}

				$name = Auth::user()->full_name;
				$message = "$name is booked for $substitute->work_date sustitute.";
				//return $real_mobile_number;
				foreach ($real_mobile_number as $r) {

					$this->sms($r, env('APP_NAME'), $message);

				}
			}

			$substitute->book_for_substitute = 2;
			$substitute->save();
			$substitute_new = new shedulepass();
			$substitute_new->is_substitute = 1;
			$substitute_new->work_date = $request->start_Date;
			$substitute_new->branch_id = $request->substitute_branch_id;
			$substitute_new->company_id = $request->substitute_company_id;
			$substitute_new->seen_status = 1;

			if ($request->full_pass == 'yes') {

				$substitute_new->pass_id = $request->pass_id;
				$substitute_new->employee_id = Auth::id();

				$substitute->pass_id = $request->substittue_pass_id;
			} else {
				$substitute_new->employee_id = Auth::id();
				$substitute_new->substitute_start_time = $request->start_time;
				$substitute_new->substitute_end_time = $request->end_time;
				$substitute_new->substitute_rest = str_replace(',', '.', $request->rast ?? '');

			}
			$substitute_new->save();

			return redirect()->back();
		}

	}

	public function extra_register(Request $request) {
		$first_night_pass = pass::where('id', $request->arb_pass_id)->select('night_pass_unique_id', 'is_night_pass')->first();
		if ($first_night_pass->is_night_pass == '1') {
			$second_night_pass = pass::where('night_pass_unique_id', $first_night_pass->night_pass_unique_id)->where('night_pass_2', '1')->select('id')->first();
			$date = new carbon($request->date);
			$next_date = $date->addDays(1);

			shedulepass::insert([
				[
					'is_extra' => 1,
					'extra' => 1,
					'work_date' => $request->date,
					'branch_id' => $request->branch_id,
					'company_id' => $request->company_id,
					'employee_id' => $request->employee[0],
					'seen_status' => 1,
					'pass_id' => $request->arb_pass_id,
				],
				[
					'is_extra' => 1,
					'extra' => 1,
					'work_date' => $next_date,
					'branch_id' => $request->branch_id,
					'company_id' => $request->company_id,
					'employee_id' => $request->employee[0],
					'seen_status' => 1,
					'pass_id' => $second_night_pass->id,
				],
			]);
		} else {
			if (!empty($request->employee)) {
				$substitute_new = new shedulepass();
				$substitute_new->is_extra = 1;
				$substitute_new->extra = 1;
				$substitute_new->work_date = $request->date;
				$substitute_new->branch_id = $request->branch_id;
				$substitute_new->company_id = $request->company_id;
				$substitute_new->employee_id = $request->employee[0];
				$substitute_new->seen_status = 1;

				if ($request->extra_type == 'time') {
					if ($request->has('sleep_hour')) {
						$sleep_hour = $request->sleep_hour;
					} else {
						$sleep_hour = null;
					}
					if ($request->has('sleep_as_working')) {
						$sleep_as_working = $request->sleep_as_working;
					} else {
						$sleep_as_working = null;
					}

					$substitute_new->extra_time_start = $request->extra_start_time;
					$substitute_new->extra_time_end = $request->extra_end_time;
					$substitute_new->extra_rest_start_time = $request->rast_start_time_add;
					$substitute_new->extra_rest_end_time = $request->rast_end_time_add;
					$substitute_new->extra_time_rest = str_replace(',', '.', $request->rast_add ?? '');

				} else {
					$substitute_new->pass_id = $request->arb_pass_id;
				}
				$substitute_new->save();
			}
		}
		if ($request->has('path_location')) {
			return back();
		}
	}

	public function employee_book_for_extra(Request $request) {

		if (Auth::id() != null) {
			$substitute = shedulepass::find($request->shedule_pass_id);
			$all_user_id = DB::table('upermission_user')->where('upermission_id', 25)->pluck('user_id');
			$real_mobile_number = [];
			if (!empty($all_user_id)) {
				foreach ($all_user_id as $ui) {

					$mb = User::where('id', $ui)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($substitute->branch_id,branch_id)")->select('mobile')->get();
					if ($mb[0]->mobile != null) {
						array_push($real_mobile_number, $mb[0]->mobile);
					}

				}

				$name = Auth::user()->full_name;
				$message = "$name is booked for $substitute->work_date extra.";
				//return $real_mobile_number;
				foreach ($real_mobile_number as $r) {

					$this->sms($r, env('APP_NAME'), $message);

				}
			}

			$substitute->book_for_extra = 2;
			$substitute->employee_id = Auth::id();
			$substitute->extra = 1;
			$substitute->is_extra = 1;
			$substitute->seen_status = 1;

			$substitute->save();

			return redirect()->back();
		}

	}
	public function open_to_book_for_extra(Request $request) {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$index_today_schedule = "index_today_schedule" . coid();
		Cache::forget($index_today_schedule);

		$substitute_new = new shedulepass();
		//$substitute_new->is_extra = 1;
		//$substitute_new->extra = 1;
		$substitute_new->work_date = $request->date;
		$substitute_new->branch_id = $request->branch_id;
		$substitute_new->company_id = $request->company_id;
		$substitute_new->book_for_extra = 1;
		//$substitute_new->employee_id = $request->employee[0];

		if ($request->extra_type == 'time') {
			$substitute_new->extra_time_start = $request->extra_start_time;
			$substitute_new->extra_time_end = $request->extra_end_time;
			$substitute_new->extra_time_rest = str_replace(',', '.', $request->extra_rest ?? '');

		} else {

			$substitute_new->pass_id = $request->arb_pass_id;

		}
		$substitute_new->save();
		return "successfully open book for extra";

	}

	public function get_status(Request $request, $name = null) {
		if ($name == null) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = $name;
		}

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$employee_id = $user_id;
		$company_id = Auth::user()->company_id;
		// return $company_id;
		//return $primarey_id;

		$employer_info = User::where('id', $user_id)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->first();
		if (!empty($employer_info)) {
			$substitute_status = $employer_info->is_substitute;
		} else {
			return 'Something went to wrong !';
		}
		$now = Carbon::now('Europe/Bratislava');
		$current_year = $now->year;
		$current_month = $now->month;
		//return $current_month;

		//$HolydayasWeekend=$holyday_as_weekend->retrive_holydayas_weekend($company_id,$this->wherebranchid());

		$HolydayasWeekend = holydayasweekend::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();

		$weekend_period = weekend::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->first();
		$holyday_weekend = holyday::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();

		//$manaul_working=$manul_time->GetManualTimeShiftinfo($this->companyid());
		$manaul_working = manual_time_hour_compnay::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();
		$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';

		$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';
		$month_is_one_check = $request->month ?? $current_month;
		if ($month_is_one_check == 1) {
			$requested_year = ($request->year ?? $current_year) - 1;
			$requested_month = 12;
		} else {
			$requested_year = ($request->year ?? $current_year);
			$requested_month = ($request->month ?? $current_month) - 1;
		}

		$start_date_index = $requested_year . '-' . $requested_month . '-01';
		$enddate_date_index = $requested_year . '-' . $requested_month . '-31';
		$shedulepass = shedulepass::where('employee_id', $employee_id)->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();

		$signature = SalaryStatus::where('user_id', 18)
			->where('branch_id', $primarey_id)->where('status_date', $requested_year . '-' . $requested_month)->with('manager')->with('employee')->with('salary_assistant')->first();
		$shedulepass_lastinfo = shedulepass::where('employee_id', $employee_id)->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date_index, $enddate_date_index])->with('arb_pass')->orderBy('work_date', 'DESC')->first();

		if ($substitute_status != 1) {
			$ex_sub = shedulepass::where('company_id', $this->companyid())->where('employee_id', $employee_id)->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())->where('branch_id', $primarey_id)->where(function ($query) {

				$query->where('extra', 1)->orWhere('is_substitute', 1);
			})
				->whereBetween('work_date', [$start_date, $enddate_date])->orderBy('work_date', 'Desc')->with('arb_pass')->with('employee_name')
				->get();
			$leave_reason = shedulepass::where('company_id', $this->companyid())->where('employee_id', $employee_id)->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->where(function ($q) {

				$q->where('reason_for_hold_off', '!=', null)->orWhere('reason_for_change_time', '!=', null);
			})->orderBy('work_date', 'Desc')->with('arb_pass')->with('employee_name')
				->get();
			return view('schedule.status', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period', 'employer_info', 'shedulepass_lastinfo', 'ex_sub', 'leave_reason', 'signature', 'requested_year', 'requested_month'));
		} elseif ($substitute_status == 1) {

			return view('schedule.status_substitute', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period', 'employer_info', 'shedulepass_lastinfo', 'signature', 'requested_year', 'requested_month'));
		}
	}

	public function status_comment(Request $request){
		//return $request;
		if ($request->work_change_time_status == '0') {
			$shedulepass = shedulepass::where('id', $request->shedulepass_id)->update(['change_work_start_time'=>$request->change_work_start_time,'change_work_end_time'=>$request->change_work_end_time,'reason_for_change_work_time'=>$request->reason_for_change_work_time,'work_change_time_status'=>$request->work_change_time_status]);
		}else if($request->work_change_time_status == '1'){
			$shedulepass = shedulepass::find($request->shedulepass_id);
			if(!empty($request->change_work_start_time)){
				$shedulepass->work_start_time = $request->change_work_start_time;
			}
			if (!empty($request->change_work_end_time)) {
				$shedulepass->work_end_time = $request->change_work_end_time;
			}
			$shedulepass->work_change_time_status = $request->work_change_time_status;
			$shedulepass->save();
		}else if ($request->work_change_time_status == '2') {
			$shedulepass = shedulepass::where('id', $request->shedulepass_id)->update(['work_change_time_status'=>$request->work_change_time_status]);
		}
		
	}
	public function getWorkChangeTime(Request $request){
		return $shedulepass = shedulepass::find($request->id);
	}

	public function get_status_all(Request $request, $name = null) {
		$manaul_working = array();
		$shedulepass = array();
		$HolydayasWeekend = array();
		$holyday_weekend = array();
		$weekend_period_array = array();
		$shedulepass_lastinfos = array();
		$ex_sub = [];
		if ($name == null) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = $name;
		}
		$employee_id = $user_id;
		$company_id = Auth::user()->company_id;
//asmaul
		$employer_info = User::where('id', $user_id)->where('company_id', $this->companyid())->first();
		if (!empty($employer_info)) {
			$substitute_status = $employer_info->is_substitute;
		} else {
			return 'Something went to wrong';
		}

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (!empty($all_branch_of_login_user)) {
			foreach ($all_branch_of_login_user as $branch) {

				$HolydayasWeekend_result = holydayasweekend::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				if (!empty($HolydayasWeekend_result)) {$HolydayasWeekend[$branch['id']] = $HolydayasWeekend_result;}
				$weekend_period_result = weekend::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->first();
				if (!empty($weekend_period_result)) {$weekend_period_array[$branch['id']] = $weekend_period_result;}
				$holyday_weekend_result = holyday::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				if (!empty($holyday_weekend_result)) {$holyday_weekend[$branch['id']] = $holyday_weekend_result;}
				$manaul_working_result = manual_time_hour_compnay::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				$branch_id = $branch['id'];
				if (!empty($manaul_working_result)) {$manaul_working[$branch['id']] = $manaul_working_result;}

				//calculation start
				$now = Carbon::now('Europe/Bratislava');
				$current_year = $now->year;
				$current_month = $now->month;
				$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';

				$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';
				$month_is_one_check = $request->month ?? $current_month;
				if ($month_is_one_check == 1) {
					$requested_year = ($request->year ?? $current_year) - 1;
					$requested_month = 12;
				} else {
					$requested_year = ($request->year ?? $current_year);
					$requested_month = ($request->month ?? $current_month) - 1;
				}

				$start_date_index = $requested_year . '-' . $requested_month . '-01';
				$enddate_date_index = $requested_year . '-' . $requested_month . '-31';

				//view presenting

				$ex_subs = shedulepass::where('company_id', $this->companyid())->where('employee_id', $employee_id)->where('branch_id', $branch['id'])->where('extra', 1)->whereBetween('work_date', [$start_date, $enddate_date])->orderBy('work_date', 'Desc')->with('arb_pass')->with('employee_name')->get();
				if (!empty($ex_subs)) {

					$ex_sub[$branch['id']] = $ex_subs;}

				$shedulepass_result = shedulepass::where('employee_id', $employee_id)
					->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
					->where('branch_id', $branch['id'])->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();
				if (!empty($shedulepass_result)) {$shedulepass[$branch['id']] = $shedulepass_result;}
				$shedulepass_lastinfo_result = shedulepass::where('employee_id', $employee_id)
					->where('work_date', '<', Carbon::today('Europe/Bratislava')->toDateString())
					->where('branch_id', $branch['id'])->whereBetween('work_date', [$start_date_index, $enddate_date_index])->with('arb_pass')->orderBy('work_date', 'DESC')->first();
				if (!empty($shedulepass_lastinfo_result)) {$shedulepass_lastinfos[$branch['id']] = $shedulepass_lastinfo_result;}

			}

		}
		$manual_time_max_row = DB::table('manual_time_hour_compnays')->where('company_id', $this->companyid())->where('is_delete', 0)->select('manual_time_hour_compnays.branch_id', DB::raw('COUNT(*) AS mcount'))->GROUPBY('manual_time_hour_compnays.branch_id')->orderBy('mcount', 'desc')->get([0]);

		if ($substitute_status != 1) {
//return $ex_sub;
			return view('schedule.status_all_branch', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period_array', 'employer_info', 'shedulepass_lastinfos', 'all_branch_of_login_user', 'manual_time_max_row', 'ex_sub'));
		} elseif ($substitute_status == 1) {
			//return 'something went to wrong';
			//sweet2
			//return $ex_sub;
			return view('schedule.status_substitute_all_branch', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period_array', 'employer_info', 'shedulepass_lastinfos', 'all_branch_of_login_user', 'manual_time_max_row'));
		}

	}

//mmm
	public function preplanned_all(Request $request, $name = null) {
		$manaul_working = array();
		$shedulepass = array();
		$HolydayasWeekend = array();
		$holyday_weekend = array();
		$weekend_period_array = array();
		$shedulepass_lastinfos = array();
		if ($name == null) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = $name;
		}
		$employee_id = $user_id;
		$company_id = Auth::user()->company_id;
		$employer_info = User::where('id', $user_id)->where('company_id', $this->companyid())->first();
		if (!empty($employer_info)) {
			$substitute_status = $employer_info->is_substitute;
		} else {
			return 'Something went to wrong';
		}

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (!empty($all_branch_of_login_user)) {
			foreach ($all_branch_of_login_user as $branch) {

				$HolydayasWeekend_result = holydayasweekend::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				if (!empty($HolydayasWeekend_result)) {$HolydayasWeekend[$branch['id']] = $HolydayasWeekend_result;}
				$weekend_period_result = weekend::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->first();
				if (!empty($weekend_period_result)) {$weekend_period_array[$branch['id']] = $weekend_period_result;}
				$holyday_weekend_result = holyday::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				if (!empty($holyday_weekend_result)) {$holyday_weekend[$branch['id']] = $holyday_weekend_result;}
				$manaul_working_result = manual_time_hour_compnay::where('company_id', $this->companyid())->where('branch_id', $branch['id'])->where('is_delete', 0)->get();
				$branch_id = $branch['id'];
				if (!empty($manaul_working_result)) {$manaul_working[$branch['id']] = $manaul_working_result;}

				//calculation start
				$now = Carbon::now('Europe/Bratislava');
				$current_year = $now->year;
				$current_month = $now->month;
				$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';

				$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';
				$month_is_one_check = $request->month ?? $current_month;
				if ($month_is_one_check == 1) {
					$requested_year = ($request->year ?? $current_year) - 1;
					$requested_month = 12;
				} else {
					$requested_year = ($request->year ?? $current_year);
					$requested_month = ($request->month ?? $current_month) - 1;
				}

				$start_date_index = $requested_year . '-' . $requested_month . '-01';
				$enddate_date_index = $requested_year . '-' . $requested_month . '-31';

				//view presenting

				$shedulepass_result = shedulepass::where('employee_id', $employee_id)->where('is_substitute', '!=', 1)->where('extra', '!=', 1)
					->where('branch_id', $branch['id'])->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();
				if (!empty($shedulepass_result)) {$shedulepass[$branch['id']] = $shedulepass_result;}
				$shedulepass_lastinfo_result = shedulepass::where('employee_id', $employee_id)->where('is_substitute', '!=', 1)
					->where('branch_id', $branch['id'])->where('extra', '!=', 1)->whereBetween('work_date', [$start_date_index, $enddate_date_index])->with('arb_pass')->orderBy('work_date', 'DESC')->first();
				if (!empty($shedulepass_lastinfo_result)) {$shedulepass_lastinfos[$branch['id']] = $shedulepass_lastinfo_result;}

			}

		}
		$manual_time_max_row = DB::table('manual_time_hour_compnays')->where('company_id', $this->companyid())->where('is_delete', 0)->select('manual_time_hour_compnays.branch_id', DB::raw('COUNT(*) AS mcount'))->GROUPBY('manual_time_hour_compnays.branch_id')->orderBy('mcount', 'desc')->get([0]);

		if ($substitute_status != 1) {

			return view('schedule.preplaned_all_branch', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period_array', 'employer_info', 'shedulepass_lastinfos', 'all_branch_of_login_user', 'manual_time_max_row'));
		} elseif ($substitute_status == 1) {
			return 'something went to wrong !!';

		}
	}

	public function GetEmployeeWiseWorkingHour(Request $request) {

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
			//return $current_month;

		}
		$company_id = Auth::user()->company_id;

		$employer_infos = User::where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->withCount('getNotification')->get();

		return view('schedule/admin_status', compact('employer_infos', 'request', 'primarey_id'));
	}

	public function preplanned(Request $request, $name = null) {
		if ($name == null) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = $name;
		}

		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$employee_id = $user_id;
		$company_id = Auth::user()->company_id;
		// return $company_id;

		$employer_info = User::where('id', $user_id)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->first();
		if (!empty($employer_info)) {
			$substitute_status = $employer_info->is_substitute;
		} else {
			return 'Something went to wrong';
		}
		$now = Carbon::now('Europe/Bratislava');
		$current_year = $now->year;
		$current_month = $now->month;
		//return $current_month;

		//$HolydayasWeekend=$holyday_as_weekend->retrive_holydayas_weekend($company_id,$this->wherebranchid());

		$HolydayasWeekend = holydayasweekend::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();

		$weekend_period = weekend::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->first();
		$holyday_weekend = holyday::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();

		//$manaul_working=$manul_time->GetManualTimeShiftinfo($this->companyid());
		$manaul_working = manual_time_hour_compnay::where('company_id', $this->companyid())->where('branch_id', $primarey_id)->where('is_delete', 0)->get();
		$start_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-01';

		$enddate_date = ($request->year ?? $current_year) . '-' . ($request->month ?? $current_month) . '-31';

		$month_is_one_check = $request->month ?? $current_month;
		if ($month_is_one_check == 1) {
			$requested_year = ($request->year ?? $current_year) - 1;
			$requested_month = 12;
		} else {
			$requested_year = ($request->year ?? $current_year);
			$requested_month = ($request->month ?? $current_month) - 1;
		}

		$start_date_index = $requested_year . '-' . $requested_month . '-01';
		$enddate_date_index = $requested_year . '-' . $requested_month . '-31';

		$shedulepass = shedulepass::where('employee_id', $employee_id)->where('extra', '!=', 1)
			->where('work_date', '<=', $enddate_date)
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date, $enddate_date])->with('arb_pass')->orderBy('work_date', 'ASC')->get();
		$shedulepass_lastinfo = shedulepass::where('employee_id', $employee_id)->where('extra', '!=', 1)->where('is_substitute', '!=', 1)
			->where('work_date', '<=', $enddate_date)
			->where('branch_id', $primarey_id)->whereBetween('work_date', [$start_date_index, $enddate_date_index])->with('arb_pass')->orderBy('work_date', 'DESC')->first();
		// return dump( $shedulepass_array);
		if ($substitute_status != 1) {

			return view('schedule.preplanned', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period', 'employer_info', 'shedulepass_lastinfo'));
		} elseif ($substitute_status == 1) {

			return view('schedule.preplanned', compact('manaul_working', 'shedulepass', 'HolydayasWeekend', 'holyday_weekend', 'weekend_period', 'employer_info'));
		}
	}

	public function ComparisonWork(Request $request, $name = null) {
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];

			//return $current_month;

		}
		$company_id = $this->companyid();
		if ($name == null) {
			$user_id = Auth::user()->id;
		} else {
			$user_id = $name;
		}
		$employer_info = User::where('id', $user_id)->where('company_id', $this->companyid())->whereRaw("FIND_IN_SET($primarey_id,branch_id)")->first();
		if (!empty($employer_info)) {
			$substitute_status = $employer_info->is_substitute;
		} else {
			return 'Something went to wrong';
		}

		return view('schedule/comparison', compact('request', 'employer_info', 'primarey_id'));
	}
	public function insert_actual_working_hour(Request $req) {

		if ($req->time == 'in') {

			if ($req->unique_pass_id != null) {
				//return "hello";
				$shedule = shedulepass::where('id', $req->emp_id)->first();
				$shedule_company = $shedule->company_id;
				$shedule_branch = $shedule->branch_id;
				$employee_id = $shedule->employee_id;
				$work_date = $shedule->work_date;
				//return $work_date;
				//return $employee_id;
				$ts = shedulepass::find($req->emp_id);

				if ($ts->change_start_time != null && $ts->change_end_time != null) {
					$start_time = $ts->change_start_time;
					$end_time = $ts->change_end_time;
				} else {
					if ($ts->arb_pass == null && $ts->extra == 1) {
						$start_time = $ts->extra_time_start;
						$end_time = $ts->extra_time_end;
					} elseif ($ts->arb_pass == null && $ts->is_substitute == 1) {
						$start_time = $ts->substitute_start_time;
						$end_time = $ts->substitute_end_time;
					} else {
						$start_time = $ts->arb_pass->start_time;

						$end_time = $ts->arb_pass->end_time;
						//$sleep_confirmation=$ts->arb_pass->sleep_hour;

					}

				}

				//return $start_time;

				if ($ts->work_start_time == null) {
					shedulepass::where('id', $req->emp_id)->update(['work_start_time' => $req->real_s_time, 'work_end_time' => $end_time, 'probable_stampling_start' => $req->now_time, 'reason_for_stampling_start' => $req->reason, 'device' => $req->device, 'location' => $req->location]);
					$shd = shedulepass::where('id', '!=', $req->emp_id)->where('work_date', '>=', $work_date)->where('branch_id', $shedule_branch)->where('employee_id', $employee_id)->where('company_id', $shedule_company)->orderBy('work_date', 'ASC')->first();

					if ($shd->change_start_time != null && $shd->change_end_time != null) {
						$next_start_time = $shd->change_start_time;

					} else {
						if ($shd->arb_pass == null && $shd->extra == 1) {
							$next_start_time = $shd->extra_time_start;

						} elseif ($shd->arb_pass == null && $shd->is_substitute == 1) {
							$next_start_time = $shd->substitute_start_time;

						} else {
							$next_start_time = $shd->arb_pass->start_time;

							//$sleep_confirmation=$ts->arb_pass->sleep_hour;

						}

					}
					//return $shd->id;
					shedulepass::where('id', $shd->id)->update(['work_start_time' => $next_start_time, 'device' => $req->device, 'location' => $req->location]);

				} else {
					shedulepass::where('id', $req->emp_id)->update(['work_end_time' => $end_time]);
					$shd = shedulepass::where('id', '!=', $req->emp_id)->where('work_date', '>=', $work_date)->where('branch_id', $shedule_branch)->where('employee_id', $employee_id)->where('company_id', $shedule_company)->orderBy('work_date', 'ASC')->first();

					if ($shd->change_start_time != null && $shd->change_end_time != null) {
						$next_start_time = $shd->change_start_time;

					} else {
						if ($shd->arb_pass == null && $shd->extra == 1) {
							$next_start_time = $shd->extra_time_start;

						} elseif ($shd->arb_pass == null && $shd->is_substitute == 1) {
							$next_start_time = $shd->substitute_start_time;

						} else {
							$next_start_time = $shd->arb_pass->start_time;

							//$sleep_confirmation=$ts->arb_pass->sleep_hour;

						}

					}

					shedulepass::where('id', $shd->id)->update(['work_start_time' => $next_start_time, 'device' => $req->device, 'location' => $req->location]);

				}
			}

			if ($req->sleep == 'sleep_in') {
				//return "hello";
				$shedule = shedulepass::where('id', $req->emp_id)->first();
				$shedule_company = $shedule->company_id;
				$shedule_branch = $shedule->branch_id;
				$employee_id = $shedule->employee_id;
				$work_date = $shedule->work_date;
				//return $work_date;
				//return $employee_id;
				$ts = shedulepass::find($req->emp_id);

				if ($ts->change_start_time != null && $ts->change_end_time != null) {
					$start_time = $ts->change_start_time;
					$end_time = $ts->change_end_time;
				} else {
					if ($ts->arb_pass == null && $ts->extra == 1) {
						$start_time = $ts->extra_time_start;
						$end_time = $ts->extra_time_end;
					} elseif ($ts->arb_pass == null && $ts->is_substitute == 1) {
						$start_time = $ts->substitute_start_time;
						$end_time = $ts->substitute_end_time;
					} else {
						$start_time = $ts->arb_pass->start_time;

						$end_time = $ts->arb_pass->end_time;
						//$sleep_confirmation=$ts->arb_pass->sleep_hour;

					}

				}

				//return $start_time;

				if ($ts->work_start_time == null) {
					shedulepass::where('id', $req->emp_id)->update(['work_start_time' => $req->real_s_time, 'work_end_time' => $end_time, 'probable_stampling_start' => $req->now_time, 'reason_for_stampling_start' => $req->reason, 'device' => $req->device, 'location' => $req->location]);
					$shd = shedulepass::where('id', '!=', $req->emp_id)->where('work_date', '>=', $work_date)->where('branch_id', $shedule_branch)->where('employee_id', $employee_id)->where('company_id', $shedule_company)->orderBy('work_date', 'ASC')->first();

					if ($shd->change_start_time != null && $shd->change_end_time != null) {
						$next_start_time = $shd->change_start_time;

					} else {
						if ($shd->arb_pass == null && $shd->extra == 1) {
							$next_start_time = $shd->extra_time_start;

						} elseif ($shd->arb_pass == null && $shd->is_substitute == 1) {
							$next_start_time = $shd->substitute_start_time;

						} else {
							$next_start_time = $shd->arb_pass->start_time;

							//$sleep_confirmation=$ts->arb_pass->sleep_hour;

						}

					}
					//return $shd->id;
					shedulepass::where('id', $shd->id)->update(['work_start_time' => $next_start_time, 'device' => $req->device, 'location' => $req->location]);

				} else {
					shedulepass::where('id', $req->emp_id)->update(['work_end_time' => $end_time]);
					$shd = shedulepass::where('id', '!=', $req->emp_id)->where('work_date', '>=', $work_date)->where('branch_id', $shedule_branch)->where('employee_id', $employee_id)->where('company_id', $shedule_company)->orderBy('work_date', 'ASC')->first();

					if ($shd->change_start_time != null && $shd->change_end_time != null) {
						$next_start_time = $shd->change_start_time;

					} else {
						if ($shd->arb_pass == null && $shd->extra == 1) {
							$next_start_time = $shd->extra_time_start;

						} elseif ($shd->arb_pass == null && $shd->is_substitute == 1) {
							$next_start_time = $shd->substitute_start_time;

						} else {
							$next_start_time = $shd->arb_pass->start_time;

							//$sleep_confirmation=$ts->arb_pass->sleep_hour;

						}

					}

					shedulepass::where('id', $shd->id)->update(['work_start_time' => $next_start_time, 'device' => $req->device, 'location' => $req->location]);

				}
			} else {

				shedulepass::where('id', $req->emp_id)->update(['work_start_time' => $req->real_s_time, 'probable_stampling_start' => $req->now_time, 'reason_for_stampling_start' => $req->reason, 'device' => $req->device, 'location' => $req->location]);

			}

		} elseif ($req->time == 'out') {
			shedulepass::where('id', $req->emp_id)->update(['work_end_time' => $req->real_e_time, 'probable_stampling_end' => $req->now_time, 'reason_for_stampling_end' => $req->reason, 'device_out' => $req->device, 'location_out' => $req->location]);
		}
	}
	public function get_branch_wise_pass(Request $request) {
		$passes = pass::where('branch_id', $request->branch_id)->whereNull('night_pass_2')->get();
		$data = view('branch_list', compact('passes'));
		return $data;

	}
	public function asdf() {
		date_default_timezone_set('UTC');
		$today = carbon::today('Europe/Bratislava')->toDateString();
		$nowtime = carbon::now('Europe/Bratislava');
		$nowtime_strtotime = strtotime($nowtime);
		$shedue_pass = shedulepass::whereBetween('work_date', array('2018-12-12', Carbon::today('Europe/Bratislava')))->where('work_start_time', '!=', null)->where('work_end_time', null)->get();

		foreach ($shedue_pass as $lg) {

			if ($lg->change_start_time != null && $lg->change_end_time != null) {
				$start_time = $lg->change_start_time;
				$end_time = $lg->change_end_time;
			} else {
				if ($lg->arb_pass == null && $lg->extra == 1) {
					$start_time = $lg->extra_time_start;
					$end_time = $lg->extra_time_end;
				} elseif ($lg->arb_pass == null && $lg->is_substitute == 1) {
					$start_time = $lg->substitute_start_time;
					$end_time = $lg->substitute_end_time;
				} else {
					$start_time = $lg->arb_pass->start_time;
					$end_time = $lg->arb_pass->end_time;
				}
			}

			$start_time_before = strtotime("$lg->work_date $end_time:00");
			echo ($nowtime_strtotime - $start_time_before) . "<hr>";
			if (($nowtime_strtotime - $start_time_before) >= 144000) {

				shedulepass::where('id', $lg->id)->update(['work_end_time' => $end_time]);

			}

		}
	}

	/**
	 * @desc set start week
	 */

	public function setstratweek($value) {
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		//return $primarey_id;
		$key = "startvecka.$primarey_id";
		//dump(env(["app.sweet"=>23]));
		$abc = saveconfig("startvecka", [$key => $value]);
		dump($abc);
	}
	public function add_element($collection, $key_value = array()) {
		return array_merge($collection, $key_value);
	}
	public function remove_element($collection, $key = array()) {
		return $collection->except($key);

	}
	public function dayId($i) {
		if ($i != null) {
			if ($i == 6) {
				return '0';
			} else {
				return $i + 1;
			}
		}
		return 1;

	}

}