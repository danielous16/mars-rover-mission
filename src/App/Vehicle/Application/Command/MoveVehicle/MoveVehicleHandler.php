<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Application\Command\MoveVehicle;

use InvalidArgumentException;
use MarsRoverMission\App\Shared\Application\Command\CommandHandlerInterface;
use MarsRoverMission\App\Vehicle\Domain\Repository\VehicleRepository;

final class MoveVehicleHandler implements CommandHandlerInterface
{
    public function __construct(private VehicleRepository $vehicleRepository)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function __invoke(MoveVehicleCommand $command): void
    {
        $vehicle = $this->vehicleRepository->findById($command->vehicleId());

        $vehicle->move($command->movement());
        $this->vehicleRepository->update($vehicle);
    }
}
