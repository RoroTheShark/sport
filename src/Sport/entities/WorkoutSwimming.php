<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Pool.php');
require_once('src/Sport/traits/DistanceSwimming.php');
require_once('src/Sport/entities/Workout.php');

use Sport\Entity\Pool;
use Sport\Entity\Workout;
use Sport\Trait\DistanceSwimming;

class WorkoutSwimming extends Workout
{
    use DistanceSwimming;

    private ?Pool $pool = null;

    public function setPool(Pool $pool): void
    {
        $this->pool = $pool;
    }
    
    public function getPool(): ?Pool
    {
        return $this->pool;
    }
}