<?php
namespace App\Services;
use App\Repositories\CurrencyRepository;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    private $currencyRepository;
    private $currencyConversionService;
    private $binanceConversionService;

    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyConversionService $currencyConversionService,
        BinanceConversionService $binanceConversionService
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyConversionService = $currencyConversionService;
        $this->binanceConversionService = $binanceConversionService;
    }

    /**
     * @return Collection
     */
    public function getYouGiveCurrencies(): Collection
    {
        return $this->currencyRepository->getYouGiveCurrencies();
    }

    /**
     * @param $currency
     * @return Collection
     */
    public function getYouReceiveCurrencies($currency): Collection
    {
        return $this->currencyRepository->getYouReceiveCurrencies($currency);
    }

    /**
     * @param $request
     * @return array|string[]
     * @throws \Exception
     */
    public function convert($request): array
    {
        if($request->receiveCurrency['type'] === 'sheepy') {
            return $this->currencyConversionService->convert($request);
        }else {
            return $this->binanceConversionService->convert($request);
        }
    }
}
