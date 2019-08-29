<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag13 extends Model {
	protected $table = 'observation_stag_13';
	protected $fillable = ['company_id', 'branch_id', 'created_by', 'updated_by','adl_type','adl_sub_type','status','input_text','input_text1','input_text2','input_text3','input_text4','item'];

}