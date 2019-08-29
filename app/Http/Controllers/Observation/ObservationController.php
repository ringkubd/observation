<?php
namespace App\Http\Controllers\Observation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\shcedule\traits\BranchTrait;
use App\Http\Controllers\shcedule\traits\UserTrait;
use App\User;
use App\Branch as bb;
use App\Client as client;
use App\observation\ObservationStag10;
use App\observation\ObservationStag10Cat;
use App\observation\ObservationStag10CatPercentage;
use App\observation\ObservationStag11;
use App\observation\ObservationStag12;
use App\observation\ObservationStag13;
use App\observation\ObservationStag1;
use App\observation\ObservationStag2;
use App\observation\ObservationStag2Archive;
use App\observation\ObservationStag3;
use App\observation\ObservationStag4;
use App\observation\ObservationStag5;
use App\observation\ObservationStag5Cat;
use App\observation\ObservationStag6;
use App\observation\ObservationStag7;
use App\observation\ObservationStag7Cat;
use App\observation\ObservationStag8;
use App\observation\ObservationStag8Cat;
use App\observation\ObservationStagComment;
use App\observation\SocialFardigheter50;
use App\traits\CompanyTrait;
use Auth;
use Illuminate\Http\Request;
use Session;

class ObservationController extends Controller {
	use BranchTrait, CompanyTrait, UserTrait;
	private $shcedule_branch;
	public function __construct() {
		//$this->middleware('has_permission');
	}
	public function branch_id() {

		$defaultbranch = bb::whereIsdelete("0")->first();

		if (Auth::check()) {
			$empdefbranch = explode(',', Auth::user()->branch_id);
			if (session()->has('branch')) {
				$value = session('branch');
				return $value;
			} elseif (is_array($empdefbranch) && count($empdefbranch) == 0) {
				return "0";
			} elseif (!empty($empdefbranch)) {
				return $empdefbranch[0];
			} else {
				return '0';
			}
		} elseif (Auth::guard('owner')->check()) {
			if (session()->has('branch') && session()->get('parent_branhc') != 'all') {
				$value = session('branch');
				return $value;

			} elseif (is_array($defaultbranch) && count($defaultbranch) == 0) {
				return "0";
			} elseif (isset($defaultbranch)) {

				return $defaultbranch->id;
			} else {
				return '0';
			}
		}
	}
	public function wherebranchid() {
		$parent_branch = session()->get('parent_branch');

		if ($parent_branch == 'all') {

				$employeebranch = Auth::user()->branch->pluck('id')->toArray();

				//$eb = explode(',', $employeebranch->branch_id);
				return ['whereIn', $employeebranch];


		} elseif ($parent_branch == "") {
			return ['whereNotIn', []];
		} else {
			$barray = [$this->branch_id()];
			return ['whereIn', $barray];
		}
	}
	public function index() {

		$branchidwhere = $this->wherebranchid();
		$condition = $branchidwhere[0];
		$client_info = client::$condition('branch_id', $this->wherebranchid()[1])->get();

		return view('observation.observation', compact('client_info', 'request'));
	}
	public function observationHomeStage(Request $request) {
		$client_info = client::where('branch_id', $request->branch_id)->get();
		return view('observation.observation_stag.step_list', compact('request', 'client_info', 'request'));
	}
	public function observationStep1(Request $request) {
		$items = config('observation');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$ObservationStag1 = ObservationStag1::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->where('client_id', $request->client_id)->get();
		$observationArray = [];
		$observationsum = [];
		foreach ($ObservationStag1 as $key => $value) {
			$observationArray[$value->task_id . '_' . $value->sub_task_id] = $value;
			$observationsum[$value->task_id][] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->where('stag', 1)->first();
		//return $observationArray;
		return view('observation.observationStep1', compact('client_info', 'items', 'request', 'observationArray', 'observationsum', 'ObservationStag1', 'observationComment'));
	}

	public function SaveObservationStag1(Request $request) {
		if ($request->input_text == null) {
			ObservationStag1::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->delete();
		} else {
			ObservationStag1::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'task_id' => $request->task_id, 'sub_task_id' => $request->sub_task_id], $request->all());
		}
		$ObservationStag1 = ObservationStag1::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->where('client_id', $request->client_id)->get();
		$observationArray = [];
		$observationsum = [];
		foreach ($ObservationStag1 as $key => $value) {
			$observationArray[$value->task_id . '_' . $value->sub_task_id] = $value;
			$observationsum[$value->task_id][] = $value->input_text ?? 0;
		}
		return view('observation.observation_stag.stag1_dynamic_graph', compact('request', 'observationArray', 'observationsum', 'ObservationStag1'));

	}
	public function SaveObservationStag1radio(Request $request) {
		// return $request;
		$sub_task_id = [3, 4, 5];
		ObservationStag1::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'task_id' => $request->task_id, 'sub_task_id' => $request->sub_task_id], $request->all());
		$subtask_id = array_diff($sub_task_id, [$request->sub_task_id]);
		ObservationStag1::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $request->task_id)->whereIn('sub_task_id', $subtask_id)->delete();

	}

	public function observationStep2(Request $request) {
		$items = config('ObservationStagTwo');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('input_text', '>', 0)->get();
		$observation_value = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_2.*")->where('input_text', '>', 0)->groupBy(['adl_id', 'adl_type'])->get();
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 2)->first();
		return view('observation.observationStep2', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment'));
	}

	public function observationStep3(Request $request) {
		//return $request;
		$items = config('ObservationStagTwo');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('input_text', '>', 0)->get();
		$observation_value = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_2.*")->where('input_text', '>', 0)->groupBy(['adl_id', 'adl_type'])->get();

		$observation_archive_value = ObservationStag2Archive::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_2_archive.*")->where('input_text', '>', 0)->groupBy(['graph'])->get();

		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		//dump($observation_graph_data);
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 3)->first();
		return view('observation.observationStep3', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment', 'observation_archive_value'));
	}

	public function observation_archive_show(Request $request) {
		$items = config('ObservationStagTwo');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation_archive = ObservationStag2Archive::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('input_text', '>', 0)->where('graph', $request->graph)->get();

		$observation_archive_value = ObservationStag2Archive::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_2_archive.*")->where('input_text', '>', 0)->where('graph', $request->graph)->groupBy(['adl_id', 'adl_type'])->get();

		//dump($observation_archive_value);

		$observation_graph_data = [];
		foreach ($observation_archive_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		$observation_single_value = [];
		foreach ($observation_archive as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 3)->first();
		return view('observation.observationStep3Archive', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment', 'observation_archive_value'));
	}

	public function StoreobservationStep3(Request $request) {

		ObservationStag2::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'attr_day_id' => $request->attr_day_id], $request->all());

		$observation_value = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_2.*")->where('input_text', '>', 0)->groupBy(['adl_id', 'adl_type'])->get();

		$items = config('ObservationStagTwo');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		return view('observation.observation_stag.stag3_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data'));
	}

	public function observation_stag_3_archive_store(Request $request) {
		$observation_stage_3_value = ObservationStag2::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get()->toArray();

		$last_graph = ObservationStag2Archive::orderBy('graph', 'desc')->select('graph')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->first();

		$observation_stage_3_value_arr = [];
		foreach ($observation_stage_3_value as $key => $value) {
			$observation_stage_3_value_arr[$key] = $value;
			$observation_stage_3_value_arr[$key]['graph'] = $last_graph->graph + 1;

			ObservationStag2::find($value['id'])->delete();
		}
		// echo '<pre>';
		// print_r($observation_stage_3_value_arr);
		// exit;
		ObservationStag2Archive::insert($observation_stage_3_value_arr);
	}

	public function observationStep4(Request $request) {
		$items = config('ObservationStagThree');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag3::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('input_text', '>', 0)->get();
		$observation_value = ObservationStag3::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("AVG(NULLIF(input_text ,0)) as day_value,observation_stag_3.*")->groupBy(['adl_id', 'adl_type'])->get();
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 4)->first();
		return view('observation.observationStep4', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment'));
	}

	public function StoreobservationStep4(Request $request) {
		ObservationStag3::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'attr_day_id' => $request->attr_day_id], $request->all());

		$observation_value = ObservationStag3::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_3.*")->where('input_text', '>', 0)->groupBy(['adl_id', 'adl_type'])->get();
		$items = config('ObservationStagThree');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		return view('observation.observation_stag.stag4_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data'));
	}

	public function observationStep5(Request $request) {
		$items = config('ObservationStagFour');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag4::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('input_text', '>', 0)->get();
		$observation_value = ObservationStag4::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_4.*")->groupBy(['adl_id', 'adl_type'])->where('input_text', '>', 0)->get();
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 5)->first();
		return view('observation.observationStep5', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment'));
	}

	public function StoreobservationStep5(Request $request) {
		ObservationStag4::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'attr_day_id' => $request->attr_day_id], $request->all());

		$observation_value = ObservationStag4::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_4.*")->where('input_text', '>', 0)->groupBy(['adl_id', 'adl_type'])->get();
		$items = config('ObservationStagFour');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		return view('observation.observation_stag.stag5_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data'));
	}

	public function observationStep6(Request $request) {
		$items = config('ObservationStagFive');
		$items_heading = config('ObservationStagFiveHeading');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag5::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->orderBy('adl_id', 'asc')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$cat_count = ObservationStag5Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 6)->first();
		//return $observation_single_value;
		return view('observation.observationStep6', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data_cat', 'observation_graph_data', 'observation_single_value', 'items_heading', 'observationComment', 'observation_single_cat_value'));
	}

	public function StoreobservationStep6(Request $request) {
		ObservationStag5::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'adl_sub_type' => $request->adl_sub_type], $request->all());

		$observation_value = ObservationStag5::get();
		$items = config('ObservationStagFive');
		$items_heading = config('ObservationStagFiveHeading');
		$cat_count = ObservationStag5Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag5::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		$observation_single_value = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		return view('observation.observation_stag.stag6_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data', 'items_heading', 'observation_graph_data_cat', 'observation_single_cat_value'));
	}

	public function observationStep7(Request $request) {
		$items = config('ObservationStagSix');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag6::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_value = ObservationStag6::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("sum(input_text)/7 as day_value,observation_stag_6.*")->groupBy(['adl_type'])->get();
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type] = $value;
		}
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id . '_' . $value->attr_day_id] = $value->input_text ?? 0;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 7)->first();
		return view('observation.observationStep7', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment'));

	}

	public function StoreobservationStep7(Request $request) {

		ObservationStag6::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'attr_day_id' => $request->attr_day_id], $request->all());

		$observation_value = ObservationStag6::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("sum(input_text)/7 as day_value,observation_stag_6.*")->groupBy(['adl_type'])->get();
		$items = config('ObservationStagFour');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type] = $value;
		}
		return view('observation.observation_stag.stag7_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data'));
	}

	public function observationStep8(Request $request) {
		$items = config('ObservationStagSeven');
		$items_heading = config('ObservationStagSevenHeading');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag7::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->orderBy('adl_id', 'asc')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$cat_count = ObservationStag7Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$SocialFardigheter50 = SocialFardigheter50::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		$SocialFardigheter50value = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		foreach ($SocialFardigheter50 as $key => $value) {
			$SocialFardigheter50value[$value->adl_type] = $value;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 7)->first();
		//return $observation_single_value;
		return view('observation.observationStep8', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data_cat', 'observation_graph_data', 'observation_single_value', 'items_heading', 'observationComment', 'observation_single_cat_value', 'SocialFardigheter50value'));

	}

	public function StoreobservationStep8(Request $request) {
		ObservationStag7::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'adl_sub_type' => $request->adl_sub_type], $request->all());

		$observation_value = ObservationStag7::get();
		$items = config('ObservationStagSeven');
		$items_heading = config('ObservationStagSevenHeading');
		$cat_count = ObservationStag7Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag7::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$SocialFardigheter50 = SocialFardigheter50::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		$observation_single_value = [];
		$SocialFardigheter50value = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		foreach ($SocialFardigheter50 as $key => $value) {
			$SocialFardigheter50value[$value->adl_type] = $value;
		}
		return view('observation.observation_stag.stag8_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data', 'items_heading', 'observation_graph_data_cat', 'observation_single_cat_value', 'SocialFardigheter50value'));
	}

	public function observationStep9(Request $request) {
		$items = config('ObservationStagEight');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag8::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_value = ObservationStag8Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type] = $value;
		}
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_id] = $value->input_text ?? null;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 9)->first();

		//return$observation_single_value;
		return view('observation.observationStep9', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment'));

	}

	public function StoreobservationStep9(Request $request) {

		ObservationStag8::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'attr_day_id' => $request->attr_day_id], $request->all());

		$observation_value = ObservationStag8Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$items = config('ObservationStagThree');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type] = $value;
		}
		return view('observation.observation_stag.stag9_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data'));
	}

	public function StoreobservationComment(Request $request) {

		ObservationStagComment::UpdateOrcreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'stag' => $request->stag], $request->all());
	}

	public function observationStep10(Request $request) {
		$items = config('ObservationStagTen');
		$items_heading = config('ObservationStagTenHeading');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag10::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->orderBy('adl_id', 'asc')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->get();
		$cat_count = ObservationStag10Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$cat_indivisual_percentage = ObservationStag10CatPercentage::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		$indivisual_percentage = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		$observation_single_value = [];
		$total_value_field = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
			if ((($value->input_text1 == 1) || ($value->input_text2 == 1) || ($value->input_text3 == 1) || ($value->input_text4 == 1) || ($value->input_text4 == 1)) == true) {
				$total_value_field[$value->adl_type . '_' . $value->adl_sub_type][] = 1;
			}
		}

		foreach ($cat_indivisual_percentage as $key => $value) {
			$indivisual_percentage[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 6)->first();
		return view('observation.observationStep10', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data_cat', 'observation_graph_data', 'observation_single_value', 'items_heading', 'observationComment', 'observation_single_cat_value', 'indivisual_percentage', 'total_value_field'));
	}

	public function StoreobservationStep10(Request $request) {
		// return $request->all();

		ObservationStag10::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'adl_sub_type' => $request->adl_sub_type], $request->all());

		$observation_value = ObservationStag5::get();
		$items = config('ObservationStagTen');
		$items_heading = config('ObservationStagTenHeading');
		$cat_count = ObservationStag10Cat::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag10::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$cat_indivisual_percentage = ObservationStag10CatPercentage::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_graph_data_cat = [];
		$observation_graph_data = [];
		$observation_single_cat_value = [];
		$observation_single_value = [];
		$indivisual_percentage = [];
		$total_value_field = [];
		foreach ($cat_count as $key => $value) {
			$observation_graph_data_cat[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
			$observation_single_cat_value[$value->adl_type . '_' . $value->adl_sub_type][] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);

			if ((($value->input_text1 == 1) || ($value->input_text2 == 1) || ($value->input_text3 == 1) || ($value->input_text4 == 1) || ($value->input_text4 == 1)) == true) {
				$total_value_field[$value->adl_type . '_' . $value->adl_sub_type][] = 1;
			}
		}
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_type . '_' . $value->adl_id] = $value;
		}
		foreach ($cat_indivisual_percentage as $key => $value) {
			$indivisual_percentage[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}
		//dump($total_value_field);
		return view('observation.observation_stag.stag10_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data', 'items_heading', 'observation_graph_data_cat', 'observation_single_cat_value', 'indivisual_percentage', 'total_value_field'));
	}

	public function observationStep11(Request $request) {
		$items = config('ObservationStagEleven');
		$itemsUnique = config('ObservationStagElevenUnique');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag11::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();

		$observation_value = ObservationStag11::orderBy('adl_id', 'asc')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_11.*")->where('input_text', '>', 0)->groupBy(['adl_sub_type', 'adl_id'])->get();

		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_sub_type . '_' . $value->adl_id] = $value->day_value;
		}

		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value->input_text ?? 0;
		}
		//dump($observation_graph_data);
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 11)->first();
		return view('observation.observationStep11', compact('client_info', 'request', 'items', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'observationComment', 'itemsUnique'));
	}

	public function StoreobservationStep11(Request $request) {
		ObservationStag11::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'adl_sub_type' => $request->adl_sub_type], $request->all());

		$observation = ObservationStag11::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$observation_value = ObservationStag11::orderBy('adl_sub_type', 'asc')->orderBy('adl_id', 'asc')->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->selectRaw("avg(input_text) as day_value,observation_stag_11.*")->where('input_text', '>', 0)->groupBy(['adl_sub_type', 'adl_id'])->get();
		$items = config('ObservationStagEleven');
		$itemsUnique = config('ObservationStagElevenUnique');
		$observation_graph_data = [];
		foreach ($observation_value as $key => $value) {
			$observation_graph_data[$value->adl_sub_type . '_' . $value->adl_id] = $value->day_value;
		}

		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value->input_text ?? 0;
		}
		return view('observation.observation_stag.stag11_dynamic_graph', compact('request', 'items', 'observation_value', 'observation_graph_data', 'itemsUnique'));
	}

	public function observationStep12(Request $request) {
		$items_heading = config('ObservationStagTwelveHeading');
		$client_info = client::whereCompany_id($request->company_id)->where('branch_id', $request->branch_id)->get();
		$observation = ObservationStag12::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();

		if (count($observation) == 0) {

			$create_array = [];
			for ($i = 1; $i <= 4; $i++) {
				for ($j = 1; $j <= 7; $j++) {
					if ($j <= 5) {
						$create_array[] = ['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'adl_type' => 1, 'adl_id' => $j, 'adl_sub_type' => $i, 'input_text1' => 1, 'input_text2' => 1, 'input_text3' => 1, 'input_text4' => 1, 'input_text5' => 1, 'input_text6' => 1, 'input_text7' => 1];
					} else {
						$create_array[] = ['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'adl_type' => 1, 'adl_id' => $j, 'adl_sub_type' => $i, 'input_text1' => 1, 'input_text2' => 1, 'input_text3' => 1, 'input_text4' => 1, 'input_text5' => 1, 'input_text6' => null, 'input_text7' => null];
					}

				}

			}
			ObservationStag12::insert($create_array);
			$observation = ObservationStag12::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		}

		$observation_value = [];
		$observation_valueblock = [];
		$observation_valuetotal = [];
		$observation_graph_data = [];
		$observation_graph_data_block = [];
		$observation_graph_data_total = [];
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
		}
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', '12')->first();
		//return $observation_single_value;
		return view('observation.observationStep12', compact('client_info', 'request', 'observation_value', 'observation_graph_data', 'observation_graph_data', 'observation_single_value', 'items_heading', 'observationComment', 'observation_graph_data_block', 'observation_graph_data_total'));
	}

	public function StoreobservationStep12(Request $request) {

		ObservationStag12::updateOrCreate(['client_id' => $request->client_id, 'branch_id' => $request->branch_id, 'company_id' => $request->company_id, 'adl_type' => $request->adl_type, 'adl_id' => $request->adl_id, 'adl_sub_type' => $request->adl_sub_type], $request->all());

		$observation_value = [];
		$observation_valueblock = [];
		$observation_valuetotal = [];
		$observation = ObservationStag12::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->get();
		$items_heading = config('ObservationStagTwelveHeading');
		$observation_graph_data = [];
		$observation_graph_data_total = [];
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type . '_' . $value->adl_id] = $value;
		}
		return view('observation.observation_stag.stag12_dynamic_graph', compact('observation_single_value', 'request', 'items_heading', 'observation_value', 'observation_graph_data', 'observation_graph_data_block', 'observation_graph_data_total'));
	}

	public function observationStep13(Request $request) {
		//return $this->branch_id();
		// return $request;
		$items_heading = config('ObservationStagthirteenHeading');
		$observation = ObservationStag13::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->where('branch_id', $this->branch_id())->get();
		$observation_graph = ObservationStag13::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->where('branch_id', $this->branch_id())->where('status',1)->get();
		$observation_graph_data = [];
		foreach ($observation_graph as $key => $value) {
			$observation_graph_data[$value->adl_type][$value->adl_sub_type] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		$adl_type_count = [];
		$cat_indivisual_percentage = [];
		foreach ($observation_graph_data as $key => $value) {
			$adl_type_count[$key] = count($value);
			$cat_indivisual_percentage[$key] = array_count_values($value);
		}

		$observation_value = [];
		$observation_single_value = [];
		foreach ($observation as $key => $value) {
			$observation_value[$value->adl_type][$value->adl_type . '_' . $value->adl_sub_type] = $value;
			$observation_single_value[$value->adl_type . '_' . $value->adl_sub_type] = $value;
		}

		$avg = 0;
		for($j=1;$j<=7;$j++){
			if(array_key_exists($j, $observation_graph_data)){
				$avg += (array_sum($observation_graph_data[$j]) / ($adl_type_count[$j]*3)*100);
			}
		}
		$avg = $avg/7;

		// dump($avg);
		// dump($observation_graph_data);
		// dump($adl_type_count);
		// dump($cat_indivisual_percentage);
		$observationComment = ObservationStagComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('stag', 6)->first();
		return view('observation.observationStep13', compact('observation', 'request', 'observation_value', 'observation_graph_data','observation_single_value', 'items_heading','adl_type_count','cat_indivisual_percentage','observationComment','avg'));
	}

	public function addRowStage13(Request $request) {
		return view('observation.observation_stag.dynamic_row_stag13', compact('request'));
	}

	public function observation_stage_13_store(Request $request){
		// return $request;
		if (!empty($request->input_text)) {
			ObservationStag13::updateOrCreate(['branch_id' => $request->branch_id, 'company_id' => $request->company_id,'adl_type'=>$request->adl_type,'adl_sub_type' => $request->adl_sub_type], $request->all());
		}

		$items_heading = config('ObservationStagthirteenHeading');
		$observation = ObservationStag13::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->where('branch_id', $this->branch_id() )->get();
		$observation_graph = ObservationStag13::orderBy('adl_type', 'asc')->orderBy('adl_sub_type', 'asc')->where('branch_id', $this->branch_id())->where('status',1)->get();
		$observation_graph_data = [];
		foreach ($observation_graph as $key => $value) {
			$observation_graph_data[$value->adl_type][$value->adl_sub_type] = (($value->input_text1 ?? 0) * 0) + (($value->input_text2 ?? 0) * 1) + (($value->input_text3 ?? 0) * 2) + (($value->input_text4 ?? 0) * 3);
		}
		$adl_type_count = [];
		$cat_indivisual_percentage = [];
		foreach ($observation_graph_data as $key => $value) {
			$adl_type_count[$key] = count($value);
			$cat_indivisual_percentage[$key] = array_count_values($value);
		}

		$avg = 0;
		for($j=1;$j<=7;$j++){
			if(array_key_exists($j, $observation_graph_data)){
				$avg += (array_sum($observation_graph_data[$j]) / ($adl_type_count[$j]*3)*100);
			}
		}
		$avg = $avg/7;

		return view('observation.observation_stag.stag13_dynamic_graph', compact('items_heading','observation_graph_data', 'adl_type_count','cat_indivisual_percentage','avg'));
	}
}
