<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Movement
{
    public const  FORWARD      = 'F';
    public const  BACKWARD     = 'B';
    public const  LEFT         = 'L';
    public const  RIGHT        = 'R';
    private const VALID_VALUES = [
        self::FORWARD,
        self::BACKWARD,
        self::LEFT,
        self::RIGHT,
    ];

    /**
     * @throws InvalidArgumentException
     */
    private function __construct(private string $value)
    {
        Assert::inArray($value, self::VALID_VALUES, 'The %s is not a valid Movement');
    }

    public static function create(string $movement): self
    {
        return new self(strtoupper($movement));
    }

    public function value(): string
    {
        return $this->value;
    }
}