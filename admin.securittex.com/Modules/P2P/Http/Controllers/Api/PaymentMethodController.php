<?php

namespace Modules\P2P\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\P2P\Http\Controllers\BaseController;
use Modules\P2P\Http\Service\PaymentMethodService;
use Modules\P2P\Http\Requests\Api\PaymentMethodRequest;

class PaymentMethodController extends BaseController
{
    private $service;

    public function __construct()
    {
        $this->service = new PaymentMethodService;
    }

    public function createPaymentMethod(PaymentMethodRequest $request)
    {
        try {
            $response = $this->service->createUserPaymentMethod($request);
            return $this->sendBackResponse($response, ['data' => false], 1);
        } catch (\Exception $e) {
            storeException(false, $e->getMessage());
            return response()->json(responseData(false, __("Something went wrong")));
        }
    }

    public function adminPaymentMethod()
    {
        try {
            $response = $this->service->getAdminPaymentMethod();
            return $this->sendBackResponse($response, [], 1);
        } catch (\Exception $e) {
            storeException(false, $e->getMessage());
            return response()->json(responseData(false, __("Something went wrong")));
        }
    }

    public function getPaymentMethod(Request $request)
    {
        try {
            $response = $this->service->getPaymentMethod($request);
            return $this->sendBackResponse($response, ['data' => true], 1);
        } catch (\Exception $e) {
            storeException(false, $e->getMessage());
            return response()->json(responseData(false, __("Something went wrong")));
        }
    }

    public function getPaymentMethodDetails($uid)
    {
        try {
            $response = $this->service->getPaymentMethodDetails($uid);
            return $this->sendBackResponse($response, ['data' => true], 1);
        } catch (\Exception $e) {
            storeException(false, $e->getMessage());
            return response()->json(responseData(false, __("Something went wrong")));
        }
    }
}
