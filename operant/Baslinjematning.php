<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class Baslinjematning extends Model {
	protected $table = 'baslinjematning';
	protected $fillable = ['client_id','company_id','branch_id', 'created_by', 'updated_by', 'task_id', 'input_text', 'day_present', 'sub_base_id', 'attr_base_line', 'day_id', 'block_id'];

}