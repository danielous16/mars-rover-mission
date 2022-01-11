<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Aggregate;

use DateTimeImmutable;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;

class Rover extends Vehicle
{
    public static function create(
        VehicleId $id,
        Coordinates $coordinates,
        Orientation $orientation,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        return new self(
            $id, VehicleType::create(VehicleType::ROVER), $coordinates, $orientation, $createdAt, $updatedAt
        );
    }

    public function isAValidMovement(Movement $movement): bool
    {
        $validMovements = [
            Movement::FORWARD,
            Movement::LEFT,
            Movement::RIGHT,
        ];

        return in_array($movement->value(), $validMovements);
    }
}