<?php
//namespace App\helper;
use App\DefTran;
use App\OrganizationTranslation;
use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\Auth;

function orgtran($tag) {
	$req = new Request();
	//$image = app('App\helper\orgtran');
	//return coid();
	$key = 'orgtran' . coid();
	Cache::remember($key, 1000, function () {
		return $orgtranall = OrganizationTranslation::where('company_id', coid())->get();
	});

	$deftrant = 'deftrant' . orgtype();

	Cache::remember($deftrant, 1000, function () {
		return DefTran::where('organization_type_id', orgtype())->get();
	});
	//Cache::forget('deftrant');
	//Cache::forget($key);
	$allorgdata = Cache::get($key);
	$predefined = Cache::get($deftrant);

	$orgtranarray = [];

	$predefarray = [];

	foreach ($predefined as $predef) {
		$predefarray[$predef->keyword] = $predef->value;
	}

	foreach ($allorgdata as $org) {
		$orgtranarray[$org->keyword] = $org->value;
	}

	if (array_key_exists($tag, $orgtranarray)) {

		return $orgtranarray[$tag];

	} elseif (array_key_exists($tag, $predefarray)) {

		return $predefarray[$tag];
	}
	return $tag;
}
