<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag1 extends Model {
	protected $table = 'observation_stag_1';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by', 'task_id','sub_task_id', 'input_text','ja','nej'];

}