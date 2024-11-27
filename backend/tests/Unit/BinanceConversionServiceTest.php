<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BinanceConversionService;
use Illuminate\Support\Facades\Cache;

class BinanceConversionServiceTest extends TestCase
{
    public function testConvertSuccess()
    {
        // Mocking the trading pairs in cache
        Cache::shouldReceive('get')
            ->with('traiding_pairs')
            ->andReturn([
                'EUR/USDT' => ['last' => 1.0525],
            ]);
        $service = new BinanceConversionService();

        $request = (object) [
            'receiveCurrency' => ['base' => 'EUR', 'quote' => 'USDT'],
            'amount' => 100,
        ];

        $result = $service->convert($request);

        $this->assertEquals('EUR', $result['base_currency']);
        $this->assertEquals('USDT', $result['quote_currency']);
        $this->assertEquals(100, $result['base_amount']);
        $this->assertEquals(1.0525, $result['rate']);
        $this->assertEquals(105.25, $result['final_amount']);
    }

    public function testConvertThrowsExceptionForMissingPrice()
    {
        Cache::shouldReceive('get')
            ->with('traiding_pairs')
            ->andReturn([
                'EUR/USDT' => ['last' => 0],
            ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The correct price is missing for the EUR/USDT pair.');

        $service = new BinanceConversionService();

        $request = (object) [
            'receiveCurrency' => ['base' => 'EUR', 'quote' => 'USDT'],
            'amount' => 100,
        ];

        $service->convert($request);
    }
}
