<?php

declare(strict_types=1);

namespace MarsRoverMission\UI\Http\Controller\Vehicle;

use InvalidArgumentException;
use DomainException;
use Throwable;
use MarsRoverMission\App\Vehicle\Application\Command\MoveVehicle\MoveVehicleCommand;
use MarsRoverMission\App\Vehicle\Domain\Exception\MovementCollisionException;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\Movement;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\MovementCollection;
use MarsRoverMission\UI\Http\Controller\CommandController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class MoveController extends CommandController
{
    private const PARAMETER_MOVEMENT_SEQUENCE = 'movement_sequence';
    private const MOVEMENTS                   = 'movements';
    private const PROCESSED                   = 'processed';
    private const NOT_PROCESSED               = 'not_processed';
    private const VEHICLE_ID                  = 'vehicle_id';
    private const ERROR                       = 'error';

    private MovementCollection $movementCollection;
    private string             $vehicleId;
    private array              $responseBody;

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->validateAndGetVehicleId($request);
            $this->validateAndGetMovementCollectionFromRequest($request);
            $this->initializeResponseBody();

            foreach ($this->movementCollection->elements() as $movement) {
                $this->handle(
                    new MoveVehicleCommand($this->vehicleId, $movement->value())
                );
                $this->responseBody[self::MOVEMENTS][self::PROCESSED] .= $movement->value();
            }
        } catch (MovementCollisionException $exception) {
            $this->formatNotProcessedMovements();
            $this->responseBody[self::MOVEMENTS][self::ERROR] = $exception->getMessage();
        } catch (InvalidArgumentException | DomainException | JsonException $exception) {
            return new JsonResponse([self::ERROR => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (Throwable) {
            return new JsonResponse([self::ERROR => 'Internal server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($this->responseBody, Response::HTTP_OK);
    }

    private function validateAndGetVehicleId(Request $request): void
    {
        $this->vehicleId = $request->get('id');
        Assert::uuid($this->vehicleId, 'The <vehicle_id> must be a valid Uuid');
    }

    private function validateAndGetMovementCollectionFromRequest(Request $request): void
    {
        $movementSequenceString = $request->toArray()[self::PARAMETER_MOVEMENT_SEQUENCE] ?? null;
        Assert::stringNotEmpty($movementSequenceString, 'The <movement_sequence> must be a non-empty string');

        $movementSequenceArray    = str_split($movementSequenceString);
        $this->movementCollection = MovementCollection::create(
            array_map(fn($movement) => Movement::create($movement), $movementSequenceArray)
        );
    }

    private function initializeResponseBody(): void
    {
        $this->responseBody = [
            self::VEHICLE_ID => $this->vehicleId,
            self::MOVEMENTS  => [
                self::PROCESSED => '',
            ]
        ];
    }

    private function formatNotProcessedMovements()
    {
        $this->responseBody[self::MOVEMENTS][self::NOT_PROCESSED] = str_replace(
            $this->responseBody[self::MOVEMENTS][self::PROCESSED],
            '',
            implode(array_map(fn($movement) => $movement->value(), $this->movementCollection->elements()))
        );
    }
}