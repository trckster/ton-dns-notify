<?php

namespace App;

use App\Commands\GetTelegramUpdates;
use App\Commands\LoadAuctions;
use App\Commands\LoadNewBets;
use App\Commands\RunMigrations;
use App\Interfaces\CommandInterface;
use Dotenv\Dotenv;

class Kernel
{
    const COMMANDS = [
        'get-telegram-updates' => GetTelegramUpdates::class,
        'load-new-bets' => LoadNewBets::class,
        'load-auctions' => LoadAuctions::class,
        'migrate' => RunMigrations::class,
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
        $this->loadEnv();

        $this->processCommand();
    }

    public function processCommand(): void
    {
        $commandClass = self::COMMANDS[$this->options[1]] ?? die('Command not found');

        /** @var CommandInterface $command */
        $command = new $commandClass();

        $command->handle();
    }

    public function loadEnv(): void
    {
        $dotenv = Dotenv::createImmutable(getBaseDir());
        $dotenv->load();
    }
}