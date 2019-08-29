<?php
namespace App\Helpers;

/**
 * @Author: anwar
 * @Date:   2017-12-22 10:06:51
 * @Last Modified by:   anwar
 * @Last Modified time: 2017-12-22 10:23:54
 */

class RemoveSpecialCharector{

	public static function removeNonCharector(string $string)
	{
	    $stringArray       = str_split($string);
	    $nonCharectorArray = ['!','@','$','%','^','&','*','(',')','-','_','#'];

	    $diffData = array_intersect($stringArray, $nonCharectorArray);
	    $diffBlankArray = [];
	    foreach ($diffData as $key=>$value) {
	        $diffBlankArray[$key]=" ";
	    }
	    $finalArray = array_replace($stringArray, $diffBlankArray);
	    return implode('',$finalArray);
	    //$
	}

}


