<?php

namespace App\Commands;

use App\DTO\BetDTO;
use App\Interfaces\CommandInterface;
use App\Models\Auction;
use App\Models\Bet;
use App\Services\TonCenterAPI;

class LoadNewBets implements CommandInterface
{
    private TonCenterAPI $tonClient;

    const TON_DNS_ROOT_ADDRESS = 'EQC3dNlesgVD8YbAazcauIrXBPfiVhMMr5YYk2in0Mtsz0Bz';
    const TRANSACTIONS_COUNT = 100;

    public function __construct()
    {
        $this->tonClient = new TonCenterAPI;
    }

    public function handle(): void
    {
        $startWith = [];
        $keepGoing = true;

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

            $keepGoing &= $this->processTransactions($result);

            $latestTransaction = $result[count($result) - 1];

            $startWith = [
                'lt' => $latestTransaction['transaction_id']['lt'],
                'hash' => $latestTransaction['transaction_id']['hash'],
            ];

            var_dump($startWith['lt']);
        }
    }

    private function processTransactions(array $transactions): bool
    {
        $existingCount = 0;
        $auctions = [];
        $em = getEntityManager();

        foreach ($transactions as $transaction) {
            if (!$this->isValid($transaction)) {
                continue;
            }

            $betDTO = BetDTO::fromTransaction($transaction);

            $qb = $em->createQueryBuilder();
            $model = $qb->select('bets')
                ->from(Bet::class, 'bets')
                ->where('bets.transactionLt = ?0 AND bets.transactionHash = ?1')
                ->setParameters([$betDTO->transactionLt, $betDTO->transactionHash])
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();

            if (!is_null($model)) {
                $existingCount++;
            } else {
                $bet = new Bet($betDTO);
                $em->persist($bet);

                $auctions[] = [
                    'bet' => $bet,
                    'at' => $transaction['out_msgs'][0]['destination']
                ];
            }
        }

        $em->flush();

        foreach ($auctions as $auction)
        {
            /** @var Bet $firstBet */
            $firstBet = $auction['bet'];

            $auction = new Auction($firstBet->getId(), $auction['at']);

            $em->persist($auction);
        }

        $em->flush();

        return $existingCount < self::TRANSACTIONS_COUNT / 2;
    }

    private function isValid(array $transaction): bool
    {
        if (empty(trim($transaction['in_msg']['message']))) {
            return false;
        }

        if (empty($transaction['out_msgs'])) {
            return false;
        }

        if ($transaction['in_msg']['source'] === $transaction['out_msgs'][0]['destination']) {
            return false;
        }

        return true;
    }
}