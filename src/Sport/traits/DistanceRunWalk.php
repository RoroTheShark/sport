<?php

namespace Sport\Trait;

require_once('src/Sport/traits/Distance.php');

use Sport\Trait\Distance;

trait DistanceRunWalk
{
    use Distance;

    /**
     * @param float speed On attend une vitesse déjà calculée
     * @param float allure On attend une allure déjà calculée, de manière optionnelle
     * @return string Retourne une vitesse de style "5 min/km - 10km/h"
     */
    public function formateSpeed(float $speed, float $allure = 0): string
    {
        return $speed > 0 ? number_format($allure,2)." min/km<br />".number_format($speed,2)." km/h" : "";
    }

    /**
     * @return string Retourne une distance de style "3 100.15 km"
     */
    public function getDistanceFormated(): string
    {
        return $this->distance > 0 ? $this->formateDistanceKM($this->distance/1000) : "";
    }

    /**
     * @return string Retourne une vitesse de style "28.28 km/h" pour le vélo, "5 min/km - 10km/h" pour la marche et la course, et "2.5 m/s" pour la natation
     */
    public function getSpeedFormated(): string
    {
        $toReturn = "";
        if($this->distance > 0 && $this->time > 0) {
            $allure = ($this->time/(60))/($this->distance/1000);
            $secAllure = round(60*($allure - floor($allure)))/100;
            $toReturn = $this->formateSpeed(($this->distance/1000)/($this->time/(60*60)), floor($allure)+$secAllure);
        }
        return $toReturn;
    }
}