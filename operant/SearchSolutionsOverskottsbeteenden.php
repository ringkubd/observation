<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class SearchSolutionsOverskottsbeteenden extends Model {
	protected $table = 'search_solutions_overskottsbeteenden';
	protected $fillable = ['task_id', 'client_id', 'branch_id', 'company_id', 'status', 'created_by', 'updated_by', 'question_1', 'road_type', 'search_solution', 'is_checked'];

}