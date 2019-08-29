<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class ExcessBehavior extends Model {
	protected $table = 'excess_behaviors';
	protected $fillable = ['task_id', 'client_id', 'branch_id', 'company_id', 'status', 'created_by', 'updated_by', 'question_1', 'question_2', 'question_3', 'question_4', 'question_5', 'question_6', 'question_7', 'question_8'];

}