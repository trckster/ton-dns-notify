<?php

namespace App\DTO;

class TransactionDTO
{
    public int $time;
    public string $transactionLt;
    public string $transactionHash;

    public TransactionMessageDTO $inputMessage;
    public array $outputMessages;

    public function isValid(): bool
    {
        if (empty(trim($this->inputMessage->message))) {
            return false;
        }

        if (empty($this->outputMessages)) {
            return false;
        }

        return $this->inputMessage->source !== $this->outputMessages[0]->destination;
    }

}