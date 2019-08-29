<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag10CatPercentage extends Model {
	protected $table = 'calculate_percentage_10_stag';
	protected $connection = 'mysql_view';

}