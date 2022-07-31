<?php

namespace App\Commands;

use App\DTO\TransactionDTO;
use App\Interfaces\CommandInterface;
use App\Models\Auction;
use App\Models\Bet;
use App\Services\TonCenterAPI;
use App\Services\TransactionsParser;
use Doctrine\ORM\EntityManager;

class LoadAuctions implements CommandInterface
{
    private TonCenterAPI $tonClient;
    private EntityManager $em;

    const TRANSACTIONS_COUNT = 100;

    public function __construct()
    {
        $this->tonClient = new TonCenterAPI;
        $this->em = getEntityManager();
    }

    public function handle(): void
    {
        $auctions = $this->em->getRepository(Auction::class)->findAll();

        /** @var Auction $auction */
        foreach ($auctions as $auction) {
            $this->updateAuction($auction);
            echo $auction->getAddress() . "\n";
        }
    }

    private function updateAuction(Auction $auction): void
    {
        $response = $this->tonClient->getTransactions(
            $auction->getAddress(),
            self::TRANSACTIONS_COUNT
        );

        $transactions = (new TransactionsParser)->getTransactionsDTOs($response['result']);

        /** @var TransactionDTO $transaction */
        foreach ($transactions as $transaction) {
            if (!$transaction->isValid()) {
                continue;
            }

            $model = $this->em->createQueryBuilder()
                ->select('bets')
                ->from(Bet::class, 'bets')
                ->where('bets.transactionLt = ?0 AND bets.transactionHash = ?1')
                ->setParameters([$transaction->transactionLt, $transaction->transactionHash])
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            if ($model) {
                continue;
            }

            $bet = new Bet($auction, $transaction);
            $this->em->persist($bet);
        }

        $this->em->flush();
    }
}