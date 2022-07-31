<?php

namespace App\Models;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'auctions')]
class Auction
{
    public function __construct(int $betId, string $address)
    {
        $this->lastBetId = $betId;
        $this->address = $address;
        $this->createdAt = new DateTime;
    }

    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    private int $id;

    #[Column(type: Types::STRING, length: 60)]
    private string $address;

    #[Column(name: 'last_bet_id', type: Types::INTEGER)]
    private int $lastBetId;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }
}