<?php
if (!function_exists("yesNo")){
    function yesNo($tinyVal){
        switch ($tinyVal){
            case "1":
                return "Yes";
            case "0":
                return "No";
        }
    }
}