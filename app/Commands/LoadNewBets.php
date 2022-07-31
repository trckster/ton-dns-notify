<?php

namespace App\Commands;

use App\DTO\TransactionDTO;
use App\Interfaces\CommandInterface;
use App\Models\Auction;
use App\Models\Bet;
use App\Services\Log;
use App\Services\TonCenterAPI;
use App\Services\TransactionsParser;
use Doctrine\ORM\EntityManager;

class LoadNewBets implements CommandInterface
{
    private TonCenterAPI $tonClient;
    private EntityManager $em;

    const TON_DNS_ROOT_ADDRESS = 'EQC3dNlesgVD8YbAazcauIrXBPfiVhMMr5YYk2in0Mtsz0Bz';
    const TRANSACTIONS_COUNT = 1000;

    public function __construct()
    {
        $this->tonClient = new TonCenterAPI;
        $this->em = getEntityManager();
    }

    public function handle(): void
    {
        $parser = new TransactionsParser;
        $startWith = [];
        $keepGoing = true;

        Log::info('[LoadNewBots] Start initial bets update.');

        while ($keepGoing) {
            $response = $this->tonClient->getTransactions(
                self::TON_DNS_ROOT_ADDRESS,
                self::TRANSACTIONS_COUNT,
                $startWith
            );

            $result = $response['result'];

            if (count($result) < self::TRANSACTIONS_COUNT) {
                $keepGoing = false;
            }

            $transactions = $parser->getTransactionsDTOs($result);

            $keepGoing &= $this->processTransactions($transactions);

            /** @var TransactionDTO $latestTransaction */
            $latestTransaction = $transactions[count($transactions) - 1];

            $startWith = [
                'lt' => $latestTransaction->transactionLt,
                'hash' => $latestTransaction->transactionHash,
            ];
        }

        Log::info('[LoadNewBots] Finish initial bets update.');
    }

    private function processTransactions(array $transactions): bool
    {
        $existingCount = 0;

        /** @var TransactionDTO $transaction */
        foreach ($transactions as $transaction) {
            if (!$transaction->isValid()) {
                continue;
            }

            $qb = $this->em->createQueryBuilder();

            $model = $qb->select('auctions')
                ->from(Auction::class, 'auctions')
                ->where('auctions.dns = ?0')
                ->setParameters([$transaction->inputMessage->message])
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            if ($model) {
                $existingCount++;
                continue;
            }

            $auction = new Auction($transaction->inputMessage->message, $transaction->outputMessages[0]->destination);
            $this->em->persist($auction);
            $this->em->flush();

            $bet = new Bet($auction, $transaction);
            $this->em->persist($bet);
        }

        $this->em->flush();

        return $existingCount < self::TRANSACTIONS_COUNT / 2;
    }
}