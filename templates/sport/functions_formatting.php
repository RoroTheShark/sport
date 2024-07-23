<?php
function numberToHour($number, $presentation = "texte") {
	$number = intval($number);
	$numberStart = $number;
	$heures = floor($number/3600);
	$number = $number-($heures*3600);
	if($presentation == "form" && $heures < 10) {
		$heures = "0".$heures;
	}
	$minutes = floor($number/60);
	$number = $number-($minutes*60);
	if($presentation == "form" && $minutes < 10) {
		$minutes = "0".$minutes;
	}
	$secondes = $number;
	if($presentation == "form" && $secondes < 10) {
		$secondes = "0".$secondes;
	}
	if($heures > 24) {
		$jours = floor($heures/24);
		$heures = $heures-($jours*24);
		$heures = $jours."j ".$heures;
	}
	if($presentation == "form") {
		  $retour = $heures.":".$minutes.":".$secondes;
	} else {
		  $retour = $heures."h ".$minutes."m ".$secondes."s";
	}
	if($numberStart == 0) {
		$retour = "";
	}
	return $retour;
}

function hourToNumber($hour) {
	$secondes = substr($hour,6,2);
	$minutes = substr($hour,3,2);
	$heures = substr($hour,0,2);
	$retour = $secondes+($minutes*60)+($heures*60*60);

	return $retour;
}

function jourMois($date) {
	$jourMois = substr($date, 5);
	$jourMois = substr($jourMois, 3,2)."/".substr($jourMois, 0,2);
	return $jourMois;
}

function miseForme($nombre) {
	$retour = $nombre;
	if(gettype($nombre) == "integer" || gettype($nombre) == "double") {
		$retour = number_format($nombre, 0, ".", " ");
	}
	return $retour;
}