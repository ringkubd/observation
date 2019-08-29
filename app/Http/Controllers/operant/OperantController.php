<?php
namespace App\Http\Controllers\operant;
use App\client;
use App\Http\Controllers\Controller;
use App\Http\Controllers\shcedule\traits\BranchTrait;
use App\Http\Controllers\shcedule\traits\UserTrait;
use App\operant\ClientWiseLevelConfigVasRealConfiguration;
use App\operant\ClientWiseOperantCategoryConfig;
use App\operant\OperantLevel;
use App\traits\CompanyTrait;
use Cache;
use DB;
use Illuminate\Http\Request;
use PDF;
use Session;

class OperantController extends Controller {

	use BranchTrait, CompanyTrait, UserTrait;

	private $shcedule_branch;

	public function __construct() {

		//$this->middleware('has_permission');

	}
	public function index() {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		//dump($primarey_id);
		return view('operant.operant');
	}
	public function status() {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$client_info = client::where('branch_id', $primarey_id)->with('GenerateOperantStatus')->with('OperantHasCategoryStatus')->get();
		//return dump($client_info);
		return view('operant.status', compact('client_info'));
	}

	public function export_pdf() {
		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$client_info = client::where('branch_id', $primarey_id)->with('GenerateOperantStatus')->get();

		$pdf = PDF::loadView('operant.status_pdf', compact('client_info'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('status.pdf');
		return $pdf->download('status.pdf');
	}
	
	public function kardex() {
		return view('operant.kardex');
	}

	public function hantering() {

		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$client_info = client::where('branch_id', $primarey_id)->get();
		return view('operant.hantering', compact('client_info'));
	}

	public function operantHantering() {

		$datakey = "data" . coid();
		Cache::forget($datakey);
		$all_branch_of_login_user = $this->getallbranch_for_shedule();
		if (Session::has('schema_branch_id')) {
			$primarey_id = Session::get('schema_branch_id');
		} else {
			$primarey_id = $all_branch_of_login_user[0]['id'];
		}
		$client_info = client::where('branch_id', $primarey_id)->get();

		$info = OperantLevel::with(['OperantCategory' => function ($q) use ($client, $company, $branch) {
			$q->with(['OperantHanteringField' => function ($q) use ($client, $company, $branch) {
				$q->with(['OperantHanteringStatus' => function ($q) use ($client, $company, $branch) {
					$q->where('client_id', $client);
					$q->where('company_id', $company);
					$q->where('branch_id', $branch);
				}]);
			}]);
		}])->get();

		return view('operant.operant_hantering', compact('client_info', 'info'));
	}

	public function GetHanteringField(Request $request) {

		$client = $request->client_id;
		$company = $request->company_id;
		$branch = $request->branch_id;
		$level1 = 0;
		$level2 = 0;
		$level3 = 0;
		$client_info = client::where('id', $client)->whereCompany_id($company)->where('branch_id', $branch)->first();
		$clientCategoryConfig = ClientWiseOperantCategoryConfig::where('client_id', $client)->where('company_id', $company)->where('branch_id', $branch)->get();
		if (count($clientCategoryConfig) == 0) {
			DB::select(DB::raw("call insert_into_client_config('$client','$branch','$company')"));
		}
		$level_active = ClientWiseLevelConfigVasRealConfiguration::whereColumn('config_percentage', 'status_percentage')->where('client_id', $client)->get();
		if (count($level_active) > 0) {
			foreach ($level_active as $level) {
				if ($level->level_id == 1) {
					$level1 = 100;
				}
				if ($level->level_id == 2) {
					$level2 = 100;
				}
				if ($level->level_id == 3) {
					$level3 = 100;
				}
			}
		}
		$level_active_array = ['1' => $level1, '2' => $level2, '3' => $level3];

		$info = OperantLevel::with(['OperantCategory' => function ($q) use ($client, $company, $branch) {
			$q->with(['ClientWiseOperantCategoryConfig' => function ($q) use ($client, $company, $branch) {
				$q->where('client_id', $client);
				$q->where('company_id', $company);
				$q->where('branch_id', $branch);
				$q->with(['OperantHanteringStatus' => function ($q) use ($client, $company, $branch) {
					$q->where('client_id', $client);
					$q->where('company_id', $company);
					$q->where('branch_id', $branch);
				}]);
			}]);
		}])->get();
		if ($request->pdf) {
			//return view('operant.hantering_pdf', compact('info', 'request', 'level_active_array','client_info'));

			$pdf = PDF::loadView('operant.hantering_pdf', compact('info', 'request', 'level_active_array', 'client_info'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream('hantering-status.pdf');
		}

		return view('operant.hantering_list', compact('info', 'request', 'level_active_array', 'client_info'));

	}

	public function GetOperantHanteringField(Request $request) {
		$client = $request->client_id;
		$company = $request->company_id;
		$branch = $request->branch_id;
		$level1 = 0;
		$level2 = 0;
		$level3 = 0;
		$client_info = client::where('id', $client)->whereCompany_id($company)->where('branch_id', $branch)->first();
		$clientCategoryConfig = ClientWiseOperantCategoryConfig::where('client_id', $client)->where('company_id', $company)->where('branch_id', $branch)->get();
		if (count($clientCategoryConfig) == 0) {
			DB::select(DB::raw("call insert_into_client_config('$client','$branch','$company')"));
		}
		$level_active = ClientWiseLevelConfigVasRealConfiguration::whereColumn('config_percentage', 'status_percentage')->where('client_id', $client)->get();
		if (count($level_active) > 0) {
			foreach ($level_active as $level) {
				if ($level->level_id == 1) {
					$level1 = 100;
				}
				if ($level->level_id == 2) {
					$level2 = 100;
				}
				if ($level->level_id == 3) {
					$level3 = 100;
				}
			}
		}
		$level_active_array = ['1' => $level1, '2' => $level2, '3' => $level3];

		$info = OperantLevel::with(['OperantCategory' => function ($q) use ($client, $company, $branch) {
			$q->with(['ClientWiseOperantCategoryConfigWithNotActive' => function ($q) use ($client, $company, $branch) {
				$q->where('client_id', $client);
				$q->where('company_id', $company);
				$q->where('branch_id', $branch);
				$q->with(['OperantHanteringStatus' => function ($q) use ($client, $company, $branch) {
					$q->where('client_id', $client);
					$q->where('company_id', $company);
					$q->where('branch_id', $branch);
				}]);
			}]);
		}])->get();

		if ($request->pdf) {
			//return view('operant.operant_hantering_pdf', compact('info', 'request', 'level_active_array','client_info'));
			$pdf = PDF::loadView('operant.operant_hantering_pdf', compact('info', 'request', 'level_active_array', 'client_info'));
			$pdf->setPaper('A4', 'landscape');
			return $pdf->stream('hantering-status.pdf');
		}

		return view('operant.operant_hantering_list', compact('info', 'request', 'level_active_array', 'client_info'));

	}

	public function StoreHantering(Request $request) {

		if ($request->field_value == 0) {
			$status = 0;
		} elseif ($request->field_value == 33) {
			$status = 33;
		} elseif ($request->field_value == 67) {
			$status = 67;
		} elseif ($request->field_value == 100) {
			$status = 100;
		}
		$operant_status = new \App\operant\OperantHanteringStatus();
		$operant_info = $operant_status->where('client_id', $request->client_id)->where('field_id', $request->field_id)->where('level_id', $request->field_level)->where('category_id', $request->field_category)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->first();

		if (!empty($operant_info)) {
			$operant_info->status = $status;
			$operant_info->save();

		} else {
			$operant_status->client_id = $request->client_id;
			$operant_status->field_id = $request->field_id;
			$operant_status->level_id = $request->field_level;
			$operant_status->category_id = $request->field_category;
			$operant_status->company_id = $request->company_id;
			$operant_status->branch_id = $request->branch_id;
			$operant_status->status = $status;
			$operant_status->save();

		}
		$level_active = ClientWiseLevelConfigVasRealConfiguration::where('level_id', $request->field_level)->whereColumn('config_percentage', 'status_percentage')->where('client_id', $request->client_id)->first();
		if (!empty($level_active)) {
			return 'next_step';
		}

	}

	public function ChangeOperantStatus(Request $request) {
		$client_category_config = ClientWiseOperantCategoryConfig::where('id', $request->field_id)->where('level_id', $request->level_id)->where('category_id', $request->category_id)->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->first();
		if (!empty($client_category_config)) {
			$client_category_config->status = $request->change_value;
			$client_category_config->save();
		}

		$operant_status = new \App\operant\OperantHanteringStatus();
		$operant_info = $operant_status->where('client_id', $request->client_id)->where('field_id', $request->field_id)->where('level_id', $request->level_id)->where('category_id', $request->category_id)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->first();
		if (!empty($operant_info)) {
			$operant_info->active = $request->change_value;
			$operant_info->save();
		}

	}
	public function ChangeOperantStatusAll(Request $request) {
		//return $request->all();
		$category_array = [1 => [1, 6, 11], 2 => [2, 7, 12], 3 => [3, 8, 13], 4 => [4, 9, 14], 5 => [5, 10, 15]];
		$client_category_config = ClientWiseOperantCategoryConfig::whereIn('category_id', $category_array[$request->category_id])->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->update(['status' => $request->change_value]);
		$operant_status = new \App\operant\OperantHanteringStatus();
		$operant_info = $operant_status->where('client_id', $request->client_id)->whereIn('category_id', $category_array[$request->category_id])->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->update(['active' => $request->change_value]);

		return 'done';
	}

	public function AddNewCategoryField(Request $request) {
		return view('operant.dynamic_operant_field_row', compact('request'));

	}

	public function StoreClientWiseCategry(Request $request) {
		if ($request->field_id == null && $request->field_value != null) {
			$inserted_value = ClientWiseOperantCategoryConfig::create([
				'company_id' => $request->company_id,
				'branch_id' => $request->branch_id,
				'client_id' => $request->client_id,
				'level_id' => $request->level_id,
				'category_id' => $request->category_id,
				'field_name' => $request->field_value,
			]);
			return ['inserted_value' => $inserted_value, 'delete' => 'not_done', 'update' => 'not_done'];

		} else {
			return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done'];
		}

	}

	public function EditClientWiseCategry(Request $request) {

		if ($request->field_value == null) {
			$operant_status = new \App\operant\OperantHanteringStatus();
			$operant_info = $operant_status->where('client_id', $request->client_id)->where('field_id', $request->field_id)->where('category_id', $request->category_id)->where('company_id', $request->company_id)->where('branch_id', $request->branch_id)->delete();
			ClientWiseOperantCategoryConfig::where('id', $request->field_id)->where('category_id', $request->category_id)->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->delete();
			return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done'];

		} else {
			ClientWiseOperantCategoryConfig::where('id', $request->field_id)->where('category_id', $request->category_id)->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->update(['field_name' => $request->field_value]);
			return ['inserted_value' => null, 'delete' => 'not_done', 'update' => 'done'];
		}

	}

}