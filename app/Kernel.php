<?php

namespace App;

use App\Commands\GetTelegramUpdates;
use App\Interfaces\CommandInterface;

class Kernel
{
    const COMMANDS = [
        'get-telegram-updates' => GetTelegramUpdates::class,
        'load-new-bets' => stdClass::class
    ];

    public function __construct(
        private readonly array $options
    )
    {
        if (count($this->options) < 2) {
            die('Not enough arguments');
        }
    }

    public function run(): void
    {
        $commandClass = self::COMMANDS[$this->options[1]] ?? die('Command not found');

        /** @var CommandInterface $command */
        $command = new $commandClass();

        $command->handle();
    }
}