<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class VehicleType
{
    public const  ROVER       = 1;
    private const VALID_TYPES = [
        self::ROVER
    ];

    /**
     * @throws InvalidArgumentException
     */
    private function __construct(private int $value)
    {
        Assert::inArray($value, self::VALID_TYPES, '%d is not a valid VehicleType');
    }

    public static function create(int $type): self
    {
        return new self($type);
    }

    public function value(): int
    {
        return $this->value;
    }
}