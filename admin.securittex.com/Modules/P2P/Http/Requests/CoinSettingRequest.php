<?php

namespace Modules\P2P\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coin_type' => 'required|exists:coins',
            'buy_fees' => 'numeric',
            'sell_fees' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'coin_type.required' => __("Coin type is required"),
            'coin_type.exists' => __("Coin type is invalid"),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
