<?php

namespace Modules\P2P\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;
use Modules\P2P\Entities\PPaymentMethod;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $payment_type = PPaymentMethod::where("uid",$_POST["payment_uid"] ?? "")->first();
        $payment_type = $payment_type->payment_type ?? 0;
        $rule = [
            'uid' => 'exists:p_user_payment_methods',
            // 'delete' => 'exists:p_user_payment_methods,uid',
            'payment_uid' => 'required|exists:p_payment_methods,uid',
            'username' => 'required',
            // PAYMENT_METHOD_BANK
            'bank_name' => [new RequiredIf($payment_type == PAYMENT_METHOD_BANK)],
            'bank_account_number' => [new RequiredIf($payment_type == PAYMENT_METHOD_BANK),'numeric'],
            'account_opening_branch' => [new RequiredIf($payment_type == PAYMENT_METHOD_BANK)],
            'transaction_reference' => [new RequiredIf($payment_type == PAYMENT_METHOD_BANK)],
            // PAYMENT_METHOD_MOBILE
            'mobile_account_number' => [new RequiredIf($payment_type == PAYMENT_METHOD_MOBILE),'numeric'],
            // PAYMENT_METHOD_CARD
            'card_number' => [new RequiredIf($payment_type == PAYMENT_METHOD_CARD),'numeric'],
            'card_type' => [new RequiredIf($payment_type == PAYMENT_METHOD_CARD),'numeric', 'in:'.PAYMENT_METHOD_CARD_TYPE_DEBIT.','.PAYMENT_METHOD_CARD_TYPE_CREDIT],
        ];
        if(isset($this->delete)){
            $rule = [ 'delete' => 'exists:p_user_payment_methods,uid' ];
        }
        return $rule;
    }

    public function messages()
    {
        return [
            'uid.exists' => __("Payment Method is invalid"),
            'delete.exists' => __("Payment Method is invalid"),

            'payment_uid.required_without' => __("Payment id is required"),
            'payment_uid.exists' => __("Payment is invalid"),

            'username.required_without' => __("Username is required"),
            'username.string' => __("Username must be a valid string"),
            // PAYMENT_METHOD_BANK
            'bank_name.required_if' => __("Bank name is required"),
            'bank_account_number.required_if' => __("Bank account number is required"),
            'bank_account_number.numeric' => __("Bank account number must be valid number"),
            'account_opening_branch.required_if' => __("Bank account opening branch is required"),
            'transaction_reference.required_if' => __("Bank transaction reference is required"),
            // PAYMENT_METHOD_MOBILE
            'mobile_account_number.required_if' => __("Mobile account number is required"),
            'mobile_account_number.numeric' => __("Mobile account number is invalid"),
             // PAYMENT_METHOD_CARD
            'card_number.required_if' => __("Card number is required"),
            'card_number.numeric' => __("Card number is invalid"),
            'card_type.in' => __("Card type is invalid"),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        if ($validator->fails()) {
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
        }
        $json = [
            'success'=>false,
            'message' => $errors[0],
        ];
        $response = new JsonResponse($json, 200);
        throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
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
