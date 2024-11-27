<?php
namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\SheepyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchSheepyCurrenciesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:fetch-sheepy-currencies-command';
    /**
     * @var string
     */
    protected $description = 'Fetch currencies and rates from Sheepy API';
    /**
     * @var SheepyService
     */
    private SheepyService $sheepyService;

    public function __construct()
    {
        parent::__construct();
        $this->sheepyService = new SheepyService();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->sheepyService->fetchCurrency();
            $this->info('Sheepy currencies fetched successfully.');
        } catch (\Exception $e) {
            $this->error('Failed to fetch Sheepy currencies.');
            $this->error('Response: ' . $e->getMessage());
        }
    }
}
