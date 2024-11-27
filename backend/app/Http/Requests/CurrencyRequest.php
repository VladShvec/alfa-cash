<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $receiveCurrencyRules = request()->get('receiveCurrency')['type'] &&
        request()->get('receiveCurrency')['type'] === 'sheepy' ? [
            'receiveCurrency.id' => 'required|integer|min:1',
            'receiveCurrency.destination_max' => 'required|numeric|gt:receiveCurrency.destination_min',
            'receiveCurrency.destination_min' => 'required|numeric|lt:receiveCurrency.destination_max',
            'receiveCurrency.destination_name' => 'required|string|max:255',
            'receiveCurrency.rate' => 'required|numeric|min:0',
            'receiveCurrency.source_max' => 'required|numeric|gt:receiveCurrency.source_min',
            'receiveCurrency.source_min' => 'required|numeric|lt:receiveCurrency.source_max',
            'receiveCurrency.source_name' => 'required|string|max:255',
            'receiveCurrency.type' => 'required|string|in:sheepy,other',
        ] : [
            'type' => 'required|string|in:binance,other',
            'base' => 'required|string|max:10',
            'created_at' => 'nullable|date',
            'id' => 'required|integer|min:1',
            'last' => 'required|numeric|min:0',
            'quote' => 'required|string|max:10',
            'updated_at' => 'nullable|date',
        ];
        return [
            'giveCurrency.id' => 'required|integer|min:1',
            'giveCurrency.name' => 'required|string|max:255',
            'giveCurrency.ticker' => 'required|string|max:10',
            $receiveCurrencyRules,
            'amount' => 'required|numeric|min:1',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'giveCurrency.id.required' => 'The give currency ID is required.',
            'receiveCurrency.destination_max.gt' => 'The destination max must be greater than destination min.',
            'receiveCurrency.source_max.gt' => 'The source max must be greater than source min.',
            'amount.required' => 'The amount is required and must be a positive number.',
        ];
    }
}
