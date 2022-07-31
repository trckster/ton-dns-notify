<?php

namespace App\Models;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: 'subscriptions')]
class Subscription
{
    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    private int $id;

    #[Column(name: 'chat_id', type: Types::INTEGER)]
    private int $chatId;

    #[Column(type: Types::STRING, length: 126)]
    private string $dns;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    public function __construct(int $chatId, string $domain)
    {
        $this->chatId = $chatId;
        $this->dns = $domain;
        $this->createdAt = new DateTime;
    }
}