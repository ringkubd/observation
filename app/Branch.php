<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\RedisControlModel;

class Branch extends RedisControlModel
{
    protected $table = "branches";
    public $redisKeys = "_branches";

    //protected $fillable = ["company_id", "branch_name", "parent_branch", "is_grand_child", "email", "mobile", "address", "emergency_mobile"];
    protected $fillable = ["branch_name", "company_id", "parent_branch", "is_grand_child", "email", "mobile", "address", "emergency_mobile"];





    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('isdelete', '0');
    }

    public function parent(){
        return $this->hasOne(Branch::class,'id','parent_branch');
    }
}
