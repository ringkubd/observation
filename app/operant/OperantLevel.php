<?php

namespace App\operant;

use App\operant\OperantCategory;
use Illuminate\Database\Eloquent\Model;

class OperantLevel extends Model {
    protected $connection = 'mysql_view';

	public function OperantCategory() {
		return $this->hasMany(OperantCategory::class, 'level_id', 'level_id');
	}
}