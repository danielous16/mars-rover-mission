<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Coordinates
{
    private const MINIMUM_VALID_COORDINATE = 0;
    private const DEFAULT_AMOUNT           = 1;

    private function __construct(private int $x, private int $y)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(int $x, int $y): self
    {
        Assert::greaterThanEq(
            $x,
            self::MINIMUM_VALID_COORDINATE,
            sprintf('The Coordinate X must be greater or equal to %d. Got: %d', self::MINIMUM_VALID_COORDINATE, $x)
        );
        Assert::greaterThanEq(
            $y,
            self::MINIMUM_VALID_COORDINATE,
            sprintf('The Coordinate Y must be greater or equal to %d. Got: %d', self::MINIMUM_VALID_COORDINATE, $y)
        );

        return new self($x, $y);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function increaseX(int $amount = self::DEFAULT_AMOUNT): void
    {
        $this->x += $amount;
    }

    public function decreaseX(int $amount = self::DEFAULT_AMOUNT): void
    {
        $this->x -= $amount;
    }

    public function increaseY(int $amount = self::DEFAULT_AMOUNT): void
    {
        $this->y += $amount;
    }

    public function decreaseY(int $amount = self::DEFAULT_AMOUNT): void
    {
        $this->y -= $amount;
    }
}