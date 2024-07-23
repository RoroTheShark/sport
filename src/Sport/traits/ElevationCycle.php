<?php

namespace Sport\Trait;

require_once('src/Sport/traits/DistanceCycle.php');
require_once('src/Sport/traits/Elevation.php');

use Sport\Trait\DistanceCycle;
use Sport\Trait\Elevation;

trait ElevationCycle
{
    use DistanceCycle, Elevation;

    /**
     * @return string Retourne une vitesse de style "28.28 km/h" tenant compte du dénivelé
     */
    public function getSpeedDistanceAndElevationFormated(): string
    {
        return $this->distance > 0 && $this->time > 0 ? $this->formateSpeed(($this->distance+($this->elevation*10))/($this->time/(60*60))) : "";
    }

}