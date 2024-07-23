<?php

namespace Sport\Trait;

trait Distance
{
    protected float $distance = 0;

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }
    
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @param float distance On attend une distance
     * @return string Retoune une distance de style "3 100.15 km"
     * Utilisé ci-dessous dans "getDistanceFormated" et dans le trait "Elevation->getDistanceAndElevationFormated"
     */
    public function formateDistanceKM(float $distance): string
    {
        return $distance > 0 ? number_format($distance, 2, ".", " ")." km" : "";
    }
}