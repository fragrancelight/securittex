<?php
namespace Modules\P2P\Http\Service;

use Modules\P2P\Entities\PPaymentMethod;
use Modules\P2P\Entities\PUserPaymentMethod;
use Modules\P2P\Http\Repository\PaymentMethodRepository;

class PaymentMethodService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PaymentMethodRepository();
    }

    public function getCountry()
    {
        try {
            return $this->repo->getCountry();
        } catch (\Exception $e) {
            storeException('getCountry p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function paymentMethodFind($uid)
    {
        try {
            $data = [
                'where' => ['uid', $uid],
                'first' => []
            ];
            $paymentMethod = $this->repo->getModelData(PPaymentMethod::class,$data);
            if ($paymentMethod['success']) $paymentMethod['message'] = __('Payment method found successfully');
            else $paymentMethod['message'] = __('Payment method not found');
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('paymentMethodFind p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function getAllPaymentMethod()
    {
        try {
            $paymentMethod = $this->repo->getModelData(PPaymentMethod::class,['get' => []]);
            if ($paymentMethod['success']) $paymentMethod['message'] = __('Payment methods found successfully');
            else $paymentMethod['message'] = __('Payment methods not found');
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('getAllPaymentMethod p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function paymentMethodDelete($request)
    {
        try {
            $query = [
                'where' => ['uid', $request->id],
                'first' => []
            ];
            $paymentMethod = $this->repo->getModelData(PPaymentMethod::class,$query);
            if($paymentMethod['success']){
                uploadFilep2p('', PAYMENT_METHOD_LOGO_PATH, $paymentMethod['data']->logo ?? '');
            }
            $query = [
                'where' => ['uid', $request->id],
                'delete' => []
            ];
            $paymentMethod = $this->repo->getModelData(PPaymentMethod::class,$query);
            if ($paymentMethod['success']) $paymentMethod['message'] = __('Payment methods deleted successfully');
            else $paymentMethod['message'] = __('Payment methods deleted failed');
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('paymentMethodDelete p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function userPaymentMethodDelete($request)
    {
        try {
            $query = [
                'where' => ['uid', $request->delete ?? ''],
                ['where' => ['user_id', authUserId_p2p() ?? '']],
                'delete' => []
            ];
            $paymentMethod = $this->repo->getModelData(PUserPaymentMethod::class,$query);
            if ($paymentMethod['success']) $paymentMethod['message'] = __('Payment methods deleted successfully');
            else $paymentMethod['message'] = __('Payment methods deleted failed');
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('userPaymentMethodDelete p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function getPaymentMethod($request)
    {
        try {
            $query = [
                ['where' => ['user_id', authUserId_p2p() ?? '']],
                'with' => ['adminPamyntMethod'],
                'paginate' => [$request->per_page ?? 5]
            ];
            $paymentMethod = $this->repo->getModelData(PUserPaymentMethod::class,$query);
            if ($paymentMethod['success']) $paymentMethod['message'] = __('Payment methods found successfully');
            else $paymentMethod['message'] = __('Payment methods not found');
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('getPaymentMethod p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function paymentMethodSave($request)
    {
        try {
            $successRes = __("Payment method created successfully");
            $errorRes = __("Payment method failed to create");
            if(isset($request->uid)){
                $successRes = __("Payment method updated successfully");
                $errorRes = __("Payment method failed to updated");
            }
            $data = [
                'find' => [ 'uid' => $request->uid ?? '' ],
                'data' => [
                    'name' => $request->name,
                    'payment_type' => $request->payment_type,
                    'country' => implode('|',$request->country),
                    'status' => $request->status,
                    'note' => $request->note ?? '',
                ]
            ];
            if ($request->hasFile('logo')) {
                if(isset($request->uid)){
                    $paymentData = $this->paymentMethodFind($request->uid);
                    if($paymentData['success']){
                        $data['data']['logo'] = uploadFilep2p(
                            $request->file('logo'),
                            PAYMENT_METHOD_LOGO_PATH,
                            $paymentData['data']->logo ?? ''
                        );
                    }
                }
                else $data['data']['logo'] = uploadFilep2p($request->file('logo'), PAYMENT_METHOD_LOGO_PATH);
            }
            if(!isset($request->uid)) $data['data']['uid'] = pMakeUniqueId();
            $response = $this->repo->paymentMethodSave($data);
            if ($response['success']) $response['message'] = $successRes;
            else $response['message'] = $errorRes;
            return $response;
        } catch (\Exception $e) {
            storeException('getCountry p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function getAdminPaymentMethod()
    {
        try {
            if(authUserId_p2p()){
                $query = [
                    "where" => [ "status", STATUS_ACTIVE ],
                    "get" => [['uid', 'name', "payment_type"]]
                ];
                $result = $this->repo->getModelData(PPaymentMethod::class,$query);
                if(isset($result['success']) && !$result['success'])
                $result['message'] = __("Admin Payment Methods get faild");
                $result['message'] = __("Admin Payment Methods get successfully");
                return $result;
            }
            return responseData(false, __("Something went wrong"));
        } catch (\Exception $e) {
            storeException("getAdminPaymentMethod", $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function getPaymentMethodDetails($uid)
    {
        try {
            if($paymentMethod = PUserPaymentMethod::where('uid', $uid)->with('adminPamyntMethod')->first()){
               return responseData(true, __("Payment Method found successfully"), $paymentMethod);
            }
            return responseData(false, __("Payment Method not found"));
        } catch (\Exception $e) {
            storeException("getPaymentMethodDetails", $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }

    public function createUserPaymentMethod($request)
    {
        try {
            if(isset($request->delete)) return $this->userPaymentMethodDelete($request);
            $payment_type = PPaymentMethod::where("uid",$_POST["payment_uid"] ?? "")->first();

            $payment_type = $payment_type->payment_type ?? 0;
            $data = ['find' => [ 'uid' => $request->uid ?? '' ]];
            $successRes = __("Payment method created successfully");
            $errorRes = __("Payment method failed to create");
            if(isset($request->uid)){
                $successRes = __("Payment method updated successfully");
                $errorRes = __("Payment method failed to updated");
            }
            if(isset($payment_type) && $payment_type == PAYMENT_METHOD_BANK)
            {
                if(isset($request->bank_name) && !empty($request->bank_name))
                    $data['data']['bank_name'] = $request->bank_name;
                if(isset($request->bank_account_number) && !empty($request->bank_account_number))
                    $data['data']['bank_account_number'] = $request->bank_account_number;
                if(isset($request->account_opening_branch) && !empty($request->account_opening_branch))
                    $data['data']['account_opening_branch'] = $request->account_opening_branch;
                if(isset($request->transaction_reference) && !empty($request->transaction_reference))
                    $data['data']['transaction_reference'] = $request->transaction_reference;
            }

            if(isset($payment_type) && $payment_type == PAYMENT_METHOD_CARD)
            {
                if(isset($request->card_number) && !empty($request->card_number))
                    $data['data']['card_number'] = $request->card_number;
                if(isset($request->card_type) && !empty($request->card_type))
                    $data['data']['card_type'] = $request->card_type;
            }

            if(isset($payment_type) && $payment_type == PAYMENT_METHOD_MOBILE)
            {
                if(isset($request->mobile_account_number) && !empty($request->mobile_account_number))
                    $data['data']['mobile_account_number'] = $request->mobile_account_number;
            }
            if (!isset($request->uid)) {
                $data['data']['uid'] = pMakeUniqueId();
                $data['data']['payment_uid'] = $request->payment_uid;
                $data['data']['user_id'] = authUserId_p2p();
                $data['data']['payment_type'] = $payment_type;
            } $data['data']['username'] = $request->username;//authUser_p2p()->first_name;
            $paymentMethod = $this->repo->createOrUpdate(PUserPaymentMethod::class,$data);
            if ($paymentMethod['success']) $paymentMethod['message'] = $successRes;
            else $paymentMethod['message'] = $errorRes;
            return $paymentMethod;
        } catch (\Exception $e) {
            storeException('createUserPaymentMethod p2p', $e->getMessage());
            return responseData(false, __("Something went wrong"));
        }
    }
}
