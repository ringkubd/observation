<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class BaslinjematningFreeText extends Model {
	protected $table = 'baslinjematning_freetext';
	protected $fillable = ['client_id','company_id','branch_id', 'created_by', 'updated_by', 'task_id', 'input_text', 'day_present', 'sub_base_id', 'attr_base_line', 'block_id'];

}