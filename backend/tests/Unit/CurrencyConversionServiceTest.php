<?php

namespace Tests\Unit;

use App\Services\CurrencyConversionService;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;

class CurrencyConversionServiceTest extends TestCase
{
    public function testConvertSuccess()
    {
        // Mocking the pairs in cache

        Cache::shouldReceive('get')
            ->with('pairs')
            ->andReturn([
                [
                    "destination_max" => "1977.36722300",
                    "destination_min" => "15.65801000",
                    "destination_name" => "trc20usdt",
                    "id" => 2,
                    "rate" => "1.06285833",
                    "source_max" => "2105.91000000",
                    "source_min" => "21.06000000",
                    "source_name" => "usd",
                ],
            ]);

        $service = new CurrencyConversionService();

        $request = (object) [
            'giveCurrency' => [
                "id" => 2,
                "name" => "usd",
                "ticker" => "USD"
            ],
            'receiveCurrency' => [
                'created_at' => null,
                'destination_max' => '1977.36722300',
                'destination_min' => '15.65801000',
                'destination_name' => 'trc20usdt',
                'id' => 2,
                'rate' => '1.06285833',
                'source_max' => '2105.91000000',
                'source_min' => '21.06000000',
                'source_name' => 'usd',
                'updated_at' => null,
                'type' => 'sheepy',
            ],
            'amount' => 100,
        ];

        $result = $service->convert($request);

        $this->assertEquals('usd', $result['source_currency']);
        $this->assertEquals('trc20usdt', $result['destination_currency']);
        $this->assertEquals(100, $result['source_amount']);
        $this->assertEquals(106.28583300000001, $result['converted_amount']);
    }
}
