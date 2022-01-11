<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase
{
    public function test_it_throws_an_exception_when_the_coordinate_x_is_invalid() {
        $this->expectException(InvalidArgumentException::class);

        Coordinates::create(-1, 1);
    }

    public function test_it_throws_an_exception_when_the_coordinate_y_is_invalid() {
        $this->expectException(InvalidArgumentException::class);

        Coordinates::create(1, -1);
    }
}
