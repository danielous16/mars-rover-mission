<?php

declare(strict_types=1);

namespace MarsRoverMission\UI\Http\Controller;

use MarsRoverMission\App\Shared\Application\Command\CommandBusInterface;
use MarsRoverMission\App\Shared\Application\Command\CommandInterface;
use Throwable;

abstract class CommandController
{
    public function __construct(private CommandBusInterface $commandBus) {}

    /**
     * @throws Throwable
     */
    protected function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }
}
