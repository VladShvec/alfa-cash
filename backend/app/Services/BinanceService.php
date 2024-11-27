<?php

namespace App\Services;

use ccxt\binance;

class BinanceService
{
    protected $binance;

    public function __construct()
    {
        $this->binance = new binance([]);
    }

    public function fetchCurrenciesAndRates()
    {
        try {
            $markets = $this->binance->load_markets();
            $tickers = $this->binance->fetch_tickers();

            $result = [];
            foreach ($markets as $symbol => $market) {
                $result[$symbol] = [
                    'base' => $market['base'],
                    'quote' => $market['quote'],
                    'last' => $tickers[$symbol]['last'] ?? null,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
