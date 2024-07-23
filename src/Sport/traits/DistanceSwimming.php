<?php

namespace Sport\Trait;

require_once('src/Sport/traits/Distance.php');

use Sport\Trait\Distance;

trait DistanceSwimming
{
    use Distance;

    /**
     * @param float speed On attend une vitesse déjà calculée
     * @return string Retourne une vitesse de style "2.5 m/s"
     */
    public function formateSpeed(float $speed): string
    {
        return $speed > 0 ? number_format($speed,2)." m/s" : "";
    }

    /**
     * @return string Retourne une distance de style "1 500 m"
     */
    public function getDistanceFormated(): string
    {
        return $this->distance > 0 ? number_format(($this->distance), 0, ".", " ")." m" : "";
    }

    /**
     * @return string Retourne une vitesse de style "2.5 m/s"
     */
    public function getSpeedFormated(): string
    {
        return ($this->distance > 0 && $this->time > 0) ? $this->formateSpeed($this->distance/$this->time) : "";
    }
}