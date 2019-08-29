<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;

class ClientWiseOperantCategoryConfig extends Model {
    protected $table = 'client_wise_operant_category_configs';
    protected $connection = 'mysql_view';

    protected $fillable = ['level_id', 'category_id', 'main_category', 'field_id','field_name','company_id', 'branch_id', 'client_id'];
    public function OperantHanteringStatus() {
        return $this->hasMany(OperantHanteringStatus::class, 'field_id', 'id');
    }


}




