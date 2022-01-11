<?php

declare(strict_types=1);

namespace Acceptance\UI\Http\Controller\Vehicle;

use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use MarsRoverMission\App\Vehicle\Domain\ValueObject\VehicleType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends WebTestCase
{
    public function test_given_a_landing_request_the_vehicle_is_created_and_return_a_201_status_code(): void
    {
        $client = static::createClient();

        $params = [
            'vehicle_type' => VehicleType::ROVER,
            'coordinate_x' => 10,
            'coordinate_y' => 10,
            'orientation'  => Orientation::NORTH
        ];

        $client->request(
            'POST',
            'http://localhost/vehicles/landing',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            (string) \json_encode($params)
        );

        self::assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}