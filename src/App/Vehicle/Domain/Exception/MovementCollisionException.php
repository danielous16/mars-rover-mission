<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Exception;

use DomainException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;

final class MovementCollisionException extends DomainException
{
    public static function thereIsAnObstacleInCoordinatesAndMovement(Coordinates $coordinates, Movement $movement): self
    {
        return new self(
            sprintf(
                'There was a collision in the coordinates <X:%d> <Y:%d> when moving to the <%s>',
                $coordinates->x(),
                $coordinates->y(),
                $movement->value()
            )
        );
    }
}