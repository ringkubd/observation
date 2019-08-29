<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 1/20/2019
 * Time: 1:33 PM
 */
use App\helper\FileLoader;
if(!function_exists('saveconfig')){
    function saveconfig($file,array $conf){
        $configpath = config_path($file.".php");
        if (!file_exists($configpath)){
            abort(404,"file not found");
        }
        $fp = fopen($configpath , 'w');
        config($conf);
        return fwrite($fp, '<?php return ' . var_export(config($file), true) . ';');
    }

}
//dashboard lock show

if (!function_exists('lockShow')){
    function lockShow($permission){
        if (\Auth::guard('owner')->check()) {
            if (!$permission) {
                return "lock show";
            }
        }

    }
}

