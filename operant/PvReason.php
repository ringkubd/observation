<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class PvReason extends Model {
	protected $table = 'pv_reasons';
	protected $fillable = ['behave_id', 'inervention', 'utforare', 'stardatum', 'ovrigt', 'created_by', 'updated_by', 'client_id'];
	public function BehavioralRegistration() {
		return $this->hasOne(BehavioralRegistration::class, 'id', 'behave_id');
	}
}