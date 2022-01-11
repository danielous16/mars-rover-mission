<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\Aggregate;

use MarsRoverMission\App\Vehicle\Domain\Service\VehicleFactory;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    public function test_it_should_validate_the_right_valid_movements()
    {
        $rover = VehicleFactory::create(
            VehicleId::generate(),
            VehicleType::create(VehicleType::ROVER),
            Coordinates::create(1, 1),
            Orientation::create(Orientation::NORTH),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        $this->assertTrue($rover->isAValidMovement(Movement::create(Movement::FORWARD)));
        $this->assertTrue($rover->isAValidMovement(Movement::create(Movement::RIGHT)));
        $this->assertTrue($rover->isAValidMovement(Movement::create(Movement::LEFT)));
        $this->assertFalse($rover->isAValidMovement(Movement::create(Movement::BACKWARD)));
    }
}
