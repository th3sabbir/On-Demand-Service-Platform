<?php

namespace Modules\GlobalSetting\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\GlobalSetting\app\Models\AvailableCurrency;
use Modules\GlobalSetting\app\Models\Currency;

class CurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currencyId = $this->input('id') ?? $this->route('id');

        return [
            'available_currency_id' => ['nullable', 'exists:available_currencies,id'],
            'name' => [
                'required_without:available_currency_id',
                'string',
                'max:255',
                Rule::unique('currencies', 'name')->ignore($currencyId),
            ],
            'code' => [
                'required_without:available_currency_id',
                'string',
                'max:10',
                Rule::unique('currencies', 'code')->ignore($currencyId),
            ],
            'symbol' => ['required_without:available_currency_id', 'string', 'max:10'],
            'is_default' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'available_currency_id.exists' => __('Currency not found'),
            'name.required_without' => __('Currency name is required'),
            'code.required_without' => __('Currency code is required'),
            'symbol.required_without' => __('Currency symbol is required'),
        ];
    }
}