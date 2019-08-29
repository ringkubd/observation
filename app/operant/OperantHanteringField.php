<?php
namespace App\operant;

use App\operant\OperantHanteringStatus;
use Illuminate\Database\Eloquent\Model;

class OperantHanteringField extends Model {
    protected $connection = 'mysql_view';

	public function OperantHanteringStatus() {
		return $this->hasMany(OperantHanteringStatus::class, 'field_id', 'id');
	}
}
