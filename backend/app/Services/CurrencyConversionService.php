<?php
namespace App\Services;

use App\Traits\Cachable;

class CurrencyConversionService
{
    use Cachable;

    public function convert(
        $request
    ): array
    {
        $pairs = $this->getByKey('pairs');
        $sourceName = $request->giveCurrency['name'];
        $destinationName = $request->receiveCurrency['destination_name'];
        $amount = $request->amount;
        $destinationDetails = $request->receiveCurrency;

        $pair = collect($pairs)->first(function ($pair) use ($sourceName, $destinationName) {
            return $pair['source_name'] === $sourceName && $pair['destination_name'] === $destinationName;
        });

        if (!$pair) {
            throw new \Exception("Pair $sourceName -> $destinationName not found.");
        }

        if ($amount < $pair['source_min'] || $amount > $pair['source_max']) {
            throw new \Exception(
                "The amount $amount exceeds the allowed limits: from {$pair['source_min']} to {$pair['source_max']}."
            );
        }
        $amountBigDecimal = $amount;
        $pairBigDecimal = $pair['rate'];

        $convertedAmount = $amountBigDecimal * $pairBigDecimal;
        if ($convertedAmount < $pair['destination_min'] || $convertedAmount > $pair['destination_max']) {
            throw new \Exception(
                "The result $convertedAmount exceeds the limits for $destinationName: from {$pair['destination_min']} to {$pair['destination_max']}."
            );
        }

        $withdrawalFee = $destinationDetails['withdrawal_fee'] ?? 0;
        $finalAmount = $convertedAmount - $withdrawalFee;

        if ($finalAmount < 0) {
            throw new \Exception(
                "The final amount $finalAmount after deducting the fee ($withdrawalFee) is less than zero."
            );
        }

        return [
            'source_currency' => $sourceName,
            'destination_currency' => $destinationName,
            'source_amount' => $amount,
            'converted_amount' => $convertedAmount,
            'final_amount' => $finalAmount,
            'withdrawal_fee' => $withdrawalFee,
        ];
    }
}
