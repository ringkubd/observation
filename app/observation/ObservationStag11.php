<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag11 extends Model {
	protected $table = 'observation_stag_11';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by', 'adl_type', 'adl_id', 'input_text', 'item', 'adl_sub_type'];

}