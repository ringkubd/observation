<?php

namespace App\observation;

use Illuminate\Database\Eloquent\Model;

class ObservationStag12BlockTotal extends Model {
	protected $table = 'observation_12_block_sum';
	protected $connection = 'mysql_view';

}