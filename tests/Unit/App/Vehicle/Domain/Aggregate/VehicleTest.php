<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\Aggregate;

use DateTimeImmutable;
use MarsRoverMission\App\Vehicle\Domain\Service\VehicleFactory;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    /**
     * @dataProvider getCoordinatesAfterApplyAMovementStartingAtOneOneCoordinate
     */
    public function test_it_should_return_a_rover_instance(
        string $startingOrientation,
        string $nextMovement,
        int $expectedX,
        int $expectedY,
        string $expectedOrientation
    )
    {
        $vehicle = VehicleFactory::create(
            VehicleId::generate(),
            VehicleType::create(VehicleType::ROVER),
            Coordinates::create(1, 1),
            Orientation::create($startingOrientation),
            new DateTimeImmutable(),
            new DateTimeImmutable(),
        );

        $vehicle->move(Movement::create($nextMovement));

        $this->assertEquals($vehicle->coordinates()->x(), $expectedX);
        $this->assertEquals($vehicle->coordinates()->y(), $expectedY);
        $this->assertEquals($vehicle->orientation()->value(), $expectedOrientation);
    }

    public function getCoordinatesAfterApplyAMovementStartingAtOneOneCoordinate()
    {
        return [
            'north_oriented_moving_to_right' => [Orientation::NORTH, Movement::RIGHT, 2, 1, Orientation::EST],
            'north_oriented_moving_to_left' => [Orientation::NORTH, Movement::LEFT, 0, 1, Orientation::WEST],
            'north_oriented_moving_to_forward' => [Orientation::NORTH, Movement::FORWARD, 1, 0, Orientation::NORTH],
            'south_oriented_moving_to_right' => [Orientation::SOUTH, Movement::RIGHT, 0, 1, Orientation::WEST],
            'south_oriented_moving_to_left' => [Orientation::SOUTH, Movement::LEFT, 2, 1, Orientation::EST],
            'south_oriented_moving_to_forward' => [Orientation::SOUTH, Movement::FORWARD, 1, 2, Orientation::SOUTH],
            'est_oriented_moving_to_right' => [Orientation::EST, Movement::RIGHT, 1, 2, Orientation::SOUTH],
            'est_oriented_moving_to_left' => [Orientation::EST, Movement::LEFT, 1, 0, Orientation::NORTH],
            'est_oriented_moving_to_forward' => [Orientation::EST, Movement::FORWARD, 2, 1, Orientation::EST],
            'west_oriented_moving_to_right' => [Orientation::WEST, Movement::RIGHT, 1, 0, Orientation::NORTH],
            'west_oriented_moving_to_left' => [Orientation::WEST, Movement::LEFT, 1, 2, Orientation::SOUTH],
            'west_oriented_moving_to_forward' => [Orientation::WEST, Movement::FORWARD, 0, 1, Orientation::WEST],
        ];
    }
}
