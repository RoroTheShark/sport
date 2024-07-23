<?php

namespace Sport\Trait;

require_once('src/Sport/traits/Distance.php');

use Sport\Trait\Distance;

trait DistanceCycle
{
    use Distance;

    /**
     * @param float speed On attend une vitesse déjà calculée
     * @return string Retourne une vitesse de style "28.28 km/h" 
     * Utilisé ci-dessous dans "getSpeedFormated" et dans le trait "Elevation->getSpeedDistanceAndElevationFormated"
     */
    public function formateSpeed(float $speed): string
    {
        return $speed > 0 ? number_format($speed,2)." km/h" : "";
    }

    /**
     * @return string Retourne une distance de style "3 100.15 km"
     */
    public function getDistanceFormated(): string
    {
        return $this->distance > 0 ? $this->formateDistanceKM($this->distance/1000) : "";
    }

    /**
     * @return string Retourne une vitesse de style "28.28 km/h"
     */
    public function getSpeedFormated(): string
    {
        return ($this->distance > 0 && $this->time > 0) ? $this->formateSpeed(($this->distance/1000)/($this->time/(60*60))) : "";
    }
}