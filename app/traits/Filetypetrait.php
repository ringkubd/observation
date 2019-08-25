<?php 
namespace App\Traits;
use Illuminate\Http\Request;

/**
 * @Author: anwar
 * @Date:   2017-11-14 09:30:03
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-11-22 01:32:29
 */
/**
 * summary
 */
//use App\Traits\CompanyTrait;
use App\Traits\branch;
use App\branch as bb;
use App\FileType;

trait Filetypetrait
{

    public function filetype_index()
    {
    	$mother_branch = $this->__getAllBranch();
		$sub_branch    = $this->subbrachforaorganization();
        $subbranchArray = [];
        $grandchildArray = [];
		if (count($sub_branch) > 0 ) 
		{
			//sub branch as parent index
			
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
        $branch = $this->wherebranchid();
        $condition = $branch[0];
		$company_id = $this->companyid();
		$filetype = FileType::whereCompany_id($company_id)->$condition('branch_id',$branch[1])->with('branch')->get();
		$branch_name=$this->get_branch_name();
		
	    $m_branch =  $this->__getAllBranch();
       if(isset($m_branch) && count($m_branch) == 0)
       {
           $mother_branch = $this->__getAllBranch();
       }

        return view('dashboard.filetype',compact('filetype','mother_branch','subbranchArray','grandchildArray','branch_name'));
    }


    public function filetype_store(Request $req)
    {
       
    	$this->validate($req, [
                'name' => 'required',
                'bandmembers' => 'required'
        ]);
       

		$company_id = $this->companyid();
	
		try {

			$i=0;
			//return dump($req->bandmembers);
// 			foreach($req->name as $ftype){
			    
			foreach ($req->bandmembers as $branch) 
			{
			  
			    
				$filetypestore =  FileType::create(['name'=>$req->name,'branch_id'=>$branch,'company_id'=>$company_id,'colour_code'=>$req->chosen_value]);
			}

		

			return back()->with('message','File type has been created');

		} catch (Exception $e) 
		{
			return back()->with('message',$e);
		}
		
    }

    /*
    *
    *return ajax branch information
    */

    public function filetype_edit(Request $req)
    {
    	if ($req->ajax()) 
    	{
    		$filetypeinfo = FileType::find($req->id);
    		$filetypeinfos=view('dashboard.file_type_edit_modal',compact('filetypeinfo'));
    		return $filetypeinfos;
    	}else
    	{
    		return "You dont have access";
    	}
    	
    }


    public function filetype_update(Request $req)
    {
    	$this->validate($req, [
                'filetypename' => 'required'
        ]);

    	$id = $req->filetypeid;
    	$name = $req->filetypename;
    	$filetype = FileType::find($id);

    	$filetype->name = $name;
    	$filetype->colour_code=$req->chosen_value;
    	if($filetype->save())
		{
			return back()->with('message','File type has been updated');
		}else{
			return back()->with('message','there is something wrong');
		}

    	
    }

    public function filetype_delete(Request $req)
    {
    	if($req->ajax())
    	{
    		$filetypeinfo = FileType::destroy($req->id);
    		if ($filetypeinfo) 
    		{

                 session()->flash('message','File type has been deleted');
    			return 'success';
    		}else{
    			return 'error';
    		}
    	}
    }

    public function retrive_all_file_type_under_company($company_id,$branch_id){
          return FileType::whereCompany_id($company_id)->whereBranch_id($branch_id)->get();
    }
}