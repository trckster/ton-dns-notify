<?php

namespace App\Commands;

use App\Interfaces\CommandInterface;
use App\Services\Log;
use App\Services\TelegramController;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class GetTelegramUpdates implements CommandInterface
{
    private readonly Telegram $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(env('BOT_API_KEY'), env('BOT_HANDLE'));
        $this->telegram->enableMySql([
            'host' => env('MYSQL_HOST'),
            'port' => env('MYSQL_PORT'),
            'user' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'database' => env('MYSQL_DATABASE'),
        ]);
    }

    public function handle(): void
    {
        $controller = new TelegramController;

        try {
            $response = $this->telegram->handleGetUpdates();

            /** @var Update $update */
            foreach ($response->getResult() as $update) {
                $controller->process($update);
            }
        } catch (TelegramException $e) {
            Log::error($e->getMessage());
        }
    }
}
