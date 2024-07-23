<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Workout.php');
require_once('src/Sport/traits/ElevationCycle.php');

use Sport\Entity\Workout;
use Sport\Trait\ElevationCycle;

class WorkoutCycle extends Workout
{
    use ElevationCycle;
}