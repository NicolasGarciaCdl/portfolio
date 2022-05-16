<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getLast(): array
    {

        $response = $this->client->request(
            'GET',
            'https://hebdoo.fr/api/last'
        );
        return $response->toArray();
    }
}