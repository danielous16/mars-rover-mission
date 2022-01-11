<?php

declare(strict_types=1);

namespace MarsRoverMission\UI\Http\Controller\Vehicle;

use InvalidArgumentException;
use MarsRoverMission\App\Vehicle\Application\Command\LandingVehicle\LandingVehicleCommand;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleId;
use MarsRoverMission\UI\Http\Controller\CommandController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class LandingController extends CommandController
{
    private const VEHICLE_TYPE = 'vehicle_type';
    private const COORDINATE_X = 'coordinate_x';
    private const COORDINATE_Y = 'coordinate_y';
    private const ORIENTATION  = 'orientation';

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $requestBody = $request->toArray();
            $this->validateRequest($requestBody);

            $vehicleId = VehicleId::generate()->value();

            $this->handle(
                new LandingVehicleCommand(
                    $vehicleId,
                    $requestBody[self::VEHICLE_TYPE],
                    $requestBody[self::COORDINATE_X],
                    $requestBody[self::COORDINATE_Y],
                    $requestBody[self::ORIENTATION]
                )
            );
        } catch (InvalidArgumentException | JsonException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable) {
            return new JsonResponse(['error' => 'Internal server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['vehicle_id' => $vehicleId], Response::HTTP_CREATED);
    }

    private function validateRequest(array $requestBody)
    {
        Assert::keyExists($requestBody,self::VEHICLE_TYPE,'The <vehicle_type> parameter is mandatory');
        Assert::keyExists($requestBody,self::COORDINATE_X,'The <coordinate_x> parameter is mandatory');
        Assert::keyExists($requestBody,self::COORDINATE_Y,'The <coordinate_y> parameter is mandatory');
        Assert::keyExists($requestBody,self::ORIENTATION,'The <orientation> parameter is mandatory');
        Assert::integer($requestBody[self::VEHICLE_TYPE],'The <vehicle_type> must be integer');
        Assert::integer($requestBody[self::COORDINATE_X],'The <coordinate_x> must be integer');
        Assert::integer($requestBody[self::COORDINATE_Y],'The <coordinate_y> must be integer');
        Assert::string($requestBody[self::ORIENTATION], 'The <orientation> must be string');
    }
}