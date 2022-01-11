<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\Service;

use InvalidArgumentException;
use MarsRoverMission\App\Vehicle\Domain\Aggregate\Rover;
use MarsRoverMission\App\Vehicle\Domain\Service\VehicleFactory;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;
use PHPUnit\Framework\TestCase;

class VehicleFactoryTest extends TestCase
{
    const INVALID_VEHICLE_TYPE = 9999999;

    public function test_it_should_return_a_rover_instance()
    {
        $result = VehicleFactory::create(
            VehicleId::generate(),
            VehicleType::create(VehicleType::ROVER),
            Coordinates::create(0, 0),
            Orientation::create(Orientation::NORTH),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        $this->assertInstanceOf(Rover::class, $result);
    }

    public function test_it_throws_an_exception_when_is_a_non_valid_vehicle_type()
    {
        $this->expectException(InvalidArgumentException::class);

        VehicleFactory::create(
            VehicleId::generate(),
            VehicleType::create(self::INVALID_VEHICLE_TYPE),
            Coordinates::create(0, 0),
            Orientation::create(Orientation::NORTH),
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );
    }
}
