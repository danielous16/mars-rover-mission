<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

class Planet
{
    private const MIN_X = 0;
    private const MIN_Y = 0;
    private const MAX_X = 200;
    private const MAX_Y = 200;

    public static function isOutTheBoundaries(Coordinates $coordinates): bool
    {
        if ($coordinates->x() < self::MIN_X || $coordinates->x() > self::MAX_X ||
            $coordinates->y() < self::MIN_Y || $coordinates->y() > self::MAX_Y)
        {
            return true;
        }

        return false;
    }
}