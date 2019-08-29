<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class Processteg8Utvardering extends Model {
	protected $table = 'processteg8_utvardering';
	protected $fillable = ['task_id', 'client_id', 'branch_id', 'company_id', 'status', 'created_by', 'updated_by', 'question_1', 'question_2', 'question_3'];

}