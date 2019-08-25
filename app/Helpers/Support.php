<?php
if(!function_exists('getAcollectionKeyAsArray')){
    function getAcollectionKeyAsArray($collection,$key,$value){
        if (is_null($collection) || empty($collection)){
            return null;
        }
        $array = [];
        foreach ($collection as $v){
            $array[$v->{$key}] = $v->{$value};
        }
        return $array;
    }
}


if (!function_exists("current_branch")){
    function current_branch(){
        if (auth()->check()) {
            $empdefbranch = auth()->user()->branch->pluck("id")->toArray();

            if (session()->has('branch')) {

                $value = session('branch');
                return $value;

            } elseif (is_array($empdefbranch) && count($empdefbranch) == 0) {

                return "0";

            } elseif (!empty($empdefbranch)) {

                return $empdefbranch[0];

            } else {
                return '0';
            }

        }
    }
}

if (!function_exists("where_branch_id")){
    function where_branch_id(){
        $parent_branch = session()->get('parent_branch');

        if ($parent_branch == 'all') {
            if (auth::check()) {
                $eb = auth()->user()->branch()->pluck("id")->toArray();
                return ['whereIn', $eb];
            }
            return ['whereNotIn', []];

        } elseif ($parent_branch == "") {
            return ['whereNotIn', []];
        } else {
            $barray = [current_branch()];
            return ['whereIn', $barray];
        }
    }
}