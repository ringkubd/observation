<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStagComment extends Model {
	protected $table = 'observation_stag_comment';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by','input_text', 'item', 'stag'];

}