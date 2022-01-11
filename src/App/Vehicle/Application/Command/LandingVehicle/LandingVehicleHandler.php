<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Application\Command\LandingVehicle;

use InvalidArgumentException;
use MarsRoverMission\App\Shared\Application\Command\CommandHandlerInterface;
use MarsRoverMission\App\Vehicle\Domain\Repository\VehicleRepository;
use MarsRoverMission\App\Vehicle\Domain\Service\VehicleFactory;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Planet;

final class LandingVehicleHandler implements CommandHandlerInterface
{
    public function __construct(private VehicleRepository $vehicleRepository)
    {
    }

    public function __invoke(LandingVehicleCommand $command): void
    {
        if (Planet::isOutTheBoundaries($command->coordinates())){
            throw new InvalidArgumentException(
                sprintf(
                    'The Coordinates <X:%d> - <Y:%d> are out the boundaries',
                    $command->coordinates()->x(),
                    $command->coordinates()->y()
                )
            );
        }

        $vehicle = VehicleFactory::create(
            $command->vehicleId(),
            $command->vehicleType(),
            $command->coordinates(),
            $command->orientation(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );

        $this->vehicleRepository->insert($vehicle);
    }
}
