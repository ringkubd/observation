<?php

namespace App\Http\Controllers\shcedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\branch as sb;
use App\branch as bb;
use App\branch;
use App\schedule\weekend;
use App\schedule\holyday;
use App\schedule\holydayasweekend;



class HolydayController extends Controller
{
    use sb;
    public function index()
    {
        $mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
		//sub branch as parent index
			$subbranchArray = [];
			$grandchildArray = [];

		if (count($sub_branch) > 0 ) 
		{
			
			$company_id	=	$this->companyid();

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
		$holyday= new holyday();
		$holyday=$holyday->holy_weekend($this->companyid(),$this->wherebranchid());

        return view('schedule.holyday_management.holyday',compact('grandchildArray','subbranchArray','branch','branch_name','mother_branch','holyday'));
    }
    public function holyday_store(Request $req)
    
    {
        $company_id	=$this->companyid();
        $holyday=new holyday();
        $holyday->holyday_insert($req,$company_id);
        session()->Flash('success_message', 'Holy day has been added');
		return redirect()->back();
		
    }
        
    
    
    public function holyday_update(Request $req)
    {
        $company_id	=$this->companyid();
        $holyday=new holyday();
        $holyday->holydayUpdate($req,$company_id);
        session()->Flash('success_message', 'Holy day has been updated');
		return redirect()->back();
        
    }
    public function delete($id)
    {
        
    }
    
    
    
    // Holyday as weckend
    public function holyday_as_weekend()
    {
        
        $mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
		//sub branch as parent index
			$subbranchArray = [];
			$grandchildArray = [];

		if (count($sub_branch) > 0 ) 
		{
			
			$company_id	=	$this->companyid();

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
		$wend = new holydayasweekend();
	   	$holy_day_as_weekend_data = $wend->retrive_holydayas_weekend($this->companyid(),$this->wherebranchid());
	   	


      return view('schedule.holyday_management.holyday_as_weekend',compact('grandchildArray','subbranchArray','branch','branch_name','mother_branch','holy_day_as_weekend_data'));

    }
    public function holydayasweekend_update(Request $req)
    {
        $company_id	=$this->companyid();
        $holydayasWeekend=new holydayasweekend();
        $holydayasWeekend->holyday_as_weekend_update($req,$company_id);
        session()->Flash('success_message', 'Holy day  as weekend has been updated');
		return redirect()->back();
    }
    
    
    // weekend
    
    public function weekend()
    {
         $mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
		//sub branch as parent index
			$subbranchArray = [];
			$grandchildArray = [];

		if (count($sub_branch) > 0 ) 
		{
			
			$company_id	=	$this->companyid();

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
		
		//retrive weekend
		$wend = new weekend();
		$weekend_data = $wend->retrive_weekend($this->companyid(),$this->wherebranchid());
		
		
        return view('schedule.holyday_management.weekend',compact('grandchildArray','subbranchArray','branch','branch_name','mother_branch','weekend_data'));
    }
    
    public function weekend_store(Request $request){
      
        $company_id	=$this->companyid();
       
        $weekend=new weekend();
        $weekend->insert_weekend($request,$company_id);
        session()->Flash('success_message','Weekend has been added');
	    return redirect()->back();
        
    }
    public function DeleteWeekend($id)
    { 
        $company_id	=$this->companyid();
        $weekend=new weekend();
        $weekend->weekendDelete($id,$company_id);
        session()->Flash('success_message', 'Weekend has been deleted');
		return redirect()->back();
        
    }
    public function upadate_weekend(Request $req)
    {
        $company_id	=$this->companyid();
        $weekend=new weekend();
        $weekend->weekend_update($req,$company_id);
        session()->Flash('success_message', 'Weekend has been updated');
		return redirect()->back();
        
    }
     public function holydayasweekend_store(Request $request)
    {
        $company_id	=$this->companyid();
        $holydayasweekend=new holydayasweekend();
        $holydayasweekend->insert_holydayasweekend($request,$company_id);
        session()->Flash('success_message','Weekend as holyday has been added');
	    return redirect()->back();
    }
    public function holydayasweekend_delete($id)
    {
        $company_id	=$this->companyid();
        $holydayasweekend=new holydayasweekend();
        $holydayasweekend->holydayasDelete($id,$company_id);
        session()->Flash('success_message', 'Holyday as weekend has been deleted');
		return redirect()->back();
    }
    
     public function holyday_delete($id)
    {
        $company_id	=$this->companyid();
        $holyday=new holyday();
        $holyday->holydayHolydayDelete($id,$company_id);
        session()->Flash('success_message', 'Holyday has been deleted');
		return redirect()->back();
    }
    
    
    
    
    
}
