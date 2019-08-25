<?php

/**
 * @Author:Hasnat
 * @Date:   2017-10-23 22:51:25
 * @Last Modified by:   Hasnat
 * @Last Modified time: 2017-10-23 22:51:25
 */
namespace App\traits;
use Illuminate\Http\Request;
use App\Event;

trait specialNoteTraits{



/**********************************@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@********************************************************************
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Retrive Priority report for Employeee start@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
****************************************************************************************************************************************************
*/
	public static function Notes($priority=null,$startDate,$paginate,$company_id=null,$branch_id)
	{
	    $condition = $branch_id[0];
	return 	$todaysnotes=Event::where('priority',$priority)->where('start_date',$startDate)->where('company_id',$company_id)->$condition('branch_id',$branch_id[1])->paginate($paginate,['*'], 'todaysnotes');

}


/**********************************@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@********************************************************************
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Retrive Priority report for Employeee end @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
****************************************************************************************************************************************************
*/

/**********************************@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@********************************************************************
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ Retrive All report for Employeee  start @@ @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
****************************************************************************************************************************************************
*/
public static function Notes_all($startDate,$paginate=30,$company_id,$branch_id)
{
    $condition = $branch_id[0];
	return 	$todaysnotes=Event::where('start_date','=',$startDate)->where('company_id',$company_id)->$condition('branch_id',$branch_id[1])->with('users')->with('user')->with('report_comment')->paginate($paginate);

}


/**********************************@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@********************************************************************
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@Retrive All report for Employeee end @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
****************************************************************************************************************************************************
*/




public static function notes_allForemployee($paginate=10,$like=null){
	$number_of_week=1;
	 $start_date=date("Y-m-d");
	 $enddate='2017-11-11';
	 // $stro=strtotime($start_date)-$adding_date;
	 //  $time = date("Y-m-d",$stro);
	
	return 	$todaysnotes=Event::where('end_date',$enddate)->where('start_date','<=',$enddate)->paginate($paginate);
	return 	$todaysnotes=Event::where('end_date',null)->where('start_date','>=',$time)->paginate($paginate);

}




}
