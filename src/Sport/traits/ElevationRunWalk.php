<?php

namespace Sport\Trait;

require_once('src/Sport/traits/DistanceRunWalk.php');
require_once('src/Sport/traits/Elevation.php');

use Sport\Trait\DistanceRunWalk;
use Sport\Trait\Elevation;

trait ElevationRunWalk
{
    use DistanceRunWalk, Elevation;

    /**
     * @return string Retourne une vitesse de style "5 min/km - 10km/h" tenant compte du dénivelé
     */
    public function getSpeedDistanceAndElevationFormated(): string
    {
        $toReturn = "";
        if($this->distance > 0 && $this->time > 0) {
            $allure = ($this->time/(60))/(($this->distance+($this->elevation*10))/1000);
            $secAllure = round(60*($allure - floor($allure)))/100;
            $toReturn = $this->formateSpeed((($this->distance+($this->elevation*10))/1000)/($this->time/(60*60)), floor($allure)+$secAllure);
        }
        return $toReturn;
    }

}