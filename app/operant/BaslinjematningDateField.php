<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class BaslinjematningDateField extends Model {
	protected $table = 'baslinjematning_date_field';
	protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by', 'task_id', 'input_text', 'day_present', 'block_id'];

}