<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Orientation
{
    public const  NORTH           = 'N';
    public const  WEST            = 'W';
    public const  SOUTH           = 'S';
    public const  EST             = 'E';
    private const CARDINAL_POINTS = [
        self::NORTH,
        self::WEST,
        self::SOUTH,
        self::EST
    ];

    /**
     * @throws InvalidArgumentException
     */
    private function __construct(private string $value)
    {
        Assert::inArray($value, self::CARDINAL_POINTS, 'The %s is not a valid Orientation');
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}