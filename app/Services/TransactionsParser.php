<?php

namespace App\Services;

use App\DTO\TransactionDTO;
use App\DTO\TransactionMessageDTO;

class TransactionsParser
{
    public function getTransactionsDTOs(array &$transactions): array
    {
        $transactionsDTOs = [];

        foreach ($transactions as $transaction) {
            $dto = new TransactionDTO;
            $dto->time = $transaction['utime'];
            $dto->transactionLt = $transaction['transaction_id']['lt'];
            $dto->transactionHash = $transaction['transaction_id']['hash'];

            $dto->inputMessage = $this->getTransactionMessageDTO($transaction['in_msg']);
            $dto->outputMessages = [];

            foreach ($transaction['out_msgs'] as $message)
            {
                $dto->outputMessages[] = $this->getTransactionMessageDTO($message);
            }

            $transactionsDTOs[] = $dto;
        }

        return $transactionsDTOs;
    }

    public function getTransactionMessageDTO(array $message): TransactionMessageDTO
    {
        $dto = new TransactionMessageDTO;

        $dto->source = $message['source'];
        $dto->destination = $message['destination'];
        $dto->value = $message['value'];
        $dto->message = $message['message'];

        return $dto;
    }
}