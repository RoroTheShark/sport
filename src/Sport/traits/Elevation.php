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
}