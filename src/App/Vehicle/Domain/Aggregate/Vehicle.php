<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Aggregate;

use DateTimeImmutable;
use InvalidArgumentException;
use MarsRoverMission\App\Vehicle\Domain\Exception\MovementCollisionException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Planet;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;

abstract class Vehicle
{
    private const NEXT_ORIENTATION_BY_MOVEMENT = [
        Orientation::NORTH => [
            Movement::RIGHT   => Orientation::EST,
            Movement::LEFT    => Orientation::WEST,
            Movement::FORWARD => Orientation::NORTH,
        ],
        Orientation::WEST  => [
            Movement::RIGHT   => Orientation::NORTH,
            Movement::LEFT    => Orientation::SOUTH,
            Movement::FORWARD => Orientation::WEST,
        ],
        Orientation::SOUTH => [
            Movement::RIGHT   => Orientation::WEST,
            Movement::LEFT    => Orientation::EST,
            Movement::FORWARD => Orientation::SOUTH,
        ],
        Orientation::EST   => [
            Movement::RIGHT   => Orientation::SOUTH,
            Movement::LEFT    => Orientation::NORTH,
            Movement::FORWARD => Orientation::EST,
        ],
    ];

    protected function __construct(
        private VehicleId $id,
        private VehicleType $vehicleType,
        private Coordinates $coordinates,
        private Orientation $orientation,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    )
    {
    }

    public function id(): VehicleId
    {
        return $this->id;
    }

    public function vehicleType(): VehicleType
    {
        return $this->vehicleType;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @throws InvalidArgumentException
     * @throws MovementCollisionException
     */
    public function move(Movement $newMovement): void
    {
        if (!$this->isAValidMovement($newMovement)) {
            throw new InvalidArgumentException(
                sprintf('The %s is nos a valid movement for this Vehicle', $newMovement->value())
            );
        }

        $newCoordinates = $this->getNewCoordinatesApplyingAMovement($newMovement);

        if (Planet::isOutTheBoundaries($newCoordinates)) {
            throw MovementCollisionException::thereIsAnObstacleInCoordinatesAndMovement($newCoordinates, $newMovement);
        }

        $this->setNewOrientationByMovement($newMovement);
        $this->coordinates = $newCoordinates;
        $this->refreshUpdatedAtDate();
    }

    abstract public function isAValidMovement(Movement $movement): bool;

    private function getNewCoordinatesApplyingAMovement(Movement $newMovement): Coordinates
    {
        $currentOrientation = $this->orientation()->value();
        $newCoordinates     = Coordinates::create($this->coordinates()->x(), $this->coordinates()->y());

        match ($newMovement->value()) {
            Movement::RIGHT => match ($currentOrientation) {
                Orientation::NORTH => $newCoordinates->increaseX(),
                Orientation::SOUTH => $newCoordinates->decreaseX(),
                Orientation::EST => $newCoordinates->increaseY(),
                Orientation::WEST => $newCoordinates->decreaseY()
            },
            Movement::LEFT => match ($currentOrientation) {
                Orientation::NORTH => $newCoordinates->decreaseX(),
                Orientation::SOUTH => $newCoordinates->increaseX(),
                Orientation::EST => $newCoordinates->decreaseY(),
                Orientation::WEST => $newCoordinates->increaseY()
            },
            Movement::FORWARD => match ($currentOrientation) {
                Orientation::NORTH => $newCoordinates->decreaseY(),
                Orientation::SOUTH => $newCoordinates->increaseY(),
                Orientation::EST => $newCoordinates->increaseX(),
                Orientation::WEST => $newCoordinates->decreaseX()
            },
            Movement::BACKWARD => match ($currentOrientation) {
                Orientation::NORTH => $newCoordinates->increaseY(),
                Orientation::SOUTH => $newCoordinates->decreaseY(),
                Orientation::EST => $newCoordinates->decreaseX(),
                Orientation::WEST => $newCoordinates->increaseX()
            }
        };

        return $newCoordinates;
    }

    private function refreshUpdatedAtDate()
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function orientation(): Orientation
    {
        return $this->orientation;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function setNewOrientationByMovement(Movement $movement): void
    {
        $this->orientation = Orientation::create(
            self::NEXT_ORIENTATION_BY_MOVEMENT[$this->orientation()->value()][$movement->value()]
        );
    }
}