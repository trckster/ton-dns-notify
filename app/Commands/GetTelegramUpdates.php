<?php

namespace App\Commands;

use App\Interfaces\CommandInterface;

class GetTelegramUpdates implements CommandInterface
{
    public function handle(): void
    {
        echo 'ok!';
    }
}
