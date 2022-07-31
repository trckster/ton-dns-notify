<?php

namespace App\Models;

use App\DTO\TransactionDTO;
use Carbon\Carbon;
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
    public function __construct(Auction $auction, TransactionDTO $transaction)
    {
        $this->auctionId = $auction->getId();
        $this->transactionLt = $transaction->transactionLt;
        $this->transactionHash = $transaction->transactionHash;
        $this->source = $transaction->inputMessage->source;
        $this->destination = $transaction->inputMessage->destination;
        $this->price = $transaction->inputMessage->value / 1_000_000_000;
        $this->madeAt = Carbon::createFromTimestamp($transaction->time)->toDateTime();
        $this->createdAt = new DateTime;
    }

    #[Id, Column(type: Types::INTEGER), GeneratedValue]
    private int $id;

    #[Column(name: 'auction_id', type: Types::INTEGER)]
    private int $auctionId;

    #[Column(name: 'transaction_lt', type: Types::STRING, length: 255)]
    private string $transactionLt;

    #[Column(name: 'transaction_hash', type: Types::STRING, length: 255)]
    private string $transactionHash;

    #[Column(type: Types::STRING, length: 60)]
    private string $source;

    #[Column(type: Types::STRING, length: 60)]
    private string $destination;

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