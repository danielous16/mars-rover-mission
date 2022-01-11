<?php

declare(strict_types=1);

namespace MarsRoverMission\App\Shared\Domain\ValueObject;

use Assert\Assertion;

class Uuid
{
    protected $value;

    private function __construct(string $value)
    {
        Assertion::uuid($value);
        $this->value = $value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public static function generate(): static
    {
        return new static(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public function equalsTo(Uuid $id): bool
    {
        return $this->value === $id->value()
               && get_class($this) === get_class($id);
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
