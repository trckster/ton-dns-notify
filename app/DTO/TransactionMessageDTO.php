<?php

namespace App\DTO;

class TransactionMessageDTO
{
    public string $source;
    public string $destination;
    public int $value;
    public string $message;
}