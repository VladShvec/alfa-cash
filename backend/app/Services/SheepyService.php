<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Destination;
use App\Models\Pair;
use App\Traits\Cachable;
use Illuminate\Support\Facades\Http;

class SheepyService
{
    use Cachable;

    const API_SHEEPY_ENDPOINT = '/api-partner/v1/onramp/currencies';
    const REQUEST_METHOD_GET = 'GET';
    protected mixed $apiKey;
    protected mixed $secretKey;
    protected string $url;

    public function __construct()
    {
        $this->apiKey = config('services.sheepy.api_key');
        $this->secretKey = config('services.sheepy.secret_key');
        $this->url = config('services.sheepy.api_url') . SheepyService::API_SHEEPY_ENDPOINT;
    }

    /**
     * @return void
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function fetchCurrency(): void
    {
        $this->truncateSheepyTables();
        $headers = $this->generateHeaders($this->apiKey, $this->secretKey);
        $response = Http::withHeaders($headers)->get($this->url);

        if ($response->ok()) {
            $currencies = $response->json();

            $this->fillSheepyCurrencies($currencies['data']['sources']);
            $this->fillDestinations($currencies['data']['destinations']);
            $this->fillSheepyPairs($currencies['data']['pairs']);
        } else {
            throw new \Exception('Error fetching currencies');
        }
    }

    /**
     * @param string $apiKey
     * @param string $secretKey
     * @return array
     */
    private function generateHeaders(string $apiKey, string $secretKey): array
    {
        $timestamp = now()->timestamp;
        $signature = $this->generateSignature($secretKey, $timestamp);

        return [
            'X-Token' => $apiKey,
            'X-Signature' => $signature,
            'X-Timestamp' => strval($timestamp),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * @param string $secretKey
     * @param string $timestamp
     * @return string
     */
    private function generateSignature(string $secretKey, string $timestamp): string
    {
        return hash_hmac(
            'sha256', $timestamp . strtoupper(
                SheepyService::REQUEST_METHOD_GET
            ) . $this->url, $secretKey
        );
    }

    /**
     * @param mixed $sources
     * @return void
     */
    private function fillSheepyCurrencies(mixed $sources): void
    {
        $this->remember('currencies', function () use ($sources) {
            Currency::query()->insert($sources);
            return $sources;
        }, 86400);
    }

    /**
     * @param mixed $destinations
     * @return void
     */
    private function fillDestinations(mixed $destinations): void
    {
        $this->remember('destinations', function () use ($destinations) {
            Destination::query()->insert($destinations);
            return $destinations;
        }, 86400);
    }

    /**
     * @param mixed $pairs
     * @return void
     */
    private function fillSheepyPairs(mixed $pairs): void
    {
        $this->remember('pairs', function () use ($pairs) {
            Pair::insert($pairs);
            return $pairs;
        }, 86400);
    }

    /**
     * @return void
     */
    private function truncateSheepyTables(): void
    {
        $this->forget('currencies');
        $this->forget('destinations');
        $this->forget('pairs');
        Currency::query()->truncate();
        Destination::query()->truncate();
        Pair::query()->truncate();
    }
}
