<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Infrastructure\Repository;

use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use MarsRoverMission\App\Vehicle\Domain\Aggregate\Vehicle;
use MarsRoverMission\App\Vehicle\Domain\Exception\VehicleNotFoundException;
use MarsRoverMission\App\Vehicle\Domain\Repository\VehicleRepository;
use MarsRoverMission\App\Vehicle\Domain\Service\VehicleFactory;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Coordinates;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;

class MysqlVehicleRepository implements VehicleRepository
{
    private const TABLE_NAME         = 'vehicles';
    private const COLUM_ID           = 'id';
    private const COLUM_TYPE         = 'type';
    private const COLUM_COORDINATE_X = 'coordinate_x';
    private const COLUM_COORDINATE_Y = 'coordinate_y';
    private const COLUM_ORIENTATION  = 'orientation';
    private const COLUM_CREATED_AT   = 'created_at';
    private const COLUM_UPDATED_AT   = 'updated_at';

    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws VehicleNotFoundException
     */
    public function findById(VehicleId $id): Vehicle
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $data         = $queryBuilder->select(
            join(',', [
                self::COLUM_ID,
                self::COLUM_TYPE,
                self::COLUM_COORDINATE_X,
                self::COLUM_COORDINATE_Y,
                self::COLUM_ORIENTATION,
                self::COLUM_CREATED_AT,
                self::COLUM_UPDATED_AT,
            ])
        )->from(self::TABLE_NAME)
         ->where($queryBuilder->expr()->eq(self::COLUM_ID, ':id'))
         ->setParameter('id', $id->value())
         ->fetchAssociative();

        if (!$data) {
            throw VehicleNotFoundException::forId($id);
        }

        return VehicleFactory::create(
            VehicleId::fromString($data[self::COLUM_ID]),
            VehicleType::create((int) $data[self::COLUM_TYPE]),
            Coordinates::create((int) $data[self::COLUM_COORDINATE_X], (int) $data[self::COLUM_COORDINATE_Y]),
            Orientation::create($data[self::COLUM_ORIENTATION]),
            new DateTimeImmutable($data[self::COLUM_CREATED_AT]),
            new DateTimeImmutable($data[self::COLUM_UPDATED_AT]),
        );
    }

    public function insert(Vehicle $vehicle): void
    {
        $this->connection->createQueryBuilder()
                         ->insert(self::TABLE_NAME)
                         ->values([
                             self::COLUM_ID           => ':id',
                             self::COLUM_TYPE         => ':type',
                             self::COLUM_COORDINATE_X => ':coordinate_x',
                             self::COLUM_COORDINATE_Y => ':coordinate_y',
                             self::COLUM_ORIENTATION  => ':orientation',
                             self::COLUM_CREATED_AT   => ':created_at',
                             self::COLUM_UPDATED_AT   => ':updated_at',
                         ])
                         ->setParameter('id', $vehicle->id()->value())
                         ->setParameter('type', $vehicle->vehicleType()->value())
                         ->setParameter('coordinate_x', $vehicle->coordinates()->x())
                         ->setParameter('coordinate_y', $vehicle->coordinates()->y())
                         ->setParameter('orientation', $vehicle->orientation()->value())
                         ->setParameter('created_at', $vehicle->createdAt()->format(DateTime::ATOM))
                         ->setParameter('updated_at', $vehicle->updatedAt()->format(DateTime::ATOM))
                         ->executeStatement();
    }

    public function update(Vehicle $vehicle): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->update(self::TABLE_NAME)
                    ->set(self::COLUM_COORDINATE_X, ':coordinate_x')
                    ->set(self::COLUM_COORDINATE_Y, ':coordinate_y')
                    ->set(self::COLUM_ORIENTATION, ':orientation')
                    ->set(self::COLUM_CREATED_AT, ':created_at')
                    ->set(self::COLUM_UPDATED_AT, ':updated_at')
                    ->setParameter('coordinate_x', $vehicle->coordinates()->x())
                    ->setParameter('coordinate_y', $vehicle->coordinates()->y())
                    ->setParameter('orientation', $vehicle->orientation()->value())
                    ->setParameter(self::COLUM_CREATED_AT, $vehicle->createdAt()->format(DateTime::ATOM))
                    ->setParameter(self::COLUM_UPDATED_AT, $vehicle->updatedAt()->format(DateTime::ATOM))
                    ->where($queryBuilder->expr()->eq(self::COLUM_ID, ':id'))
                    ->setParameter('id',$vehicle->id()->value())
                    ->executeStatement();
    }
}