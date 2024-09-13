<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TokenPriceService
{
    protected $client;
    protected $tokenAddress = '0x57a99610a5970af1f5e5e7792e66fd76ec598b4f';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchTokenPrice()
    {
        try {
            $response = $this->client->request('GET', 'https://api.dexscreener.com/latest/dex/pairs/bsc/' . $this->tokenAddress);
            $data = json_decode($response->getBody(), true);

            if (isset($data['pairs']) && count($data['pairs']) > 0) {
                $priceUsd = $data['pairs'][0]['priceUsd'];
                return $priceUsd;
            } else {
                Log::info('MMGT PRICE data not found');
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching MMGT price: ' . $e->getMessage());
            return null;
        }
    }
}
