<?php

namespace App\Models;

use App\DTO\BetDTO;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: 'bets')]
class Bet
{
    public function __construct(BetDTO $dto)
    {
        $this->transactionLt = $dto->transactionLt;
        $this->transactionHash = $dto->transactionHash;
        $this->dns = $dto->dns;
        $this->address = $dto->address;
        $this->price = $dto->price;
        $this->madeAt = $dto->madeAt->toDateTime();
        $this->createdAt = new DateTime;
    }

    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    private int $id;

    #[Column(name: 'transaction_lt', type: Types::STRING, length: 255)]
    private string $transactionLt;

    #[Column(name: 'transaction_hash', type: Types::STRING, length: 255)]
    private string $transactionHash;

    #[Column(type: Types::STRING, length: 126)]
    private string $dns;

    #[Column(type: Types::STRING, length: 60)]
    private string $address;

    #[Column(type: Types::DECIMAL)]
    private float $price;

    #[Column(name: 'made_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $madeAt;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }
}