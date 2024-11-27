<?php
namespace App\Repositories;
use App\Models\Currency;
use App\Models\Pair;
use App\Models\TraidingPair;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository
{
    /**
     * @return Collection
     */
    public function getYouGiveCurrencies(): Collection
    {
        return Currency::all(['id', 'ticker', 'name']);
    }

    /**
     * @param $currency
     * @return Collection
     */
    public function getYouReceiveCurrencies($currency): Collection
    {
        $sheepyPairs = Pair::query()
            ->where('source_name', $currency)
            ->get();

        $traidingPairs = TraidingPair::query()
            ->where('base', strtoupper($currency))
            ->get();

        return $sheepyPairs->merge($traidingPairs);
    }
}
