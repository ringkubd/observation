<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class PriorityReason extends Model {
	protected $table = 'priority_reasons';
	protected $fillable = ['behave_id', 'client_id', 'created_by', 'updated_by', 'reason_category_id', 'task_id'];
	public function BehavioralRegistration() {
		return $this->hasOne(BehavioralRegistration::class, 'id', 'behave_id');
	}
}