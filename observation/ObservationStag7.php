<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag7 extends Model {
	protected $table = 'observation_stag_7';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by', 'adl_type', 'adl_id','adl_sub_type','input_text1','input_text2','input_text3','input_text4','item'];

}