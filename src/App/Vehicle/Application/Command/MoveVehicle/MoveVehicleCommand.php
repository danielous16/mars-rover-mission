<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Application\Command\MoveVehicle;

use InvalidArgumentException;
use MarsRoverMission\App\Shared\Application\Command\CommandInterface;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;

class MoveVehicleCommand implements CommandInterface
{
    private Movement  $movement;
    private VehicleId $vehicleId;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $uuid,
        string $movement
    ) {
        $this->vehicleId = VehicleId::fromString($uuid);
        $this->movement  = Movement::create($movement);
    }

    public function movement(): Movement
    {
        return $this->movement;
    }

    public function vehicleId(): VehicleId
    {
        return $this->vehicleId;
    }
}