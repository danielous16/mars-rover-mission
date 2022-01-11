<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Service;

use DateTimeImmutable;
use InvalidArgumentException;
use MarsRoverMission\App\Vehicle\Domain\Aggregate\Rover;
use MarsRoverMission\App\Vehicle\Domain\Aggregate\Vehicle;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;
use RuntimeException;

class VehicleFactory
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(
        VehicleId $id,
        VehicleType $type,
        Coordinates $coordinates,
        Orientation $orientation,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ): Vehicle
    {
        return match ($type->value()) {
            VehicleType::ROVER => Rover::create($id, $coordinates, $orientation, $createdAt, $updatedAt),
            default => throw new RuntimeException(
                sprintf('Invalid VehicleType <%s>', $type->value())
            )
        };
    }
}