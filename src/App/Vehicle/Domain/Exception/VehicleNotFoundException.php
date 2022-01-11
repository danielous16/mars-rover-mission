<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Exception;

use DomainException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;

final class VehicleNotFoundException extends DomainException
{
    public static function forId(VehicleId $vehicleId): self
    {
        return new self(sprintf('Vehicle with id <%s> not found', $vehicleId->value()));
    }
}