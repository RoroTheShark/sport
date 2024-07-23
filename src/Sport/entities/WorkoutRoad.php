<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Road.php');
require_once('src/Sport/entities/Workout.php');

use Sport\Entity\Road;
use Sport\Entity\Workout;

class WorkoutRoad
{
    private int $number = 0;
    private Workout $workout;
    private Road $road;

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }
    public function getNumber(): int
    {
        return $this->number;
    }

    public function setRoad(Road $road): void
    {
        $this->road = $road;
    }

    public function getRoad(): Road
    {
        return $this->road;
    }

    public function setWorkout(Workout $workout): void
    {
        $this->workout = $workout;
    }

    public function getWorkout(): Workout
    {
        return $this->workout;
    }
}