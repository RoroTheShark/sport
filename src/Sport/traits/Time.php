<?php

namespace Sport\Trait;

trait Time
{
    /**
     * @param string type On attend un type "texte" ou "form"
     * @return string Retourne le temps sous format "00:00:00"
     */
    public function formateTime($time, string $type = "texte"): string
    {
        $number = intval($time);
        $numberStart = $number;
        $heures = floor($number/3600);
        $number = $number-($heures*3600);
        if($type == "form" && $heures < 10) {
            $heures = "0".$heures;
        }
        $minutes = floor($number/60);
        $number = $number-($minutes*60);
        if($type == "form" && $minutes < 10) {
            $minutes = "0".$minutes;
        }
        $secondes = $number;
        if($type == "form" && $secondes < 10) {
            $secondes = "0".$secondes;
        }
        if($heures > 24) {
            $jours = floor($heures/24);
            $heures = $heures-($jours*24);
            $heures = $jours."j ".$heures;
        }
        if($type == "form") {
              $retour = $heures.":".$minutes.":".$secondes;
        } else {
              $retour = $heures."h ".$minutes."m ".$secondes."s";
        }
        if($numberStart == 0) {
            $retour = "";
        }
        
        return $retour;
    }
}