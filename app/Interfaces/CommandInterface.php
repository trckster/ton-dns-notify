<?php

namespace App\Interfaces;

interface CommandInterface
{
    public function handle(): void;
}