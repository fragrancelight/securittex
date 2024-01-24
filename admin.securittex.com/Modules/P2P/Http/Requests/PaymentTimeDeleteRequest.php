<?php

namespace Modules\P2P\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentTimeDeleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:p_payment_times,uid',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __("Payment time id is required"),
            'id.exists' => __("Payment time id is invalid"),
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