<?php

namespace App\Http\Controllers\shcedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\branch as sb;
use App\branch as bb;
use App\branch;
use App\schedule\working_time_hour_rate as workingRate;
use App\schedule\manual_time_hour_compnay as ManualTime;


class WorkingTimeManagementController extends Controller
{
    use sb;
    
    
    
    public function index()
    {
        $mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
		//sub branch as parent index
			$subbranchArray = [];
			$grandchildArray = [];
			$company_id	=	$this->companyid();

		if (count($sub_branch) > 0 ) 
		{
			
			

			foreach ($sub_branch as $value) 
			{
				if ($value['is_grand_child'] == 0) 
				{
					$subbranchArray[$value['parent_branch']] = bb::whereIsdelete("0")->whereCompany_id($company_id)->where('parent_branch','=',$value['parent_branch'])->get()->toArray();
				}

				if ($value['is_grand_child'] == 1) 
				{
					$grandchildArray[$value['parent_branch']] = bb::whereIsdelete("0")->whereCompany_id($company_id)->where('parent_branch','=',$value['parent_branch'])->get()->toArray();
				}

			}
		}
		
		$branch_name=$this->get_branch_name();
		$brancha = new branch();
		$branch = $brancha->childBrances($this->companyid());
		$working_rate=new workingRate();
		$get_working_rate=$working_rate->getWorking_rate($company_id);
		
         return view('schedule.working_time_management.working_time_management',compact('grandchildArray','subbranchArray','branch','branch_name','mother_branch','get_working_rate'));
    }
    public function manualinsertForm()
    {
        $mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
		//sub branch as parent index
			$subbranchArray = [];
			$grandchildArray = [];
			$company_id	=	$this->companyid();

		if (count($sub_branch) > 0 ) 
		{
			
			

			foreach ($sub_branch as $value) 
			{
				if ($value['is_grand_child'] == 0) 
				{
					$subbranchArray[$value['parent_branch']] = bb::whereIsdelete("0")->whereCompany_id($company_id)->where('parent_branch','=',$value['parent_branch'])->get()->toArray();
				}

				if ($value['is_grand_child'] == 1) 
				{
					$grandchildArray[$value['parent_branch']] = bb::whereIsdelete("0")->whereCompany_id($company_id)->where('parent_branch','=',$value['parent_branch'])->get()->toArray();
				}

			}
		}
		
		$branch_name=$this->get_branch_name();
		$brancha = new branch();
		$branch = $brancha->childBrances($this->companyid());
		$manulTime=new ManualTime();
      $branch = $this->wherebranchid();
      $condition = $branch[0];

        $get_manual_shift=$manulTime->getManualtime($company_id);
      
		return view('schedule.working_time_management.working_time_management_post',compact('grandchildArray','subbranchArray','branch','branch_name','mother_branch','get_manual_shift'));
        
    }
    public function store_working_time(Request $req)
    {   $company_id	=	$this->companyid();
        $working_rate=new workingRate();
        if($req->week_bandmembers!=null)
        {
            foreach($req->week_bandmembers as $week_branch)
            {  
                
                $week_extra_pay_hour=$req->week_extra_pay_hour!=null?$req->week_extra_pay_hour:'0'; 
                $week_extra_pay_per=$req->week_extra_pay_per!=null?$req->week_extra_pay_per:'0'; 
                $working_rate->insert_work_rate($company_id,$week_branch,'Weekend',$week_extra_pay_hour,$week_extra_pay_per); 
            }
        }
        if($req->hw_bandmembers!=null)
        {
            foreach($req->hw_bandmembers as $hw_branch)
            {  $hw_extra_pay_hour=$req->hw_extra_pay_hour!=null?$req->hw_extra_pay_hour:'0'; 
               $hw_extra_pay_per=$req->hw_extra_pay_per!=null?$req->hw_extra_pay_per:'0'; 
               $working_rate->insert_work_rate($company_id,$hw_branch,'Holyday_as',$hw_extra_pay_hour,$hw_extra_pay_per); 
            }
        }
        if($req->holy_bandmembers!=null)
        {
            foreach($req->holy_bandmembers as $holy_branch)
            {  $holy_extra_pay_hour=$req->holy_extra_pay_hour!=null?$req->holy_extra_pay_hour:'0'; 
               $holy_extra_pay_per=$req->holy_extra_pay_per!=null?$req->holy_extra_pay_per:'0'; 
               $working_rate->insert_work_rate($company_id,$holy_branch,'Holyday',$holy_extra_pay_hour,$holy_extra_pay_per); 
            }
        }
        if($req->sleep_bandmembers!=null)
        {
            foreach($req->sleep_bandmembers as $sleep_branch)
            {  $sleep_extra_pay_hour=$req->sleep_extra_pay_hour!=null?$req->sleep_extra_pay_hour:'0'; 
               $sleep_extra_pay_per=$req->sleep_extra_pay_per!=null?$req->sleep_extra_pay_per:'0';
               $working_rate->insert_work_rate($company_id,$sleep_branch,'Sleep',$sleep_extra_pay_hour,$sleep_extra_pay_per); 
            }
        }
        if($req->sw_bandmembers!=null)
        {
            foreach($req->sw_bandmembers as $sleep_as_branch)
            {  $sw_extra_pay_hour=$req->sw_extra_pay_hour!=null?$req->sw_extra_pay_hour:'0'; 
               $sw_extra_pay_per=$req->sw_extra_pay_per!=null?$req->sw_extra_pay_per:'0';
               $working_rate->insert_work_rate($company_id,$sleep_as_branch,'Sleep_as',$req->sw_extra_pay_hour,$req->sw_extra_pay_per); 
            }
        }
        session()->Flash('success_message', 'Working rate has been added');
        return back();
    }
    public function delete_work_rate($id)
    { $company_id	=	$this->companyid();
      $working_rate=new workingRate();
      $working_rate->deleteWorkingRate($id,$company_id);
      session()->Flash('success_message', 'Working rate has been deleted');
      return back();
    }
    public function update_work_rate(Request $req)
    { $company_id	=	$this->companyid();  
      $working_rate=new workingRate();
      $working_rate->update_workingRate($req,$company_id);
      session()->Flash('success_message', 'Working rate has been updated');
      return back();
    }
    
    public function insertManulTime(Request $req)
    {   
        $company_id	=	$this->companyid();
        $manulTime=new ManualTime();
        if($req->bandmembers!=null)
        {
            foreach($req->bandmembers as $branch)
            {
               $manulTime->insert_manual_time($req,$company_id,$branch); 
            }
        }
        session()->Flash('success_message', 'Working shift has been added');
        return back();
       
        
    }
    public function update_manul_time(Request $req){
      $company_id	=	$this->companyid();  
      $manulTime=new ManualTime();
      $manulTime->updateManulTime($req,$company_id);
      session()->Flash('success_message', 'Working shift has been updated');
      return back();
    }
    public function delete_manual_time($id)
    { $company_id	=	$this->companyid();
      $manulTime=new ManualTime();
      $manulTime->deleteManualTime($id,$company_id);
      session()->Flash('success_message', 'Working shift has been deleted');
      return back();
    }
    
    
    
}
