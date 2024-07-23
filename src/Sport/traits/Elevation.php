<?php

namespace Sport\Trait;

trait Elevation
{
    protected float $elevation = 0;

    public function setElevation(float $elevation): void
    {
        $this->elevation = $elevation;
    }
    
    public function getElevation(): float
    {
        return $this->elevation;
    }

    /**
     * @return string Retourne un dénivelé de style "3 100 m"
     */
    public function getElevationFormated(): string
    {
        $toReturn = "";
        if($this->elevation > 0) {
            $toReturn = number_format(($this->elevation), 0, ".", " ")." m";
        }
        return $toReturn;
    }

    /**
     * @return string Retourne un dénivelé de style "3 100 m"
     */
    public function getDistanceAndElevationFormated(): string
    {
        $toReturn = "";
        if($this->distance > 0 && $this->elevation > 0) {
            $toReturn = $this->formateDistanceKM(($this->distance+($this->elevation*10))/1000);
        }
        return $toReturn;
    }
    
    /**
     * @return string Retourne une vitesse de style "28.28 km/h" tenant compte du dénivelé
     */
    public function getSpeedDistanceAndElevationFormated(): string
    {
        return $this->distance > 0 && $this->time > 0 ? $this->formateSpeed(($this->distance+($this->elevation*10))/($this->time/(60*60))) : "";
    }
}