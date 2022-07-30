<?php

namespace App\Actions;

use Longman\TelegramBot\Request;

class DefaultAction extends AbstractAction
{
    public function process(): void
    {
        Request::sendMessage([
            'chat_id' => $this->update->getMessage()->getChat()->getId(),
            'text' => 'Command ' . $this->update->getMessage()->getText() . ' not found!'
        ]);
    }
}