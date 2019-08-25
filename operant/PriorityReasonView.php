<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class PriorityReasonView extends Model {
	protected $connection = 'mysql_view';
	protected $table = 'priority_reasons_view';

	public function ExcessBehavior() {
		return $this->hasOne(ExcessBehavior::class, 'task_id', 'task_id');
	}
	public function Underkottsbeteende() {
		return $this->hasOne(Underkottsbeteende::class, 'task_id', 'task_id');
	}

	public function SearchSolutionsOverskottsbeteenden() {
		return $this->hasMany(SearchSolutionsOverskottsbeteenden::class, 'task_id', 'task_id');
	}

	public function Processteg7Tillampa() {
		return $this->hasOne(Processteg7Tillampa::class, 'task_id', 'task_id');
	}
	public function Processteg8Utvardering() {
		return $this->hasOne(Processteg8Utvardering::class, 'task_id', 'task_id');
	}

	public function TotalBlockBaseLine() {
		return $this->hasMany(TotalBlockBaseLine::class, 'task_id', 'task_id');
	}
	public function Baslinjematning() {
		return $this->hasMany(Baslinjematning::class, 'task_id', 'task_id');
	}

	public function BaslinjematningFreeText() {
		return $this->hasMany(BaslinjematningFreeText::class, 'task_id', 'task_id');
	}

	public function BaslinjematningDateField() {
		return $this->hasMany(BaslinjematningDateField::class, 'task_id', 'task_id');
	}
	public function BaslinjematningVecca() {
		return $this->hasMany(BaslinjematningVecca::class, 'task_id', 'task_id');
	}

	public function VeccaWiseBaselineData() {
		return $this->hasMany(VeccaWiseBaselineData::class, 'task_id', 'task_id');
	}

	public function BehavioralRegistration() {
		return $this->hasMany(BehavioralRegistration::class, 'id', 'behave_id');
	}

	

}