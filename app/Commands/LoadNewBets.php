<?php

namespace App\Commands;

use App\Interfaces\CommandInterface;
use App\Services\Log;

class LoadNewBets implements CommandInterface
{
    public function handle(): void
    {
        Log::info('Load new bets ran');
    }
}