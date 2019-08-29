<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class PriorityReasonBehaveView extends Model {
	protected $connection = 'mysql_view';
	protected $table = 'priority_reasons_behave_view';

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

}