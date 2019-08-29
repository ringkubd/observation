<?php

use GuzzleHttp\Client;

if (!function_exists('checkChecked')) {
	function checkChecked($value) {
		return isset($value) ? 1 : 0;

	}
}

if (!function_exists('checked')) {
	function checked($value1, $value2) {
		return $value1 == $value2 ? 'checked' : null;

	}
}
if (!function_exists('selected')) {
	function selected($value1, $value2) {
		return $value1 == $value2 ? 'selected' : null;

	}
}

if (!function_exists("sendSmsHelper")) {
	function sendSmsHelper($rcver, $sender, $message, $ac = null, $pw = null) {
		$baseurl = "http://smsserver.pixie.se/sendsms?";
		$account = "account=11711686";
		$password = "pwd=KwVNOmEL";
		$reciver = "receivers=" . $rcver;
		$sender = "sender=" . $sender;
		$message = "message=" . $message;
		$url = $baseurl . $account . "&" . $password . "&" . $reciver . "&" . $sender . "&" . $message;
		$client = new Client();
		return $client->get($url);
	}
}

if (!function_exists("NowBefore")) {
	//behave time type
	function NowBefore($index) {
		$now_before = ['Nutid', 'Dåtid'];

		return $now_before[$index] ?? null;
	}
}

if (!function_exists("BehaveType")) {
	//behave time type
	function BehaveType($index) {
		$Behave_Type = ['Överskottsbeteenden', 'Underskottsbeteenden', 'Tillgångar'];
		return $Behave_Type[$index] ?? null;
	}
}

if (!function_exists("Prioriteringsskal")) {
	//behave time type
	function Prioriteringsskal($index) {
		$Behave_Type = ['A', 'B', 'C', 'D'];
		return $Behave_Type[$index] ?? null;
	}
}
if (!function_exists("Baslinjematning")) {
	//behave time type
	function Baslinjematning($index) {
		$baseline = ['Frekvens, snitt per dag - primäraxel', 'Duration, snitt per tillfälle, sekundäraxel', 'Intensitet, I', 'Intensitet, II', 'Intensitet, III', 'Intensitet, IV'];
		return $baseline[$index] ?? null;
	}
}

if (!function_exists("observationBaslinjematning")) {
	//behave time type
	function observationBaslinjematning($index) {
		$baseline = ['Samtycke till placeringen', 'Utskrivning', 'Försvårande problematik relaterat till barnet vid placering', 'Försvårande erfarenheter hos barnet', 'Försvårande omständigheter vid placeringen', 'Motiv till placeringen'];
		return $baseline[$index] ?? null;
	}
}

if (!function_exists("observationBaslinjematningField")) {
	//behave time type
	function observationBaslinjematningField($index) {
		$baseline = [
			3 => 26, 4 => 16, 5 => 7, 6 => 20,
		];
		return $baseline[$index] ?? 1;
	}
}

if (!function_exists("observationRowColor")) {
	//behave time type
	function observationRowColor($index) {
		$baseline = [
			1 => '#FCD5B4', 2 => '#D8E4BC',
		];
		return $baseline[$index] ?? null;
	}
}
if (!function_exists("observationRowType4")) {
	//behave time type
	function observationRowType4($index) {
		$baseline = [
			1 => 'Lärare/mentor/praktihandledare skattar', 2 => 'Klienten skattar',
		];
		return $baseline[$index] ?? null;
	}
}
if (!function_exists("observationRowType")) {
	//behave time type
	function observationRowType($index) {
		$baseline = [
			1 => 'Personal skattar', 2 => 'Klienten skattar',
		];
		return $baseline[$index] ?? null;
	}
}
if (!function_exists("observationRowType6")) {
	//behave time type
	function observationRowType6($index) {
		$baseline = [
			1 => 'Aggressiva beteenden', 2 => 'Prosociala beteenden',
		];
		return $baseline[$index] ?? null;
	}
}

if (!function_exists("observationRowColor8")) {
	//behave time type
	function observationRowColor8($index) {
		$baseline = [
			1 => '#4F81BD', 2 => '#FF0000',
		];
		return $baseline[$index] ?? null;
	}
}

if (!function_exists("observationRowType8")) {
	//behave time type
	function observationRowType8($index) {
		$baseline = [
			1 => 'Används', 2 => 'Kompetens',
		];
		return $baseline[$index] ?? null;
	}
}

if (!function_exists("observationRowType11")) {
	//behave time type
	function observationRowType11($index) {
		$baseline = [
			1 => 'Vecka 1', 2 => 'Vecka 2', 3 => 'Vecka 3', 4 => 'Vecka 4'
		];
		return $baseline[$index] ?? null;
	}
}
