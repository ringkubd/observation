<?php

namespace App\operant;

use Illuminate\Database\Eloquent\Model;
use Auth;

class OperantComment extends Model
{
    protected $table = 'operant_comments';
    protected $fillable = ['client_id', 'company_id', 'branch_id', 'created_by', 'updated_by','input_text','day_id','block_id', 'stag_no'];
    // public static function boot() {
    //     parent::boot();
    //     static::updating(function($table) {
    //         $table->updated_by = Auth::user()->id;
    //     });


    //     static::saving(function($table) {
    //         $table->created_by = Auth::user()->id;
    //         $table->updated_by = Auth::user()->id;
    //     });
    // }
}
