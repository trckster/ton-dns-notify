<?php

namespace App\Actions;

use Longman\TelegramBot\Entities\Update;

abstract class AbstractAction
{
    public function __construct(public readonly Update $update)
    {
    }

    abstract public function process(): void;
}