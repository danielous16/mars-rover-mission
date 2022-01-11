<?php

declare(strict_types=1);

namespace Unit\App\Vehicle\Domain\ValueObject;

use MarsRoverMission\App\Vehicle\Domain\ValueObject\Orientation;
use PHPUnit\Framework\TestCase;

class OrientationTest extends TestCase
{
    public function test_given_an_invalid_orientation_it_throws_an_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        Orientation::create('NON_VALID_ORIENTATION');
    }
}
