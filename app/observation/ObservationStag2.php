<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag2 extends Model {
	protected $table = 'observation_stag_2';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by', 'adl_type','adl_id', 'input_text','item','attr_day_id'];

}