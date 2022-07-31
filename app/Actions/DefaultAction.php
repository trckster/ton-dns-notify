<?php

namespace App\Actions;

class DefaultAction extends AbstractAction
{
    public function process(): string
    {
        return 'Command ' . $this->update->getMessage()->getText() . ' not found!';
    }
}