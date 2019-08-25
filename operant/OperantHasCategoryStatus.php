<?php
namespace App\operant;
use Illuminate\Database\Eloquent\Model;

class OperantHasCategoryStatus extends Model {
    protected $table='operant_has_categories_statuses';
    protected $connection = 'mysql_view';

}