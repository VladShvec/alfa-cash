<?php
namespace App\Services;

use App\Traits\Cachable;

class BinanceConversionService
{
    use Cachable;

    public function convert($request)
    {
        $base = $request->receiveCurrency['base'];
        $quote = $request->receiveCurrency['quote'];
        $amount = $request->amount;
        $binancePairs = $this->getByKey('traiding_pairs');
        $pairKey = $base . '/' . $quote;
        $pair = $binancePairs[$pairKey];

        // Проверить наличие цены
        if ($pair['last'] <= 0) {
            throw new \Exception(
                "The correct price is missing for the {$base}/{$quote} pair.",
            );
        }

        $rate = $pair['last'];
        $convertedAmount = $amount * $rate;

        return [
            'base_currency' => $base,
            'quote_currency' => $quote,
            'base_amount' => $amount,
            'rate' => $rate,
            'final_amount' => $convertedAmount,
        ];
    }
}
