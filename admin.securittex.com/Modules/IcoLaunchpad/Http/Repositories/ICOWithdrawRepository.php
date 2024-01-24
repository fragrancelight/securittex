<?php

namespace Modules\IcoLaunchpad\Http\Repositories;

use App\Model\Wallet;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Modules\IcoLaunchpad\Entities\TokenBuyEarn;
use Modules\IcoLaunchpad\Entities\TokenWithdrawTransaction;

class ICOWithdrawRepository
{
    public function __construct()
    {
    }

    public function getEarnsData()
    {
        try {
            $data = TokenBuyEarn::where('user_id', getAuthUser()->id)->first();

            if (!isset($data)) {
                $data = new TokenBuyEarn;
                $data->user_id = getAuthUser()->id;
                $data->earn = 0;
                $data->withdraw = 0;
                $data->available = 0;
                $data->currency = 'USD';
            }
        } catch (\Exception $e) {
            storeException('getAllData repo', $e->getMessage());
            return (object) [];
        }
        return $data;
    }

    public function getDataOfTokenEarns($column)
    {
        try {
            $data = TokenBuyEarn::where('user_id', getAuthUser()->id)->first();
            if (isset($data->$column)) {
                return responseData(true, __('Success'), $data->$column);
            }
            return responseData(false, __('Faild'));
        } catch (\Exception $e) {
            storeException('getCurrencyOfTokenEarns', $e->getMessage());
            return responseData(false, __('Faild'));
        }
    }

    public function makeWithdrawalRequest($request, $price)
    {
        DB::beginTransaction();
        try {
            $default_currency = $this->getDataOfTokenEarns('currency');
            if (!$default_currency['success']) return (object) [];
            $data = [
                'user_id' => getAuthUser()->id,
                'request_amount' => $request->amount,
                'request_currency' => 'USD',
                'convert_amount' => $price['data']['price'],
                'convert_currency' => $request->currency_to,
                'tran_type' => $request->currency_type,
                'approved_status' => STATUS_PENDING,
            ];
            $withdrawal = TokenWithdrawTransaction::create($data);
            $earn = TokenBuyEarn::whereUserId(getAuthUser()->id)->first();
            $earn->decrement('available', $withdrawal->request_amount);
            $earn->increment('withdraw', $withdrawal->request_amount);
            $earn->save();
            DB::commit();
            return $withdrawal;
        } catch (\Exception $e) {
            DB::rollBack();
            storeException('makeWithdrawalRequest repo', $e->getMessage());
            return (object) [];
        }
    }

    public function IcoWithdrawAcceptRequest($id)
    {
        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $data = TokenWithdrawTransaction::findOrFail($id);
            if ($data->tran_type == CRYPTO_TYPE) {
                $response = $this->addCryptoToUserWallet($data->user_id, $data->convert_currency, $data->convert_amount);
                if (!$response['success']) {
                    storeBotException('IcoWithdrawAcceptRequest repo', $response['message']);
                    return false;
                }
            }
            $data->approved_status = STATUS_ACCEPTED;
            $data->approved_by_id = getAuthUser()->id;
            $data->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            storeException('IcoWithdrawAcceptRequest repo', $e->getMessage());
            return false;
        }
    }

    private function addCryptoToUserWallet($user_id, $coin_type, $balance)
    {
        try {
            $data = Wallet::where(['user_id' => $user_id, 'coin_type' => $coin_type])->first();
            if ($data) {
                $data->increment('balance', $balance);
                $data->save();
                return responseData(true, __("Wallet balance increment successfully"));
            }
            return responseData(false, __("Wallet not found"));
        } catch (\Exception $e) {
            storeException('addCryptoToUserWallet repo', $e->getMessage());
            return responseData(false, __("Something went wrong during update wallet balance"));
        }
    }

    public function IcoWithdrawRejectRequest($id)
    {
        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $data = TokenWithdrawTransaction::findOrFail($id);
            $data_token_buy = TokenBuyEarn::where('user_id', $data->user_id)->first();
            $data_token_buy->increment('available', $data->request_amount);
            $data_token_buy->decrement('withdraw', $data->request_amount);
            $data_token_buy->save();
            $data->approved_status = STATUS_REJECTED;
            $data->approved_by_id = getAuthUser()->id;
            $data->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            storeException('IcoWithdrawAcceptRequest repo', $e->getMessage());
            return false;
        }
    }
}
