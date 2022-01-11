<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\ValueObject;

use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use PHPUnit\Framework\TestCase;

class MovementTest extends TestCase
{
    public function test_given_an_invalid_movement_it_throws_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        Movement::create('NON_VALID_MOVEMENT');
    }
}
