<?php
namespace App\Http\Controllers\operant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\shcedule\traits\BranchTrait;
use App\Http\Controllers\shcedule\traits\UserTrait;
use App\Client;
use App\operant\Baslinjematning;
use App\operant\BaslinjematningDateField;
use App\operant\BaslinjematningFreeText;
use App\operant\BaslinjematningVecca;
use App\operant\BehavioralRegistration;
use App\operant\ExcessBehavior;
use App\operant\OperantComment;
use App\operant\PriorityReason;
use App\operant\PriorityReasonBehaveView;
use App\operant\PriorityReasonView;
use App\operant\Processteg7Tillampa;
use App\operant\Processteg8Utvardering;
use App\operant\PvReason;
use App\operant\SearchSolutionsOverskottsbeteenden;
use App\operant\TotalBlockBaseLine;
use App\operant\Underkottsbeteende;
use App\traits\CompanyTrait;
use Cache;
use DB;
use Illuminate\Http\Request;
use Session;

class OperantMasterController extends Controller {

    use BranchTrait, CompanyTrait, UserTrait;

    private $shcedule_branch;

    public function __construct() {

        //$this->middleware('has_permission');

    }

// needed
    public function verktygStep1Saving(Request $request) {
        if ($request->id == null && $request->input_text != null) {
            $inserted_value = BehavioralRegistration::create([
                'company_id' => $request->company_id,
                'branch_id' => $request->branch_id,
                'client_id' => $request->client_id,
                'stage_no' => $request->stage_no,
                'behave_time_type' => $request->behave_time_type,
                'behave_type' => $request->behave_type,
                'input_text' => $request->input_text,
                'created_by' => \Auth::user()->id,
            ]);
            $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
            $html = view('operant.operant_stag.stage1fieldTable', compact('behavioralRegistration'))->render();
            return ['inserted_value' => $inserted_value, 'delete' => 'not_done', 'update' => 'not_done', 'html' => $html];

        } else {
            $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
            $html = view('operant.operant_stag.stage1fieldTable', compact('behavioralRegistration'))->render();
            return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done', 'html' => $html];
        }

    }

    public function verktygStep1Editing(Request $request) {

        if ($request->input_text == null) {
            BehavioralRegistration::where('id', $request->id)->delete();
            $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
            $html = view('operant.operant_stag.stage1fieldTable', compact('behavioralRegistration'))->render();

            return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done', 'html' => $html];

        } else {
            BehavioralRegistration::where('id', $request->id)->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->update(['input_text' => $request->input_text]);
            $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
            $html = view('operant.operant_stag.stage1fieldTable', compact('behavioralRegistration'))->render();
            return ['inserted_value' => null, 'delete' => 'not_done', 'update' => 'done', 'html' => $html];
        }

    }

    //need

    public function verktyg() {
        $all_branch_of_login_user = $this->getallbranch_for_shedule();
        $primarey_id = current_branch();
        $client_info = Client::where('branch_id', $primarey_id)->get();
        //dd($primarey_id);
        return view('operant.operant', compact('client_info'));
    }

    public function verktyg_home_stage(Request $request) {
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        return view('operant.operant_stag.operant_home_stage', compact('request', 'client_info'));
    }
    public function verktygStep1(Request $request) {

        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
        $key_wise_behave = [];
        foreach ($behavioralRegistration as $key => $behave_value) {
            $key_wise_behave[$behave_value->behave_time_type . '_' . $behave_value->behave_type][] = $behave_value;
        }
        return view('operant.verktyg_step1', compact('client_info', 'request', 'behavioralRegistration', 'key_wise_behave'));
    }

    public function addRowFirstStage(Request $request) {
        return view('operant.operant_stag.behaviour_dynamic_row', compact('request'));
    }

