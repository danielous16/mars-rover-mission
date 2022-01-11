<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Vehicle\Domain\ValueObject;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class MovementCollection
{
    private array $elements;

    /**
     * @throws InvalidArgumentException
     */
    private function __construct(array $movements)
    {
        Assert::allIsInstanceOf($movements, Movement::class);
        $this->elements = $movements;
    }

    public static function create(array $movements): self
    {
        return new self($movements);
    }

    public function elements(): array
    {
        return $this->elements;
    }
}