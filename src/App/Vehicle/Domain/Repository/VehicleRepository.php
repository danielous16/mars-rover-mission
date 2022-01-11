<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\Repository;

use MarsRoverMission\App\Vehicle\Domain\Aggregate\Vehicle;
use MarsRoverMission\App\Vehicle\Domain\Exception\VehicleNotFoundException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;

interface VehicleRepository
{
    /**
     * @throws VehicleNotFoundException
     */
    public function findById(VehicleId $id): Vehicle;

    public function insert(Vehicle $vehicle): void;

    public function update(Vehicle $vehicle): void;
}