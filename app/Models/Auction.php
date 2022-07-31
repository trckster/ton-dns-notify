<?php

namespace App\Models;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'bets')]
class Auction
{
    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    private int $id;

    #[Column(type: Types::STRING, length: 60)]
    private string $address;

    #[Column(type: Types::INTEGER)]
    private int $last_bet_id;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }
}