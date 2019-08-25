<?php

namespace App;

use App\Helpers\RedisControlModel;
use Illuminate\Database\Eloquent\Model;

class Employee extends RedisControlModel
{
    protected $table = "users";
    protected $queryId = "employee_branch";
}
