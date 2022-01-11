<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Application\Command\LandingVehicle;

use InvalidArgumentException;
use MarsRoverMission\App\Shared\Application\Command\CommandInterface;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;

final class LandingVehicleCommand implements CommandInterface
{
    private VehicleId   $uuid;
    private VehicleType $vehicleType;
    private Coordinates $coordinates;
    private Orientation $orientation;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $uuid,
        int $vehicleType,
        int $coordinateX,
        int $coordinateY,
        string $orientation
    )
    {
        $this->uuid        = VehicleId::fromString($uuid);
        $this->vehicleType = VehicleType::create($vehicleType);
        $this->coordinates = Coordinates::create($coordinateX, $coordinateY);
        $this->orientation = Orientation::create($orientation);
    }

    public function vehicleId(): VehicleId
    {
        return $this->uuid;
    }

    public function vehicleType(): VehicleType
    {
        return $this->vehicleType;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function orientation(): Orientation
    {
        return $this->orientation;
    }
}
