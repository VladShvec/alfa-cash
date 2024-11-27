<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private CurrencyService $currencyService;

    /**
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @return JsonResponse
     */
    public function getYouGiveCurrencies(): JsonResponse
    {
        $currencies = $this->currencyService->getYouGiveCurrencies();
        return $this->successResponse(['currencies' => $currencies]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getYouReceiveCurrencies(Request $request): JsonResponse
    {
        $currencies = $this->currencyService
            ->getYouReceiveCurrencies($request->route('currency'));
        return $this->successResponse(['currencies' => $currencies]);
    }

    /**
     * @param CurrencyRequest $currencyRequest
     * @return JsonResponse
     */
    public function convertCurrencies(CurrencyRequest $currencyRequest): JsonResponse
    {
        try {
            return $this->successResponse($this->currencyService->convert($currencyRequest));
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }
    }
}
