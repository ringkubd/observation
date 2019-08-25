<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class OperantHanteringStatus extends Model {
	protected $table = 'operant_hantering_statues';
	protected $connection = 'mysql_view';

	protected $fillable = ['level_id', 'category_id', 'field_id', 'status', 'complete_status', 'company_id', 'branch_id', 'client_id'];
}