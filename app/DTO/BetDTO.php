<?php

namespace App\DTO;

use Carbon\Carbon;

class BetDTO
{
    public string $transactionLt;
    public string $transactionHash;
    public string $dns;
    public string $address;
    public float $price;
    public Carbon $madeAt;

    public static function fromTransaction(array $transaction): self
    {
        $dto = new self;

        $dto->transactionLt = $transaction['transaction_id']['lt'];
        $dto->transactionHash = $transaction['transaction_id']['hash'];
        $dto->dns = trim($transaction['in_msg']['message']);
        $dto->address = $transaction['in_msg']['source'];
        $dto->price = $transaction['in_msg']['value'] / 10 ** 9;
        $dto->madeAt = new Carbon($transaction['utime']);

        return $dto;
    }
}