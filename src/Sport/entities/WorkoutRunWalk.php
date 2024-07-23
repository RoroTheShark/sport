<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Workout.php');
require_once('src/Sport/traits/ElevationRunWalk.php');

use Sport\Entity\Workout;
use Sport\Trait\ElevationRunWalk;

class WorkoutRunWalk extends Workout
{
    use ElevationRunWalk;
}