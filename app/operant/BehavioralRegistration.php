<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class BehavioralRegistration extends Model {
	protected $table = 'behavioral_registrations';
	protected $fillable = ['client_id', 'branch_id', 'company_id', 'behave_time_type', 'behave_type', 'input_text', 'is_pv', 'pv_reason', 'status', 'created_by', 'stage_no'];
	public function PvReason() {
		return $this->hasOne(PvReason::class, 'behave_id', 'id');
	}

	public function PriorityReason() {
		return $this->hasOne(PriorityReason::class, 'behave_id', 'id');
	}
	public function PriorityReasonGroupBy() {
		return $this->hasOne(PriorityReason::class, 'behave_id', 'id')->groupBy('reason_category_id');
	}
}