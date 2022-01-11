<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\ValueObject;

use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Planet;
use PHPUnit\Framework\TestCase;

class PlanetTest extends TestCase
{
    public function test_given_a_valid_coordinates_returns_false()
    {
        $this->assertFalse(Planet::isOutTheBoundaries(Coordinates::create(1,1)));
        $this->assertFalse(Planet::isOutTheBoundaries(Coordinates::create(200, 200)));
    }

    public function test_given_a_coordinates_out_of_the_boundaries_returns_true() {
        $this->assertTrue(Planet::isOutTheBoundaries(Coordinates::create(999,1)));
        $this->assertTrue(Planet::isOutTheBoundaries(Coordinates::create(1,999)));
    }
}
