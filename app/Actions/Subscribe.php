<?php

namespace App\Actions;

use App\Models\Subscription;
use Exception;

class Subscribe extends AbstractAction
{
    public function process(): string
    {
        $message = $this->update->getMessage()->getText();
        $messagePieces = explode(' ', $message);

        if (count($messagePieces) < 2) {
            return 'Usage: /watch durov';
        }

        try {
            $domain = $this->getDomain($messagePieces[1]);
        } catch (Exception $e) {
            return 'Invalid domain, it should be 4 to 126 characters. ' .
                'Latin letters (a-z), numbers (0-9) and hyphens (-) are allowed. ' .
                'A hyphen cannot be at the beginning or end.';
        }

        $subscription = new Subscription($this->update->getMessage()->getChat()->getId(), $domain);

        $em = getEntityManager();

        $em->persist($subscription);
        $em->flush();

        return "You have successfully subscribed on $domain.ton";
    }

    private function getDomain(string $domain): string
    {
        if (str_contains($domain, '.')) {
            $domain = explode('.', $domain)[0];
        }

        $domain = mb_strtolower($domain);

        $isValid = preg_match('/^[a-z\d][a-z\d\-]{2,124}[a-z\d]$/', $domain) === 1;

        if (!$isValid) {
            throw new Exception('Invalid domain');
        }

        return $domain;
    }
}