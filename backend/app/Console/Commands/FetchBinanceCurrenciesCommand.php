<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\TraidingPair;
use App\Services\BinanceService;
use App\Traits\Cachable;
use Illuminate\Console\Command;

class FetchBinanceCurrenciesCommand extends Command
{
    use Cachable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-binance-currencies-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currencies and rates from Binance';
    private BinanceService $binanceService;

    public function __construct(BinanceService $binanceService)
    {
        parent::__construct();
        $this->binanceService = $binanceService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->trucateTraidingPairs();
            $traidingPairs = $this->binanceService->fetchCurrenciesAndRates();
            $this->fillTraidingPairs($traidingPairs);
            $this->info('Binance currencies fetched successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to fetch Binance currencies.');
            $this->error('Response: ' . $e->getMessage());
        }
    }

    /**
     * @param $traidingPairs
     * @return void
     */
    public function fillTraidingPairs($traidingPairs): void
    {
        $this->remember('traiding_pairs', function () use ($traidingPairs) {
            TraidingPair::query()->insert($traidingPairs);
            return $traidingPairs;
        }, 86400);
    }

    /**
     * @return void
     */
    public function trucateTraidingPairs(): void
    {
        $this->forget('traiding_pairs');
        TraidingPair::query()->truncate();
    }
}
