<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class Processteg7Tillampa extends Model {
	protected $table = 'processteg7_tillampa';
	protected $fillable = ['task_id', 'client_id', 'branch_id', 'company_id', 'status', 'created_by', 'updated_by', 'question_1', 'question_2', 'question_3'];

}