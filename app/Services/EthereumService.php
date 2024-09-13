<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class EthereumService
{
    private $client;
    private $infuraApiKey;

    public function __construct()
    {
        $this->infuraApiKey = env('INFURA_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://sepolia.infura.io/v3/' . $this->infuraApiKey,
        ]);
    }

    public function getTransactionDetails($transactionHash)
    {
        try {
            $response = $this->client->post('http://localhost:3000/transaction-details', [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(['transactionHash' => $transactionHash])
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                Log::info('EthereumService - Raw Response:', $data); // Log the raw response
                return [
                    'smartContractAddress' => $data['smartContractAddress'] ?? null,
                    'adminWalletAddress' => $data['adminWalletAddress'] ?? null,
                    'transactionValue' => $data['transactionValue'] ?? null
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception in EthereumService: ' . $e->getMessage());
            return null;
        }
    }

}
