<?php

namespace App\Services;

use App\Actions\AbstractAction;
use App\Actions\DefaultAction;
use App\Actions\Ping;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Request;

class TelegramController
{
    const AVAILABLE_ACTIONS = [
        'ping' => Ping::class,
    ];

    public function process(Update $update): void
    {
        if ($update->getUpdateType() !== Update::TYPE_MESSAGE) {
            return;
        }

        $action = $update->getMessage()->getCommand();

        if (is_null($action)) {
            $this->answer($update, 'Under development (here will be help)');
        } else {
            $this->getAction($update, $action)->process();
        }
    }

    public function getAction(Update $update, string $actionName): AbstractAction
    {
        $actionClass = self::AVAILABLE_ACTIONS[$actionName] ?? DefaultAction::class;

        return new $actionClass($update);
    }

    private function answer(Update $update, string $answer): void
    {
        Request::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => $answer,
        ]);
    }
}