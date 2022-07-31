<?php

namespace App\Services;

use GuzzleHttp\Client;

class TonCenterAPI
{
    private Client $httpClient;

    private string $apiKey;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://toncenter.com/api/v2/',
            'timeout' => 10,
        ]);

        $this->apiKey = env('TON_CENTER_TOKEN');
    }

    public function getTransactions(string $address, int $count = 10, array $startWith = []): array
    {
        return $this->getMethod('getTransactions', [
                'address' => $address,
                'limit' => $count,
            ] + $startWith);
    }

    private function getMethod(string $method, array $params): array
    {
        $response = $this->httpClient->get($method . '?' . http_build_query($params), [
            'headers' => [
                'x-api-key' => $this->apiKey,
            ]
        ]);

        $data = $response->getBody()->getContents();

        return json_decode($data, true);
    }
}