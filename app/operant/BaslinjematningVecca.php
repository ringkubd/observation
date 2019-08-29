<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class BaslinjematningVecca extends Model {
	protected $table = 'baslinjematning_vecca';
	protected $fillable = ['client_id', 'company_id','block_id', 'branch_id', 'created_by', 'updated_by', 'task_id', 'vecca1', 'vecca2'];

}