<?php

namespace App\Actions;

use Longman\TelegramBot\Request;

class Ping extends AbstractAction
{
    public function process(): void
    {
        Request::sendMessage([
            'chat_id' => $this->update->getMessage()->getChat()->getId(),
            'text' => 'PONG'
        ]);
    }
}