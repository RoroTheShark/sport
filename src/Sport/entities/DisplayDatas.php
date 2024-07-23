<?php

namespace Sport\Entity;

require_once('src/Sport/traits/Time.php');

use Sport\Trait\Time;

class DisplayDatas
{
    use Time;

    private int $sumDistance;
    private int $moyDistance = 0;
    private int $maxDistance;
    private int $sumTime;
    private int $moyTime = 0;
    private int $maxTime;
    private int $numWorkouts;

    public function __construct(int $sumDistance, int $maxDistance, int $sumTime, int $maxTime, int $numWorkouts)
    {
        $this->sumDistance = $sumDistance;
        $this->maxDistance = $maxDistance;
        $this->sumTime = $sumTime;
        $this->maxTime = $maxTime;
        $this->numWorkouts = $numWorkouts;

        if($this->numWorkouts > 0) {
            $this->moyDistance = round($this->sumDistance/$this->numWorkouts);
            $this->moyTime = round($this->sumTime/$this->numWorkouts);
        }
    }

    public function getSumDistance(): string
    {
        return $this->showDistanceFormated($this->sumDistance);
    }

    public function getMoyDistance(): string
    {
        return $this->showDistanceFormated($this->moyDistance);
    }

    public function getMaxDistance(): string
    {
        return $this->showDistanceFormated($this->maxDistance);
    }

    public function showDistanceFormated($distance): string
    {
        return $distance > 0 ? number_format($distance, 0, ".", " ") : "";
    }

    public function getSumTime(): string
    {
        return $this->formateTime($this->sumTime, "texte");
    }

    public function getOriginalSumTime(): int
    {
        return $this->sumTime;
    }

    public function getMoyTime(): string
    {
        return $this->formateTime($this->moyTime, "texte");
    }

    public function getMaxTime(): string
    {
        return $this->formateTime($this->maxTime, "texte");
    }

    public function getNumWorkouts(): string
    {
        return $this->numWorkouts;
    }
}