    public function verktygStep2(Request $request) {

        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->get();
        $pv_reason = PvReason::with('BehavioralRegistration')->where('status', 1)->where('client_id', $request->client_id)->get();
        $key_wise_behave = [];
        foreach ($behavioralRegistration as $key => $behave_value) {
            $key_wise_behave[$behave_value->behave_time_type . '_' . $behave_value->behave_type][] = $behave_value;
        }
        return view('operant.verktyg_step2', compact('client_info', 'request', 'behavioralRegistration', 'key_wise_behave', 'pv_reason'));
    }

    public function SavePvReason(Request $request) {

        DB::beginTransaction();
        try {
            BehavioralRegistration::updateOrCreate(['id' => $request->behave_id], ['is_pv' => 1]);
            PvReason::updateOrCreate(['behave_id' => $request->behave_id], $request->all());
            DB::commit();
            $pv_reason = PvReason::with('BehavioralRegistration')->where('status', 1)->where('client_id', $request->client_id)->get();
            return view('operant.operant_stag.stage2reasonTable', compact('pv_reason'));
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

    }
    public function PvFilteringPrilly(Request $request) {

        DB::beginTransaction();
        try {
            BehavioralRegistration::where('id', $request->id)->update(['is_pv' => 0]);
            PvReason::where('behave_id', $request->id)->delete();
            DB::commit();
            $pv_reason = PvReason::with('BehavioralRegistration')->where('status', 1)->where('client_id', $request->client_id)->get();
            return view('operant.operant_stag.stage2reasonTable', compact('pv_reason'));
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

    }

    public function verktygStep3(Request $request) {

        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('is_pv', 0)->with('PriorityReason')->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $priyority_reason_status = PriorityReasonView::where('client_id', $request->client_id)->get();
        $key_wise_behave = [];
        foreach ($behavioralRegistration as $key => $behave_value) {
            $key_wise_behave[$behave_value->behave_time_type . '_' . $behave_value->behave_type][] = $behave_value;
        }
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }

        return view('operant.verktyg_step3', compact('client_info', 'request', 'behavioralRegistration', 'key_wise_behave', 'behavioralRegistration_category', 'reason_category_id', 'priyority_reason_status', 'task_id'));
    }

    public function verktygStep3Edit(Request $request) {
        //return $request->all();
        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'edit_add':
                    BehavioralRegistration::where('client_id', $request->client_id)->where('id', $request->behave_id)->where('is_complete','0')->update(['stage_no'=>3]);
                    $priyority_reason = PriorityReason::updateOrCreate(['id' => $request->id], $request->all());
                    $reason_id = $priyority_reason->id;
                    break;
                case 'delte':
                    BehavioralRegistration::where('client_id', $request->client_id)->where('id', $request->behave_id)->where('is_complete','0')->update(['stage_no'=> 2]);
                    PriorityReason::where('id', $request->id)->delete();
                    $reason_id = null;

                    break;

                default:
                    break;
            }
            DB::commit();
            $priyority_reason_status = PriorityReasonView::where('client_id', $request->client_id)->get();
            $html = view('operant.operant_stag.stage3priyorityTable', compact('priyority_reason_status'))->render();
            return ['reason_id' => $reason_id, 'html' => $html];
        } catch (\Exception $e) {
            DB::rollback();
            return dump($e);
            // something went wrong
        }

    }

    public function verktygStep3EditCategory(Request $request) {
        $priyority_reason = PriorityReason::where('task_id', $request->task_id)->update(['reason_category_id' => $request->reason_category_id]);
        $priyority_reason_status = PriorityReasonView::where('client_id', $request->client_id)->get();
        return view('operant.operant_stag.stage3priyorityTable', compact('priyority_reason_status'));
    }
    public function verktygStep4(Request $request) {
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',3)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $baseline = PriorityReasonView::where('client_id', $request->client_id)->with('TotalBlockBaseLine')->with('Baslinjematning')->with('BaslinjematningFreeText')->with('BaslinjematningDateField')->with('BaslinjematningVecca')->with('VeccaWiseBaselineData')->where('task_id', $task_id)->first();
        $default_base_line = TotalBlockBaseLine::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $task_id)->first();
        $baseline_array = [];
        $baseline_freetext_array = [];
        $baseline_date_array = [];
        $baseline_vecca_array = [];
        $baseline_graph_data = [];
        $baseline_graph_data_vecca = [];
        if (!empty($baseline)) {
            foreach ($baseline->Baslinjematning as $key => $value) {

                $baseline_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->day_id . '_' . $value->block_id] = $value;
            }

            foreach ($baseline->BaslinjematningFreeText as $key => $value) {

                $baseline_freetext_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningDateField as $key => $value) {

                $baseline_date_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningVecca as $key => $value) {

                $baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id] = $value;
            }
            foreach ($baseline->VeccaWiseBaselineData as $key => $value) {

                $baseline_graph_data[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
                $baseline_graph_data_vecca[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->block_id] = $value;
            }

        }
        $operantComment = OperantComment::get();
        $operantCommentArr = [];
        if (!empty($operantComment)) {
            foreach ($operantComment as $key => $value) {
                $operantCommentArr[$value->client_id . '_' . $value->branch_id . '_' . $value->block_id . '_' . $value->day_id] = $value;
            }
        }

        //return $baseline_freetext_array;
        return view('operant.verktyg_step4', compact('client_info', 'request', 'task_id', 'baseline', 'baseline_array', 'baseline_freetext_array', 'baseline_date_array', 'baseline_vecca_array', 'default_base_line', 'baseline_graph_data', 'baseline_graph_data_vecca','operantComment','operantCommentArr'));

    }


    public function AddVecca(Request $request){

        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',3)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $default_base_line = TotalBlockBaseLine::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $task_id)->first();
        $reason_category_id = '';
        $task_id = $request->task_id;
        $baseline = null;
        $baseline_array = [];
        $baseline_freetext_array = [];
        $baseline_date_array = [];
        $baseline_vecca_array = [];
        $baseline_graph_data = [];
        $baseline_graph_data_vecca = [];
        $loops=$request->block_id;
        $looplast=$request->block_id;
        $block_id=$block_id;

        $html = view('operant.operant_stag.vecca_dynamic_table', compact('client_info', 'behavioralRegistration_category', 'request', 'task_id', 'baseline', 'baseline_array', 'baseline_freetext_array', 'baseline_date_array', 'baseline_vecca_array', 'default_base_line', 'baseline_graph_data', 'baseline_graph_data_vecca','loops','looplast','block_id'))->render();
        return ['html' => $html];


    }

    public function ChangeDay(Request $request) {
        $client_info = client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',3)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $default_base_line = TotalBlockBaseLine::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $task_id)->first();
        $reason_category_id = '';
        $task_id = $request->task_id;
        $baseline = null;
        $baseline_array = [];
        $baseline_freetext_array = [];
        $baseline_date_array = [];
        $baseline_vecca_array = [];
        $baseline_graph_data = [];
        $baseline_graph_data_vecca = [];
        $loops=1;
        $looplast=1;
        $block_id=1;

        $html = view('operant.operant_stag.vecca_dynamic_table', compact('client_info', 'behavioralRegistration_category', 'request', 'task_id', 'baseline', 'baseline_array', 'baseline_freetext_array', 'baseline_date_array', 'baseline_vecca_array', 'default_base_line', 'baseline_graph_data', 'baseline_graph_data_vecca','loops','looplast','block_id'))->render();
        return ['html' => $html];
    }

    public function ChangeVecca(Request $request) {
        //return $request->all();
        if ($request->vecca1 != null) {
            BaslinjematningVecca::updateOrCreate(['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'task_id' => $request->task_id,'block_id' => $request->block_id], $request->all());
        } else {
            BaslinjematningVecca::where('client_id', $request->client_id)->where('company_id', $request->company_id)->where('task_id', $request->task_id)->where('block_id', $request->block_id)->delete();
        }
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',3)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $baseline = PriorityReasonView::where('client_id', $request->client_id)->with('TotalBlockBaseLine')->with('Baslinjematning')->with('BaslinjematningFreeText')->with('BaslinjematningDateField')->with('BaslinjematningVecca')->with('VeccaWiseBaselineData')->where('task_id', $task_id)->first();
        $default_base_line = TotalBlockBaseLine::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $task_id)->first();
        $baseline_array = [];
        $baseline_freetext_array = [];
        $baseline_date_array = [];
        $baseline_vecca_array = [];
        $baseline_graph_data = [];
        $baseline_graph_data_vecca = [];
        if (!empty($baseline)) {
            foreach ($baseline->Baslinjematning as $key => $value) {

                $baseline_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->day_id . '_' . $value->block_id] = $value;
            }

            foreach ($baseline->BaslinjematningFreeText as $key => $value) {

                $baseline_freetext_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningDateField as $key => $value) {

                $baseline_date_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningVecca as $key => $value) {

                $baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id] = $value;
            }
            foreach ($baseline->VeccaWiseBaselineData as $key => $value) {

                $baseline_graph_data[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
                $baseline_graph_data_vecca[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->block_id] = $value;
            }

        }
        $html = view('operant.operant_stag.vecca_dynamic_script', compact('client_info', 'behavioralRegistration_category', 'request', 'task_id', 'baseline', 'baseline_array', 'baseline_freetext_array', 'baseline_date_array', 'baseline_vecca_array', 'default_base_line', 'baseline_graph_data', 'baseline_graph_data_vecca'))->render();
        return ['html' => $html, 'default_base_line' => $default_base_line];
    }

    public function StoreDayBaseLine(Request $request) {
        //return $request->all();
        if ($request->input_text) {
            Baslinjematning::updateOrCreate(['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'task_id' => $request->task_id, 'block_id' => $request->block_id, 'attr_base_line' => $request->attr_base_line, 'day_id' => $request->day_id, 'day_present' => $request->day_present], $request->all());
        } else {
            Baslinjematning::where('client_id', $request->client_id)->where('company_id', $request->company_id)->where('task_id', $request->task_id)->where('block_id', $request->block_id)->where('attr_base_line', $request->attr_base_line)->where('day_id', $request->day_id)->where('day_present', $request->day_present)->delete();
        }
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',3)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $baseline = PriorityReasonView::where('client_id', $request->client_id)->with('TotalBlockBaseLine')->with('Baslinjematning')->with('BaslinjematningFreeText')->with('BaslinjematningDateField')->with('BaslinjematningVecca')->with('VeccaWiseBaselineData')->where('task_id', $task_id)->first();
        $default_base_line = TotalBlockBaseLine::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('task_id', $task_id)->first();
        $baseline_array = [];
        $baseline_freetext_array = [];
        $baseline_date_array = [];
        $baseline_vecca_array = [];
        $baseline_graph_data = [];
        $baseline_graph_data_vecca = [];
        if (!empty($baseline)) {
            foreach ($baseline->Baslinjematning as $key => $value) {

                $baseline_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->day_id . '_' . $value->block_id] = $value;
            }

            foreach ($baseline->BaslinjematningFreeText as $key => $value) {

                $baseline_freetext_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningDateField as $key => $value) {

                $baseline_date_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->day_present . '_' . $value->block_id] = $value;
            }
            foreach ($baseline->BaslinjematningVecca as $key => $value) {

                $baseline_vecca_array[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id. '_' . $value->block_id] = $value;
            }
            foreach ($baseline->VeccaWiseBaselineData as $key => $value) {

                $baseline_graph_data[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->attr_base_line . '_' . $value->block_id] = $value;
                $baseline_graph_data_vecca[$value->client_id . '_' . $value->branch_id . '_' . $value->task_id . '_' . $value->block_id] = $value;
            }

        }

        $html = view('operant.operant_stag.vecca_dynamic_script', compact('client_info', 'behavioralRegistration_category', 'request', 'task_id', 'baseline', 'baseline_array', 'baseline_freetext_array', 'baseline_date_array', 'baseline_vecca_array', 'default_base_line', 'baseline_graph_data', 'baseline_graph_data_vecca'))->render();
        return ['html' => $html, 'default_base_line' => $default_base_line];

    }

    public function StoreDayBaseLineFreeText(Request $request) {
        //return $request->all();
        if ($request->input_text) {
            BaslinjematningFreeText::updateOrCreate(['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'task_id' => $request->task_id, 'block_id' => $request->block_id, 'attr_base_line' => $request->attr_base_line, 'day_present' => $request->day_present], $request->all());
        } else {
            BaslinjematningFreeText::where('client_id', $request->client_id)->where('company_id', $request->company_id)->where('task_id', $request->task_id)->where('block_id', $request->block_id)->where('attr_base_line', $request->attr_base_line)->where('day_present', $request->day_present)->delete();
        }

    }

    public function StoreDayBaseLineDate(Request $request) {
        //return $request->all();
        if ($request->input_text) {
            BaslinjematningDateField::updateOrCreate(['client_id' => $request->client_id, 'company_id' => $request->company_id, 'branch_id' => $request->branch_id, 'task_id' => $request->task_id, 'block_id' => $request->block_id, 'day_present' => $request->day_present], $request->all());
        } else {
            BaslinjematningDateField::where('client_id', $request->client_id)->where('company_id', $request->company_id)->where('task_id', $request->task_id)->where('block_id', $request->block_id)->where('day_present', $request->day_present)->delete();
        }

    }

    public function StoreOperantComment(Request $request) {
        OperantComment::UpdateOrcreate([
            'client_id' => $request->client_id,
            'branch_id' => $request->branch_id,
            'company_id' => $request->company_id,
            'input_text' => $request->input_text,
            'day_id' => $request->day_id,
            'block_id' => $request->block_id,
            'stag_no' => $request->stag_no
        ], $request->all());
    }

    public function GetOperantComment(Request $request){
        return $operantComment = OperantComment::where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->where('day_id',$request->day_id)->where('block_id',$request->block_id)->where('stag_no',$request->stag_no)->first();
    }

    public function verktygStep5(Request $request) {
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=', 4)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $excess_behavior = PriorityReasonBehaveView::where('client_id', $request->client_id)->with('ExcessBehavior')->where('task_id', $task_id)->where('behave_type', 1)->first();
        $underkott_behavior = PriorityReasonBehaveView::where('client_id', $request->client_id)->with('Underkottsbeteende')->where('task_id', $task_id)->where('behave_type', 2)->first();

        return view('operant.verktyg_step5', compact('client_info', 'excess_behavior', 'request', 'underkott_behavior'));
    }
    public function OverskottsbeteendeStore(Request $request) {
        if (ExcessBehavior::updateOrCreate(['task_id' => $request->task_id], $request->all())) {
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','5')"));
            return '1';
        } else {
            return '0';
        }
    }


    public function UnderkottsbeteendeStore(Request $request) {
        if (Underkottsbeteende::updateOrCreate(['task_id' => $request->task_id], $request->all())) {
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','5')"));
            return '1';
        } else {
            return '0';
        }
    }

    public function verktygStep6(Request $request) {
        $client_info = client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=', 5)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $SearchSolutionsOv = PriorityReasonBehaveView::where('client_id', $request->client_id)->with('SearchSolutionsOverskottsbeteenden')->where('task_id', $task_id)->where('behave_type', 1)->first();
        $SearchSolutionsOv_result = [];
        if (!empty($SearchSolutionsOv)) {
            foreach ($SearchSolutionsOv->SearchSolutionsOverskottsbeteenden as $key => $ob_value) {
                $SearchSolutionsOv_result[$ob_value->road_type][] = $ob_value;
            }
        }
        return view('operant.verktyg_step6', compact('client_info', 'SearchSolutionsOv', 'request', 'SearchSolutionsOv_result', 'task_id'));
    }

    public function adRrowStage6(Request $request) {
        return view('operant.operant_stag.search_solution_dynamic_row', compact('request'));
    }

    public function verktygStep6Saving(Request $request) {
        if ($request->id == null && $request->input_text != null) {
            $inserted_value = SearchSolutionsOverskottsbeteenden::create([
                'company_id' => $request->company_id,
                'branch_id' => $request->branch_id,
                'client_id' => $request->client_id,
                'stage_no' => $request->stage_no,
                'task_id' => $request->task_id,
                'road_type' => $request->road_type,
                'search_solution' => $request->input_text,
                'created_by' => \Auth::user()->id,
            ]);
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','6')"));

            $html = [];
            return ['inserted_value' => $inserted_value, 'delete' => 'not_done', 'update' => 'not_done', 'html' => $html];

        } else {
            $html = [];
            return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done', 'html' => $html];
        }

    }

    public function verktygStep6Editing(Request $request) {

        if ($request->input_text == null) {
            SearchSolutionsOverskottsbeteenden::where('id', $request->id)->delete();
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','5')"));

            return ['inserted_value' => null, 'delete' => 'done', 'update' => 'not_done', 'html' => []];

        } else {
            SearchSolutionsOverskottsbeteenden::where('id', $request->id)->where('client_id', $request->client_id)->where('branch_id', $request->branch_id)->where('company_id', $request->company_id)->update(['search_solution' => $request->input_text, 'is_checked' => $request->is_checked]);
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','6')"));
            return ['inserted_value' => null, 'delete' => 'not_done', 'update' => 'done', 'html' => []];
        }

    }

    public function verktygStep7(Request $request) {
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',6)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(task_id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $Processteg7Tillampas = PriorityReasonView::where('client_id', $request->client_id)->with('Processteg7Tillampa')->where('task_id', $task_id)->first();
        return view('operant.verktyg_step7', compact('client_info', 'request', 'Processteg7Tillampas', 'task_id'));
    }

    public function verktygStep7Store(Request $request) {
        //return $request->all();
        if (Processteg7Tillampa::updateOrCreate(['task_id' => $request->task_id], $request->all())) {
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','7')"));
            return '1';
        } else {
            return '0';
        }
    }

    public function verktygStep8(Request $request) {
        $client_info = Client::where('branch_id', $request->branch_id)->get();
        $behavioralRegistration_category = BehavioralRegistration::where('client_id', $request->client_id)->where('is_complete',0)->where('stage_no', '>=',7)->where('is_pv', 0)->with('PriorityReasonGroupBy')->get();
        $reason_category_id = '';
        $task_id = '';
        foreach ($behavioralRegistration_category as $key => $behave_value) {
            if ($behave_value->PriorityReasonGroupBy != null) {
                $reason_category_id = $behave_value->PriorityReasonGroupBy->reason_category_id;
                $task_id = $behave_value->PriorityReasonGroupBy->task_id;
            }

        }
        if ($task_id == null || $task_id == '') {
            $task_id_field = PriorityReason::selectRaw('max(task_id) as task_id')->get();
            $task_id = ($task_id_field[0]->task_id ?? 0) + 1;
        }
        $Processteg8Utvarderings = PriorityReasonView::where('client_id', $request->client_id)->with('Processteg8Utvardering')->where('task_id', $task_id)->first();

        return view('operant.verktyg_step8', compact('client_info', 'request', 'Processteg8Utvarderings', 'task_id'));
    }

    public function verktygStep8Store(Request $request) {
        //return $request->all();
        if (Processteg8Utvardering::updateOrCreate(['task_id' => $request->task_id], $request->all())) {
            DB::select(DB::raw("call update_stage('$request->client_id','$request->task_id','8')"));
            return '1';
        } else {
            return '0';
        }
    }

}
