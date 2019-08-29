<?php

namespace App\operant;

use App\operant\OperantHanteringField;
use Illuminate\Database\Eloquent\Model;

class OperantCategory extends Model {
    protected $connection = 'mysql_view';

	public function OperantHanteringField() {
		return $this->hasMany(OperantHanteringField::class, 'category_id', 'category_id');
	}
    public function ClientWiseOperantCategoryConfig() {
        return $this->hasMany(ClientWiseOperantCategoryConfig::class, 'category_id', 'category_id')->where('status',1);
    }
    public function ClientWiseOperantCategoryConfigWithNotActive() {
        return $this->hasMany(ClientWiseOperantCategoryConfig::class, 'category_id', 'category_id');
    }
}
