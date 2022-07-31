<?php

namespace App\Actions;

class Ping extends AbstractAction
{
    public function process(): string
    {
        return 'PONG';
    }
}